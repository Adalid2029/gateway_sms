<?php

namespace App\Controllers\Gateway\SMS;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Gateway\SMS\SupplierModel;

class SupplierController extends ResourceController
{
    protected $format = 'json';
    protected $supplierModel;
    function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }
    public function detailsDashboard()
    {
        $user = auth()->user();
        return $this->response
            ->setJSON([
                'type' => 'success',
                'data' => $this->supplierModel->getEconomicInfoProvider($user->id, ['estado_envio' => 'COMPLETADO'])->get()->getRowArray()
            ]);
    }
}
