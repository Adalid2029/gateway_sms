<?php

namespace App\Models\Gateway\SMS;

use CodeIgniter\Model;
use Config\GatewayAvailability;
use App\Libraries\Gateway\GatewayClock;

class SupplierDeviceModel extends Model
{
    protected $table            = 'dispositivo_proveedor_gateway';
    protected $primaryKey       = 'id_dispositivo_proveedor_gateway';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_users_proveedor_sms',
        'id_instalacion',
        'id_sesion_servicio',
        'fabricante',
        'modelo',
        'version_android',
        'version_app',
        'numero_build',
        'estado_servicio',
        'estado_configuracion',
        'codigo_error_configuracion',
        'tipo_red',
        'red_validada',
        'sim_disponible',
        'cantidad_sim',
        'slot_sim_seleccionado',
        'operadora_sim',
        'optimizacion_bateria_ignorada',
        'porcentaje_bateria',
        'cargando_bateria',
        'servicio_iniciado_en',
        'ultimo_latido_en',
        'lease_expires_at',
        'ultimo_poll_intento_en',
        'ultimo_poll_exitoso_en',
        'ultimo_sms_enviado_en',
        'ultima_confirmacion_sms_en',
        'fallos_consecutivos',
        'codigo_ultimo_error',
        'mensaje_ultimo_error',
        'ultimo_error_en',
        'token_fcm',
        'token_fcm_actualizado_en',
        'ultimo_push_fcm_en',
        'ultimo_fcm_recibido_en',
        'activo',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getLatestDeviceForProvider(int $providerId): ?array
    {
        return $this->where('id_users_proveedor_sms', $providerId)
            ->orderBy('activo', 'DESC')
            ->orderBy('ultimo_latido_en', 'DESC')
            ->orderBy('id_dispositivo_proveedor_gateway', 'DESC')
            ->first();
    }

    public function getLatestDevicesByProviderIds(array $providerIds): array
    {
        $providerIds = array_values(array_unique(array_map('intval', $providerIds)));
        $providerIds = array_filter($providerIds, static fn (int $id): bool => $id > 0);

        if ($providerIds === []) {
            return [];
        }

        $rows = $this->whereIn('id_users_proveedor_sms', $providerIds)
            ->orderBy('id_users_proveedor_sms', 'ASC')
            ->orderBy('activo', 'DESC')
            ->orderBy('ultimo_latido_en', 'DESC')
            ->orderBy('id_dispositivo_proveedor_gateway', 'DESC')
            ->get()
            ->getResultArray();

        $devicesByProviderId = [];

        foreach ($rows as $row) {
            $providerId = (int) $row['id_users_proveedor_sms'];

            if (!array_key_exists($providerId, $devicesByProviderId)) {
                $devicesByProviderId[$providerId] = $row;
            }
        }

        return $devicesByProviderId;
    }

    public function getPushEligibleDeviceForProvider(int $providerId): ?array
    {
        $devices = $this->getPushEligibleDevicesForProvider($providerId);

        return $devices[0] ?? null;
    }

    public function getPushEligibleDevices(): array
    {
        $rows = $this->baseWakeCandidateQuery()
            ->findAll();

        return $this->selectCurrentWakeCandidatesByProvider($rows);
    }

    public function getPushEligibleDevicesForProvider(int $providerId): array
    {
        $rows = $this->baseWakeCandidateQuery()
            ->where('id_users_proveedor_sms', $providerId)
            ->findAll();

        $devices = array_map(fn (array $row): array => $this->withWakeSelectionMetadata($row), $rows);
        usort($devices, fn (array $left, array $right): int => $this->compareWakeCandidates($left, $right));

        return $devices;
    }

    public function findWakeCandidateForProvider(int $providerId): array
    {
        $devices = $this->getPushEligibleDevicesForProvider($providerId);

        if ($devices === []) {
            return [
                'device' => null,
                'selection_tier' => 'NONE',
            ];
        }

        $device = $this->withWakeSelectionMetadata($devices[0]);

        return [
            'device' => $device,
            'selection_tier' => $device['selection_tier'],
        ];
    }

    private function baseWakeCandidateQuery(): self
    {
        $builder = $this->where('activo', 1);

        if ($this->db->fieldExists('deleted_at', $this->table)) {
            $builder->where('deleted_at IS NULL', null, false);
        }

        return $builder
            ->where('token_fcm IS NOT NULL', null, false)
            ->where('token_fcm !=', '')
            ->where('estado_configuracion', 'COMPLETE')
            ->groupStart()
                ->where('codigo_ultimo_error IS NULL', null, false)
                ->orWhere('codigo_ultimo_error !=', 'FCM_TOKEN_NOT_REGISTERED')
            ->groupEnd();
    }

