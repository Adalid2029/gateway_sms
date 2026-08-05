<?php

namespace App\Models\Gateway\SMS;

use CodeIgniter\Model;
use App\Libraries\Gateway\GatewayClock;
use Config\GatewayAvailability;

class SupplierModel extends Model
{
    protected $table            = 'proveedor_sms';
    protected $primaryKey       = 'id_users_proveedor_sms';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getEconomicInfoProvider(int $userId, array $where = []): array|null
    {
        $this->select([
            'users.id',
            'proveedor_sms.id_users_proveedor_sms',
            'COALESCE(COUNT(CASE WHEN proveedor_envio_sms.estado_envio = "COMPLETADO" THEN proveedor_envio_sms.id_proveedor_envio_sms END), 0) AS total_sms_sent',
            'COALESCE(SUM(CASE WHEN proveedor_envio_sms.estado_envio = "COMPLETADO" THEN proveedor_sms.tarifa_por_sms ELSE 0 END), 0) AS total_sms_cost',
            'proveedor_sms.limite_sms AS sms_limit',
        ])
            ->join('users', 'users.id = proveedor_sms.id_users_proveedor_sms')
            ->join('proveedor_envio_sms', 'proveedor_envio_sms.id_users_proveedor_sms = proveedor_sms.id_users_proveedor_sms', 'left')
            ->where('users.id', $userId)
            ->groupBy([
                'users.id',
                'proveedor_sms.id_users_proveedor_sms',
                'proveedor_sms.limite_sms',
            ]);

        if (!empty($where)) {
            $this->where($where);
        }

        $result = $this->get()->getRowArray();
        if (empty($result)) {
            return [
                'id' => $userId,
                'id_users_proveedor_sms' => $userId,
                'total_sms_sent' => 0,
                'total_sms_cost' => 0,
                'sms_limit' => 0,
            ];
        }

        return $result;
    }

    public function getPaymentEconomicInfoProvider(int $userId, array $where = []): array|null
    {
        $this->select([
            'pago_proveedor.id_pago_proveedor',
            "CONCAT(
                CASE EXTRACT(MONTH FROM fecha_inicio_periodo)
                    WHEN 1 THEN 'Ene'
                    WHEN 2 THEN 'Feb'
                    WHEN 3 THEN 'Mar'
                    WHEN 4 THEN 'Abr'
                    WHEN 5 THEN 'May'
                    WHEN 6 THEN 'Jun'
                    WHEN 7 THEN 'Jul'
                    WHEN 8 THEN 'Ago'
                    WHEN 9 THEN 'Sep'
                    WHEN 10 THEN 'Oct'
                    WHEN 11 THEN 'Nov'
                    WHEN 12 THEN 'Dic'
                END,
                ' ',
                EXTRACT(YEAR FROM fecha_inicio_periodo)
            ) as periodo",
            'pago_proveedor.cantidad_sms',
            'pago_proveedor.monto',
            'pago_proveedor.comprobante'
        ])
            ->join('pago_proveedor', 'proveedor_sms.id_users_proveedor_sms = pago_proveedor.id_users_proveedor_sms')
            ->where('proveedor_sms.id_users_proveedor_sms', $userId);

        if (!empty($where)) {
            $this->where($where);
        }

