<?php

namespace App\Controllers\Gateway\SMS;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends ResourceController
{
    protected $format = 'json';

    public function detailsDashboard()
    {
        $user = auth()->user();

        // Aquí puedes usar $user para obtener información específica del usuario

        return $this->response
            ->setJSON([
                'type' => 'success',
                'message' => 'Details dashboard',
                'user_id' => $user->id
            ]);
    }
}
