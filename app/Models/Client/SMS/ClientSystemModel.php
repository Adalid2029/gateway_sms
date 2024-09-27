<?php

namespace App\Models\Client\SMS;

use CodeIgniter\Model;

class ClientSystemModel extends Model
{
    protected $table            = 'sistema_cliente';
    protected $primaryKey       = 'id_sistema_cliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_users_cliente', 'nombre_sistema', 'url_sistema', 'token_api'];

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

    public function getUserLatestActiveSuscriptionSmsUsage(int $idUser): array|null
    {
        $query = "WITH sms_utilizado AS (
                    SELECT id_suscripcion_plan, COUNT(proveedor_envio_sms.id_proveedor_envio_sms) AS cantidad_sms_utilizado
                    FROM envio_sms
                        INNER JOIN proveedor_envio_sms ON(envio_sms.id_envio_sms = proveedor_envio_sms.id_envio_sms)
                    WHERE estado_envio = 'COMPLETADO'
                    GROUP BY id_suscripcion_plan
                )
                SELECT suscripcion_plan.id_suscripcion_plan, cliente.id_users_cliente, cantidad_sms_contratado,IFNULL(cantidad_sms_utilizado,0) AS cantidad_sms_utilizado , (cantidad_sms_contratado - IFNULL(cantidad_sms_utilizado,0)) AS cantidad_sms_disponible, fecha_fin, plan_sms.nombre
                FROM cliente
                    INNER JOIN suscripcion_plan ON(cliente.id_users_cliente = suscripcion_plan.id_users_cliente)
                    INNER JOIN plan_sms on(suscripcion_plan.id_plan_sms = plan_sms.id_plan_sms)
                    LEFT JOIN sms_utilizado ON(suscripcion_plan.id_suscripcion_plan = sms_utilizado.id_suscripcion_plan)
                WHERE CURRENT_DATE BETWEEN fecha_inicio AND fecha_fin
                    AND cantidad_sms_contratado > IFNULL(cantidad_sms_utilizado,0)	  
                    AND cliente.id_users_cliente = :id_users_cliente:
                ORDER BY fecha_inicio
                LIMIT 1
            ";

        return $this->query(
            $query,
            ['id_users_cliente' => $idUser]
        )->getRowArray();
    }
}
