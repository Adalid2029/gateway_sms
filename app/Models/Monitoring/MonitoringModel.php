<?php

namespace App\Models\Monitoring;

use CodeIgniter\Model;

class MonitoringModel extends Model
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



    public function getActiveProvidersCount()
    {
        return $this->where('limite_sms >', 0)->countAllResults();
    }

    public function getProviderActivity()
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('proveedor_envio_sms')
            ->select('id_users_proveedor_sms, COUNT(*) as message_count')
            ->where('fecha_asignacion_sms >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
            ->groupBy('id_users_proveedor_sms');

        return $this->select('proveedor_sms.nombre, COALESCE(sub.message_count, 0) as messageCount')
            ->join("({$subQuery->getCompiledSelect()}) as sub", 'sub.id_users_proveedor_sms = proveedor_sms.id_users_proveedor_sms', 'left')
            ->findAll();
    }

    public function getProvidersDetails(int $page = 1, int $limit = 10, string $search = '')
    {
        $offset = ($page - 1) * $limit;

        $db = \Config\Database::connect();
        $subQuery = $db->table('proveedor_envio_sms')
            ->select('id_users_proveedor_sms, COUNT(*) as messages_sent, MAX(fecha_asignacion_sms) as last_activity')
            ->groupBy('id_users_proveedor_sms');

        $query = $this->select('proveedor_sms.id_users_proveedor_sms as id, proveedor_sms.nombre as name, proveedor_sms.limite_sms, COALESCE(sub.messages_sent, 0) as messagesSent, sub.last_activity')
            ->join("({$subQuery->getCompiledSelect()}) as sub", 'sub.id_users_proveedor_sms = proveedor_sms.id_users_proveedor_sms', 'left');

        if (!empty($search)) {
            $query->like('proveedor_sms.nombre', $search);
        }

        $result = $query->limit($limit, $offset)->findAll();

        // Procesar el resultado para agregar el campo 'active'
        foreach ($result as &$row) {
            $row['active'] = $row['limite_sms'] > 0 ? 1 : 0;
            unset($row['limite_sms']); // Eliminamos este campo si no lo necesitamos en el resultado final
        }

        return $result;
    }

    public function getTotalProvidersCount(string $search = '')
    {
        if (!empty($search)) {
            return $this->like('nombre', $search)->countAllResults();
        }
        return $this->countAllResults();
    }

    public function getProviderMessageStats()
    {
        $db = \Config\Database::connect();
        return $db->table('proveedor_sms')
            ->select('proveedor_sms.id_users_proveedor_sms, proveedor_sms.nombre,
                  COUNT(CASE WHEN proveedor_envio_sms.estado_envio = "COMPLETADO" THEN 1 END) as sent,
                  COUNT(CASE WHEN proveedor_envio_sms.estado_envio = "RECHAZADO" THEN 1 END) as rejected,
                  COUNT(CASE WHEN proveedor_envio_sms.estado_envio = "PROCESANDO" THEN 1 END) as pending')
            ->join('proveedor_envio_sms', 'proveedor_sms.id_users_proveedor_sms = proveedor_envio_sms.id_users_proveedor_sms', 'left')
            ->groupBy('proveedor_sms.id_users_proveedor_sms')
            ->get()
            ->getResultArray();
    }
}