        return $this->get()->getResultArray();
    }

    public function getSentMessagesByDate(int $userId, $tenDaysAgo, $currentDate): ?array
    {
        $builder = $this->db->table('proveedor_envio_sms');
        $builder->select('id_users_proveedor_sms, COUNT(*) as total_mensajes, DATE_FORMAT(fecha_respuesta_sms, "%Y-%m-%d") as fecha_respuesta')
            ->where('estado_envio', 'COMPLETADO')
            ->where('DATE_FORMAT(fecha_respuesta_sms, "%Y-%m-%d") >=', $tenDaysAgo)
            ->where('DATE_FORMAT(fecha_respuesta_sms, "%Y-%m-%d") <=', $currentDate)
            ->where('id_users_proveedor_sms', $userId)
            ->groupBy('DATE_FORMAT(fecha_respuesta_sms, "%Y-%m-%d"), id_users_proveedor_sms')
            ->orderBy('fecha_respuesta DESC, id_users_proveedor_sms');
        $messagesByDate = [];
        $currentDate = strtotime($currentDate);
        $tenDaysAgo = strtotime($tenDaysAgo);
        while ($tenDaysAgo <= $currentDate) {
            $dates[] = date('Y-m-d', $tenDaysAgo);
            $tenDaysAgo = strtotime('+1 day', $tenDaysAgo);
        }
        $messages = $builder->get()->getResultArray();

        $messagesByDate = [];

        foreach ($dates as $date) {
            $messagesByDate[$date] = ['messages_sended' => 0, 'month' => date('M', strtotime($date)), 'day' => date('d', strtotime($date))];
            foreach ($messages as $message) {
                if ($message['fecha_respuesta'] === $date) {
                    $messagesByDate[$date] = ['messages_sended' => $message['total_mensajes'], 'month' => date('M', strtotime($date)), 'day' => date('d', strtotime($date))];
                }
            }
        }
        return $messagesByDate;
    }

    public function getPendingSmsWithoutProvider(int $userId, string $channel = 'SMS'): ?array
    {
        return $this->findPendingSmsWithDiagnostics($userId, $channel)['message'];
    }

    public function findPendingSmsWithDiagnostics(int $userId, string $channel = 'SMS'): array
    {
        $availability = config(GatewayAvailability::class);
        $fiveMinutesAgo = GatewayClock::secondsAgo($availability->pendingSmsWindowSeconds);
        $processingLockSince = GatewayClock::secondsAgo($availability->processingLockSeconds);
        $now = GatewayClock::nowDatabase();

        $processingDiagnostics = $this->getProcessingDiagnostics(
            $userId,
            $channel,
            $processingLockSince
        );

        if ($processingDiagnostics['recent_processing_count'] > 0) {
            return $this->pendingLookupResult(
                null,
                'processing_message_exists_recent',
                $processingDiagnostics
            );
        }

        $completedSubquery = $this->db->table('proveedor_envio_sms')
            ->select('1')
            ->where('id_envio_sms = envio_sms.id_envio_sms')
            ->where('estado_envio', 'COMPLETADO')
            ->where('canal_envio', $channel);

        // Buscar mensajes rechazados del mismo canal que no tengan envíos completados.
        $builder = $this->db->table('envio_sms')
            ->select('envio_sms.*, proveedor_envio_sms.id_users_proveedor_sms, proveedor_envio_sms.estado_envio')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->where('envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.estado_envio', 'RECHAZADO')
            ->where('proveedor_envio_sms.id_users_proveedor_sms !=', $userId)
            ->groupStart()
                ->where('envio_sms.expires_at IS NOT NULL', null, false)
                ->where('envio_sms.expires_at >=', $now)
                ->orGroupStart()
                    ->where('envio_sms.expires_at IS NULL', null, false)
                    ->where('envio_sms.fecha_envio >=', $fiveMinutesAgo)
                ->groupEnd()
            ->groupEnd()
            ->where('envio_sms.fecha_envio <=', $now)
            ->where("NOT EXISTS ({$completedSubquery->getCompiledSelect()})")
            ->orderBy('envio_sms.fecha_envio', 'ASC')
            ->limit(1);

        $result = $builder->get()->getRowArray();
        if ($result) {
            return $this->pendingLookupResult($result, 'eligible_message_found', $processingDiagnostics);
        }

        // Buscar mensajes del canal sin intentos de envío.
        $builder = $this->db->table('envio_sms')
            ->select('envio_sms.*')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms AND proveedor_envio_sms.canal_envio = ' . $this->db->escape($channel), 'left')
            ->where('envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.id_proveedor_envio_sms IS NULL')
            ->groupStart()
                ->where('envio_sms.expires_at IS NOT NULL', null, false)
                ->where('envio_sms.expires_at >=', $now)
                ->orGroupStart()
                    ->where('envio_sms.expires_at IS NULL', null, false)
                    ->where('envio_sms.fecha_envio >=', $fiveMinutesAgo)
                ->groupEnd()
            ->groupEnd()
            ->where('envio_sms.fecha_envio <=', $now)
            ->orderBy('envio_sms.fecha_envio', 'ASC')
            ->limit(1);

        $result = $builder->get()->getRowArray();
        if ($result) {
            return $this->pendingLookupResult($result, 'eligible_message_found', $processingDiagnostics);
        }

        return $this->buildPendingDiagnostics(
            $userId,
            $channel,
            $fiveMinutesAgo,
            $now,
            $processingDiagnostics
        );
    }

    private function pendingLookupResult(?array $message, string $reason, array $diagnostics = []): array
    {
        return array_merge([
            'message' => $message,
            'reason' => $reason,
            'eligible_count' => $message === null ? 0 : 1,
            'expired_count' => 0,
            'assigned_count' => 0,
            'completed_count' => 0,
            'processing_count' => 0,
            'global_processing_count' => 0,
            'provider_processing_count' => 0,
            'recent_processing_count' => 0,
            'stale_processing_count' => 0,
            'oldest_processing_age_seconds' => null,
            'oldest_processing_sms_id' => null,
            'future_count' => 0,
            'eligible_in_current_window' => $message === null ? 0 : 1,
            'expired_in_current_window' => 0,
            'unassigned_in_current_window' => 0,
            'oldest_expired_age_seconds' => null,
            'oldest_pending_age_seconds' => $message === null
                ? null
                : $this->ageSeconds($message['fecha_envio'] ?? null),
            'pending_window_seconds' => config(GatewayAvailability::class)->pendingSmsWindowSeconds,
            'processing_lock_seconds' => config(GatewayAvailability::class)->processingLockSeconds,
        ], $diagnostics);
    }

    private function buildPendingDiagnostics(
        int $userId,
        string $channel,
        string $fiveMinutesAgo,
        string $now,
        array $processingDiagnostics
    ): array
    {
        $base = $this->db->table('envio_sms')
            ->select([
                'COUNT(*) AS total_count',
                'SUM(CASE WHEN envio_sms.fecha_envio > ' . $this->db->escape($now) . ' THEN 1 ELSE 0 END) AS future_count',
                'MIN(CASE WHEN envio_sms.fecha_envio <= ' . $this->db->escape($now) . ' THEN envio_sms.fecha_envio ELSE NULL END) AS oldest_pending_at',
            ], false)
            ->where('envio_sms.canal_envio', $channel)
            ->get()
            ->getRowArray() ?? [];

        $window = $this->db->table('envio_sms')
            ->select([
                'SUM(CASE WHEN proveedor_envio_sms.id_proveedor_envio_sms IS NULL AND envio_sms.fecha_envio <= ' . $this->db->escape($now) . ' AND ((envio_sms.expires_at IS NOT NULL AND envio_sms.expires_at >= ' . $this->db->escape($now) . ') OR (envio_sms.expires_at IS NULL AND envio_sms.fecha_envio >= ' . $this->db->escape($fiveMinutesAgo) . ')) THEN 1 ELSE 0 END) AS unassigned_in_current_window',
                'SUM(CASE WHEN proveedor_envio_sms.id_proveedor_envio_sms IS NULL AND envio_sms.fecha_envio <= ' . $this->db->escape($now) . ' AND ((envio_sms.expires_at IS NOT NULL AND envio_sms.expires_at < ' . $this->db->escape($now) . ') OR (envio_sms.expires_at IS NULL AND envio_sms.fecha_envio < ' . $this->db->escape($fiveMinutesAgo) . ')) THEN 1 ELSE 0 END) AS expired_in_current_window',
            ], false)
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms AND proveedor_envio_sms.canal_envio = ' . $this->db->escape($channel), 'left')
            ->where('envio_sms.canal_envio', $channel)
            ->get()
            ->getRowArray() ?? [];

        $expired = $this->db->table('envio_sms')
            ->select([
                'COUNT(*) AS expired_count',
                'MIN(envio_sms.fecha_envio) AS oldest_expired_at',
            ])
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms AND proveedor_envio_sms.canal_envio = ' . $this->db->escape($channel), 'left')
            ->where('envio_sms.canal_envio', $channel)
            ->where('envio_sms.fecha_envio <=', $now)
            ->where('proveedor_envio_sms.id_proveedor_envio_sms IS NULL')
            ->groupStart()
                ->where('envio_sms.expires_at IS NOT NULL', null, false)
                ->where('envio_sms.expires_at <', $now)
                ->orGroupStart()
                    ->where('envio_sms.expires_at IS NULL', null, false)
                    ->where('envio_sms.fecha_envio <', $fiveMinutesAgo)
                ->groupEnd()
            ->groupEnd()
            ->get()
            ->getRowArray() ?? [];

        $assignedCount = $this->db->table('envio_sms')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->where('envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.estado_envio !=', 'COMPLETADO')
            ->countAllResults();

        $completedCount = $this->db->table('envio_sms')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->where('envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.canal_envio', $channel)
            ->where('proveedor_envio_sms.estado_envio', 'COMPLETADO')
            ->countAllResults();

        $diagnostics = array_merge($processingDiagnostics, [
            'expired_count' => (int) ($expired['expired_count'] ?? 0),
            'assigned_count' => (int) $assignedCount,
            'completed_count' => (int) $completedCount,
            'future_count' => (int) ($base['future_count'] ?? 0),
            'expired_in_current_window' => (int) ($window['expired_in_current_window'] ?? 0),
            'unassigned_in_current_window' => (int) ($window['unassigned_in_current_window'] ?? 0),
            'oldest_expired_age_seconds' => $this->ageSeconds($expired['oldest_expired_at'] ?? null),
            'oldest_pending_age_seconds' => $this->ageSeconds($base['oldest_pending_at'] ?? null),
        ]);

        return $this->pendingLookupResult(null, $this->resolvePendingReason((int) ($base['total_count'] ?? 0), $diagnostics), $diagnostics);
    }

    private function getProcessingDiagnostics(int $userId, string $channel, string $processingLockSince): array
    {
        $provider = $this->db->table('proveedor_envio_sms')
            ->select([
                'COUNT(*) AS provider_processing_count',
                'SUM(CASE WHEN fecha_asignacion_sms >= ' . $this->db->escape($processingLockSince) . ' THEN 1 ELSE 0 END) AS recent_processing_count',
                'SUM(CASE WHEN fecha_asignacion_sms < ' . $this->db->escape($processingLockSince) . ' THEN 1 ELSE 0 END) AS stale_processing_count',
                'MIN(fecha_asignacion_sms) AS oldest_processing_at',
                'MIN(id_envio_sms) AS oldest_processing_sms_id',
            ], false)
            ->where('id_users_proveedor_sms', $userId)
            ->where('canal_envio', $channel)
            ->where('estado_envio', 'PROCESANDO')
            ->get()
            ->getRowArray() ?? [];

        $globalProcessingCount = $this->db->table('proveedor_envio_sms')
            ->where('canal_envio', $channel)
            ->where('estado_envio', 'PROCESANDO')
            ->countAllResults();

        return [
            'processing_count' => (int) ($provider['provider_processing_count'] ?? 0),
            'provider_processing_count' => (int) ($provider['provider_processing_count'] ?? 0),
            'global_processing_count' => (int) $globalProcessingCount,
            'recent_processing_count' => (int) ($provider['recent_processing_count'] ?? 0),
            'stale_processing_count' => (int) ($provider['stale_processing_count'] ?? 0),
            'oldest_processing_age_seconds' => $this->ageSeconds($provider['oldest_processing_at'] ?? null),
            'oldest_processing_sms_id' => $provider['oldest_processing_sms_id'] === null
                ? null
                : (int) $provider['oldest_processing_sms_id'],
        ];
    }

    private function resolvePendingReason(int $totalCount, array $diagnostics): string
    {
        if ($totalCount === 0) {
            return 'no_messages_exist';
        }

        if (($diagnostics['recent_processing_count'] ?? 0) > 0) {
            return 'processing_message_exists_recent';
        }

        if (($diagnostics['stale_processing_count'] ?? 0) > 0) {
            return 'stale_processing_messages_exist';
        }

        if (($diagnostics['expired_count'] ?? 0) > 0) {
            return 'expired_messages_only';
        }

        if (($diagnostics['completed_count'] ?? 0) > 0) {
            return 'completed_messages_only';
        }

        if (($diagnostics['assigned_count'] ?? 0) > 0) {
            return 'already_assigned_only';
        }

        if (($diagnostics['future_count'] ?? 0) > 0) {
            return 'future_messages_only';
        }

        return 'no_eligible_messages';
    }

    private function ageSeconds($dateTime): ?int
    {
        $parsed = GatewayClock::parseDatabase(is_string($dateTime) ? $dateTime : null);

        return $parsed === null ? null : max(0, GatewayClock::now()->getTimestamp() - $parsed->getTimestamp());
    }

    public function assignPendingSmsToProvider(array $smsData): ?int
    {
        $builder = $this->db->table('proveedor_envio_sms');
        $result = $builder->insert([
            'id_users_proveedor_sms' => $smsData['id_users_proveedor_sms'],
            'id_envio_sms' => $smsData['id_envio_sms'],
            'canal_envio' => $smsData['canal_envio'] ?? 'SMS',
            'fecha_asignacion_sms' => GatewayClock::nowDatabase(),
            'estado_envio' => 'PROCESANDO',
        ]);

        return $result ? $this->db->insertID() : null;
    }

    public function getProcessingSmsForProvider(array $where = []): ?array
    {
        $builder = $this->db->table('envio_sms');
        $builder->select('*')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->where($where)
            ->orderBy('envio_sms.fecha_envio', 'ASC')
            ->limit(1);

        return $builder->get()->getRowArray();
    }
    public function confirmSentMessage(array $data): ?array
    {
        $existing = $this->getProviderSmsAttempt(
            (int) $data['id_proveedor_envio_sms'],
            (int) $data['id_users_proveedor_sms'],
            $data['canal_envio'] ?? 'SMS'
        );

        if ($existing === null) {
            return null;
        }

        if (in_array((string) ($existing['estado_envio'] ?? ''), ['COMPLETADO', 'RECHAZADO'], true)) {
            return $existing;
        }

        if (($existing['estado_envio'] ?? null) !== 'PROCESANDO') {
            return null;
        }

        $builder = $this->db->table('proveedor_envio_sms');
        $builder->where('id_proveedor_envio_sms', $data['id_proveedor_envio_sms'])
            ->where('id_users_proveedor_sms', $data['id_users_proveedor_sms'])
            ->where('canal_envio', $data['canal_envio'] ?? 'SMS')
            ->where('estado_envio', 'PROCESANDO');

        $update = $builder->update([
            'estado_envio' => $data['estado_envio'],
            'fecha_respuesta_sms' => $data['fecha_respuesta_sms']
        ]);

        if ($this->db->affectedRows() === 0) {
            return null;
        }

        return $this->getProviderSmsAttempt(
            (int) $data['id_proveedor_envio_sms'],
            (int) $data['id_users_proveedor_sms'],
            $data['canal_envio'] ?? 'SMS'
        );
    }

    private function getProviderSmsAttempt(
        int $providerSmsId,
        int $providerId,
        string $channel
    ): ?array {
        return $this->db->table('envio_sms')
            ->select('*')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->where('proveedor_envio_sms.id_proveedor_envio_sms', $providerSmsId)
            ->where('proveedor_envio_sms.id_users_proveedor_sms', $providerId)
            ->where('proveedor_envio_sms.canal_envio', $channel)
            ->limit(1)
            ->get()
            ->getRowArray();
    }
}
