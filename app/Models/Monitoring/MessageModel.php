<?php

namespace App\Models\Monitoring;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'proveedor_envio_sms';
    protected $primaryKey       = 'id_proveedor_envio_sms';
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

    public function getTotalMessagesSent()
    {
        return $this->where('estado_envio', 'COMPLETADO')->countAllResults();
    }

    public function getSuccessRate()
    {
        $totalMessages = $this->countAllResults();
        $successfulMessages = $this->where('estado_envio', 'COMPLETADO')->countAllResults();

        return $totalMessages > 0 ? round(($successfulMessages / $totalMessages) * 100, 2) : 0;
    }

    public function getMessageStatusCounts()
    {
        $query = $this->select('estado_envio, COUNT(*) as count')
            ->groupBy('estado_envio')
            ->findAll();

        $result = [
            'sent' => 0,
            'rejected' => 0,
            'pending' => 0
        ];

        foreach ($query as $row) {
            switch ($row['estado_envio']) {
                case 'COMPLETADO':
                    $result['sent'] = (int)$row['count'];
                    break;
                case 'RECHAZADO':
                    $result['rejected'] = (int)$row['count'];
                    break;
                case 'PROCESANDO':
                    $result['pending'] = (int)$row['count'];
                    break;
            }
        }

        return $result;
    }

    public function getAllMessages($limit = 10, $offset = 0, $search = '')
    {
        $query = $this->select('proveedor_envio_sms.*, 
                                envio_sms.numero_destino, 
                                envio_sms.mensaje, 
                                envio_sms.fecha_envio,
                                sistema_cliente.nombre_sistema,
                                proveedor_sms.nombre as nombre_proveedor')
            ->join('envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->join('sistema_cliente', 'sistema_cliente.id_sistema_cliente = envio_sms.id_sistema_cliente')
            ->join('proveedor_sms', 'proveedor_sms.id_users_proveedor_sms = proveedor_envio_sms.id_users_proveedor_sms')
            ->orderBy('id_proveedor_envio_sms', 'DESC');

        if (!empty($search)) {
            $query->groupStart()
                ->like('envio_sms.numero_destino', $search)
                ->orLike('envio_sms.mensaje', $search)
                ->orLike('sistema_cliente.nombre_sistema', $search)
                ->orLike('proveedor_sms.nombre', $search)
                ->groupEnd();
        }

        return $query->limit($limit, $offset)->findAll();
    }

    public function getTotalMessagesCount($search = '')
    {
        $query = $this->select('proveedor_envio_sms.id_proveedor_envio_sms')
            ->join('envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms')
            ->join('sistema_cliente', 'sistema_cliente.id_sistema_cliente = envio_sms.id_sistema_cliente')
            ->join('proveedor_sms', 'proveedor_sms.id_users_proveedor_sms = proveedor_envio_sms.id_users_proveedor_sms');

        if (!empty($search)) {
            $query->groupStart()
                ->like('envio_sms.numero_destino', $search)
                ->orLike('envio_sms.mensaje', $search)
                ->orLike('sistema_cliente.nombre_sistema', $search)
                ->orLike('proveedor_sms.nombre', $search)
                ->groupEnd();
        }

        return $query->countAllResults();
    }

    public function getSmsTrace(int $smsId): ?array
    {
        $sms = $this->db->table('envio_sms')
            ->select('envio_sms.*, sistema_cliente.nombre_sistema')
            ->join('sistema_cliente', 'sistema_cliente.id_sistema_cliente = envio_sms.id_sistema_cliente', 'left')
            ->where('envio_sms.id_envio_sms', $smsId)
            ->get()
            ->getRowArray();

        if ($sms === null) {
            return null;
        }

        $providerAttempts = $this->db->table('proveedor_envio_sms')
            ->select('proveedor_envio_sms.*, proveedor_sms.nombre AS nombre_proveedor')
            ->join('proveedor_sms', 'proveedor_sms.id_users_proveedor_sms = proveedor_envio_sms.id_users_proveedor_sms', 'left')
            ->where('proveedor_envio_sms.id_envio_sms', $smsId)
            ->orderBy('proveedor_envio_sms.id_proveedor_envio_sms', 'ASC')
            ->get()
            ->getResultArray();

        $fcmEvents = $this->db->table('evento_push_fcm_gateway')
            ->select(
                'evento_push_fcm_gateway.*, dispositivo_proveedor_gateway.id_instalacion, ' .
                'dispositivo_proveedor_gateway.fabricante, dispositivo_proveedor_gateway.modelo, ' .
                'dispositivo_proveedor_gateway.version_android, dispositivo_proveedor_gateway.version_app, ' .
                'dispositivo_proveedor_gateway.estado_servicio, dispositivo_proveedor_gateway.tipo_red, ' .
                'dispositivo_proveedor_gateway.red_validada, dispositivo_proveedor_gateway.ultimo_latido_en'
            )
            ->join(
                'dispositivo_proveedor_gateway',
                'dispositivo_proveedor_gateway.id_dispositivo_proveedor_gateway = evento_push_fcm_gateway.id_dispositivo_proveedor_gateway',
                'left'
            )
            ->where('evento_push_fcm_gateway.id_envio_sms', $smsId)
            ->orderBy('evento_push_fcm_gateway.id_evento_push_fcm_gateway', 'ASC')
            ->get()
            ->getResultArray();

        return [
            'sms' => $sms,
            'provider_attempts' => $providerAttempts,
            'fcm_events' => $fcmEvents,
            'summary' => $this->buildTraceSummary($sms, $providerAttempts, $fcmEvents),
        ];
    }

    private function buildTraceSummary(array $sms, array $providerAttempts, array $fcmEvents): array
    {
        $acceptedFcm = 0;
        $receivedFcm = 0;
        $erroredFcm = 0;

        foreach ($fcmEvents as $event) {
            if (in_array(($event['estado_envio'] ?? null), ['ACEPTADO_FCM', 'RECIBIDO_DISPOSITIVO'], true)) {
                $acceptedFcm++;
            }

            if (($event['estado_envio'] ?? null) === 'RECIBIDO_DISPOSITIVO') {
                $receivedFcm++;
            }

            if (($event['estado_envio'] ?? null) === 'ERROR') {
                $erroredFcm++;
            }
        }

        return [
            'id_envio_sms' => (int) $sms['id_envio_sms'],
            'canal_envio' => $sms['canal_envio'] ?? 'SMS',
            'total_fcm_events' => count($fcmEvents),
            'accepted_fcm_events' => $acceptedFcm,
            'received_fcm_events' => $receivedFcm,
            'errored_fcm_events' => $erroredFcm,
            'provider_attempts' => count($providerAttempts),
            'final_provider_status' => $providerAttempts[count($providerAttempts) - 1]['estado_envio'] ?? null,
        ];
    }
}