    private function selectCurrentWakeCandidatesByProvider(array $rows): array
    {
        $devicesByProviderId = [];

        foreach ($rows as $row) {
            $providerId = (int) ($row['id_users_proveedor_sms'] ?? 0);

            if ($providerId <= 0) {
                continue;
            }

            $candidate = $this->withWakeSelectionMetadata($row);

            if (
                !array_key_exists($providerId, $devicesByProviderId)
                || $this->compareWakeCandidates($candidate, $devicesByProviderId[$providerId]) < 0
            ) {
                $devicesByProviderId[$providerId] = $candidate;
            }
        }

        return array_values($devicesByProviderId);
    }

    private function withWakeSelectionMetadata(array $device): array
    {
        $device['selection_tier'] = $this->isPreferredWakeDevice($device) ? 'ONLINE' : 'REACTIVABLE';
        $device['heartbeat_age_seconds'] = $this->ageSeconds($device['ultimo_latido_en'] ?? null);
        $device['fcm_received_age_seconds'] = $this->ageSeconds($device['ultimo_fcm_recibido_en'] ?? null);

        return $device;
    }

    private function compareWakeCandidates(array $left, array $right): int
    {
        $leftScores = $this->wakeCandidateSortScores($left);
        $rightScores = $this->wakeCandidateSortScores($right);

        foreach ($leftScores as $index => $leftScore) {
            $rightScore = $rightScores[$index];

            if ($leftScore === $rightScore) {
                continue;
            }

            return $leftScore > $rightScore ? -1 : 1;
        }

        return 0;
    }

    private function wakeCandidateSortScores(array $device): array
    {
        return [
            ($device['selection_tier'] ?? 'REACTIVABLE') === 'ONLINE' ? 1 : 0,
            !empty($device['lease_expires_at']) && (string) $device['lease_expires_at'] >= GatewayClock::nowDatabase() ? 1 : 0,
            $this->timestampScore($device['ultimo_latido_en'] ?? null),
            $this->timestampScore($device['ultimo_fcm_recibido_en'] ?? null),
            strtoupper((string) ($device['estado_servicio'] ?? '')) === 'RUNNING' ? 1 : 0,
            (int) ($device['red_validada'] ?? 0) === 1 ? 1 : 0,
            (int) ($device['sim_disponible'] ?? 0) === 1 ? 1 : 0,
            (int) ($device['id_dispositivo_proveedor_gateway'] ?? 0),
        ];
    }

    private function timestampScore($dateTime): int
    {
        $parsed = GatewayClock::parseDatabase(is_string($dateTime) ? $dateTime : null);

        return $parsed === null ? 0 : $parsed->getTimestamp();
    }

    private function isPreferredWakeDevice(array $device): bool
    {
        $now = GatewayClock::nowDatabase();
        $minimumHeartbeat = GatewayClock::secondsAgo(config(GatewayAvailability::class)->availabilityLeaseSeconds);

        if (!empty($device['lease_expires_at']) && (string) $device['lease_expires_at'] >= $now) {
            return true;
        }

        if (!empty($device['ultimo_latido_en']) && (string) $device['ultimo_latido_en'] >= $minimumHeartbeat) {
            return true;
        }

        return !empty($device['ultimo_fcm_recibido_en']) && (string) $device['ultimo_fcm_recibido_en'] >= $minimumHeartbeat;
    }

    private function ageSeconds($dateTime): ?int
    {
        $parsed = GatewayClock::parseDatabase(is_string($dateTime) ? $dateTime : null);

        return $parsed === null ? null : max(0, GatewayClock::now()->getTimestamp() - $parsed->getTimestamp());
    }

    public function markPushSent(int $deviceId, string $serverTime): bool
    {
        return $this->update($deviceId, [
            'ultimo_push_fcm_en' => $serverTime,
        ]);
    }

    public function clearFcmToken(int $deviceId): bool
    {
        return $this->update($deviceId, [
            'token_fcm' => null,
            'token_fcm_actualizado_en' => null,
            'activo' => 0,
            'estado_servicio' => 'STOPPED',
        ]);
    }

    public function recordPushError(
        int $deviceId,
        string $errorCode,
        string $errorMessage,
        string $serverTime
    ): bool {
        return $this->update($deviceId, [
            'codigo_ultimo_error' => $errorCode,
            'mensaje_ultimo_error' => mb_substr($errorMessage, 0, 500),
            'ultimo_error_en' => $serverTime,
        ]);
    }

    public function findByInstallationForProvider(
        string $installationId,
        int $providerId
    ): ?array {
        return $this->where('id_instalacion', $installationId)
            ->where('id_users_proveedor_sms', $providerId)
            ->first();
    }

    public function markFcmReceived(int $deviceId, string $serverTime): bool
    {
        $data = [
            'ultimo_fcm_recibido_en' => $serverTime,
        ];

        if ($this->supportsAvailabilityLease()) {
            $data['lease_expires_at'] = GatewayClock::secondsFromNow(
                config(GatewayAvailability::class)->availabilityLeaseSeconds
            );
        }

        return $this->update($deviceId, $data);
    }

    public function supportsAvailabilityLease(): bool
    {
        return $this->db->fieldExists('lease_expires_at', $this->table);
    }
}
