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
        $economicInfo = $this->supplierModel->getEconomicInfoProvider($user->id);
        if (!$economicInfo)
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontraron datos económicos del proveedor'
                ]);
        return $this->response
            ->setJSON([
                'type' => 'success',
                'data' => $economicInfo
            ]);
    }
}
