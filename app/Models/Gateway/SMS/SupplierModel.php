<?php

namespace App\Models\Gateway\SMS;

use CodeIgniter\Model;

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

    public function getSentMessagesByDate(int $userId,   $tenDaysAgo,  $currentDate): ?array
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

    public function getPendingSmsWithoutProvider(): ?array
    {
        $builder = $this->db->table('envio_sms');
        $builder->select('envio_sms.*')
            ->join('proveedor_envio_sms', 'envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms', 'left')
            ->where('proveedor_envio_sms.id_proveedor_envio_sms', null)
            ->where('UNIX_TIMESTAMP(envio_sms.fecha_envio) >', 'UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 5 MINUTE))', false)
            ->orderBy('envio_sms.fecha_envio', 'ASC')
            ->limit(1);
        return $builder->get()->getRowArray();
    }
    public function assignPendingSmsToProvider(array $smsData): ?int
    {
        $builder = $this->db->table('proveedor_envio_sms');
        $result = $builder->insert([
            'id_users_proveedor_sms' => $smsData['id_users_proveedor_sms'],
            'id_envio_sms' => $smsData['id_envio_sms'],
            'fecha_asignacion_sms' => date('Y-m-d H:i:s'),
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
        $builder = $this->db->table('proveedor_envio_sms');
        $builder->where('id_proveedor_envio_sms', $data['id_proveedor_envio_sms'])
            ->where('id_users_proveedor_sms', $data['id_users_proveedor_sms'])
            ->where('estado_envio', 'PROCESANDO');

        $update = $builder->update([
            'estado_envio' => $data['estado_envio'],
            'fecha_respuesta_sms' => $data['fecha_respuesta_sms']
        ]);

        if ($this->db->affectedRows() === 0) {
            return null;
        }

        return $this->getProcessingSmsForProvider([
            'proveedor_envio_sms.id_proveedor_envio_sms' => $data['id_proveedor_envio_sms'],
            'proveedor_envio_sms.id_users_proveedor_sms' => $data['id_users_proveedor_sms']
        ]);
    }
}
