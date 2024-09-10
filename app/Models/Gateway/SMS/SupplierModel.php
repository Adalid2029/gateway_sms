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

    public function getEconomicInfoProvider(int $userId, array $where): object
    {
        $this->select('COUNT(*) AS total_sms_sent, COUNT(*) * tarifa_por_sms AS total_sms_cost, limite_sms sms_limit');
        $this->join('users', 'users.id = proveedor_sms.id_users_proveedor_sms');
        $this->join('envio_sms', 'envio_sms.id_users_proveedor_sms = proveedor_sms.id_users_proveedor_sms');
        $this->where('users.id', $userId);
        if (!empty($where))
            $this->where($where);

        return $this;
    }
}
