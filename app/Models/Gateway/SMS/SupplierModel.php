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

    public function getEconomicInfoProvider(int $userId, array $where = []): object|null
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
            ->where('proveedor_envio_sms.estado_envio', 'COMPLETADO')
            ->groupBy([
                'users.id',
                'proveedor_sms.id_users_proveedor_sms',
                'proveedor_sms.limite_sms',
            ]);

        // Si necesitas depurar la consulta
        // var_dump($this->builder->getCompiledSelect());

        return $this->get()->getRow();
    }
}
