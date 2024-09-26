<?php

namespace App\Controllers\Gateway\SMS;

use App\Controllers\BaseController;
use App\Models\Client\SMS\ClientSystemModel;
use App\Models\Client\SMS\SendSmsModel;

class ClientController extends BaseController
{
    private $clientSystemModel;
    private $sendSmsModel;
    function __construct()
    {
        $this->clientSystemModel = new ClientSystemModel();
        $this->sendSmsModel = new SendSmsModel();
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
        $suscriptionPlan = $this->clientSystemModel->getUserLatestActiveSuscriptionSmsUsage($user->id);
        if (!$suscriptionPlan)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => 'No se encontró un plan de suscripción activo'
            ]);

        $insertedId =  $this->sendSmsModel->insert([
            'id_suscripcion_plan' => $suscriptionPlan['id_suscripcion_plan'],
            'id_sistema_cliente' => $clientSystem['id_sistema_cliente'],
            'numero_destino' => $data['phone'],
            'mensaje' => $data['message'],
            'fecha_envio' => date('Y-m-d H:i:s'),
        ]);
        if (!$insertedId)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => 'No se pudo enviar el mensaje'
            ]);
        return $this->response->setJSON([
            'type' => 'success',
            'message' => 'Mensaje enviado correctamente'
        ]);
    }
    public function index()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        $data['suscriptionActive'] = $this->clientSystemModel->getUserLatestActiveSuscriptionSmsUsage(auth()->user()->id);
        $data['systems'] = $this->clientSystemModel->where(['id_users_cliente' => auth()->user()->id])->findAll();
        $data['urlAddSystem'] = base_url(route_to('client/system/add'));
        return dd($data);
        return view('gateway/sms/client/client_system_list', $data);
    }
}
