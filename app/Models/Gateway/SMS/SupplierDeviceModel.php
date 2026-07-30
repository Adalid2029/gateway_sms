<?php

namespace App\Models\Gateway\SMS;

use CodeIgniter\Model;

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
        return $this->where('id_users_proveedor_sms', $providerId)
            ->where('activo', 1)
            ->where('token_fcm IS NOT NULL', null, false)
            ->where('token_fcm !=', '')
            ->orderBy('ultimo_latido_en', 'DESC')
            ->orderBy('id_dispositivo_proveedor_gateway', 'DESC')
            ->first();
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
        return $this->update($deviceId, [
            'ultimo_fcm_recibido_en' => $serverTime,
        ]);
    }
}
