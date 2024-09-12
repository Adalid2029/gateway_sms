<?php

namespace App\Controllers\Gateway\SMS;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Client\SMS\ClientSystemModel;

class ClientController extends BaseController
{
    private $clientSystemModel;
    function __construct()
    {
        $this->clientSystemModel = new ClientSystemModel();
    }
    public function send()
    {
        $rules = [
            'phone' => 'required|numeric',
            'message' => 'required|string',
        ];
        $data = $this->request->getJSON(true);
        if (!$this->validateData($data, $rules)) {
            return $this->response->setJSON([
                'type' => 'error',
                'message' => $this->validator->getErrors()
            ]);
        }
        $user = auth()->user();
        $token = explode(' ', $this->request->getHeaderLine('Authorization'))[1] ?? "";
        $clientSystem = $this->clientSystemModel->where(['id_users_cliente' => $user->id, 'token_api' => $token])->first();

        if (!$clientSystem)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => 'No se encontró el sistema del cliente o el token es inválido'
            ]);
    }
}
