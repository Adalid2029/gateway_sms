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
    public function sendSms()
    {
        $rules = [
            'phone' => [
                'label' => lang('ClientControllerLang.phoneLabel'),
                'rules' => 'required|numeric'
            ],
            'message' => [
                'label' => lang('ClientControllerLang.messageLabel'),
                'rules' => 'required|string|max_length[160]|min_length[1]'
            ]
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
                'message' => lang('ClientControllerLang.errorClientSystemNotFound')
            ]);
        $suscriptionPlan = $this->clientSystemModel->getUserLatestActiveSuscriptionSmsUsage($user->id);
        if (!$suscriptionPlan)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorNoActiveSubscription')
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
                'message' => lang('ClientControllerLang.errorMessageNotSent')
            ]);
        return $this->response->setJSON([
            'type' => 'success',
            'message' => lang('ClientControllerLang.successMessageSent')
        ]);
    }

    public function listSystems()
    {
        $data['suscriptionActive'] = $this->clientSystemModel->getUserLatestActiveSuscriptionSmsUsage(auth()->user()->id);
        $data['systems'] = $this->clientSystemModel->where(['id_users_cliente' => auth()->user()->id])->orderBy('id_sistema_cliente DESC')->findAll();
        $data['systems'] = array_map(function ($system) {
            $system['urlRegenerateSystemToken'] = base_url(route_to('client/system/regenerate-token', $system['id_sistema_cliente']));
            $system['urlEditSystem'] = base_url(route_to('client/system/edit', $system['id_sistema_cliente']));
            return $system;
        }, $data['systems']);
        $data['urlAddSystem'] = base_url(route_to('client/system/add'));
        $data['urlListSystem'] = base_url(route_to('client/system/list'));
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        return view('gateway/sms/client/client_system_list', $data);
    }

    public function addSystem()
    {
        $rules = [
            'nombre_sistema' => [
                'label' => lang('ClientControllerLang.systemNameLabel'),
                'rules' => 'required|string|max_length[100]|min_length[1]'
            ],
            'url_sistema' => [
                'label' => lang('ClientControllerLang.systemUrlLabel'),
                'rules' => 'required|valid_url|max_length[255]|min_length[1]'
            ]
        ];

        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, $rules)) {
            $errors = $this->validator->getErrors();
            $errorString = implode('<br>', $errors);
            return $this->response->setJSON([
                'type' => 'error',
                'message' => $errorString
            ]);
        }

        $user = auth()->user();
        var_dump([
            'id_users_cliente' => $user->id,
            'nombre_sistema' => $data['nombre_sistema'],
            'url_sistema' => $data['url_sistema'],
            'token_api' => $this->generateTokenForSystem()
        ]);
        die();
        $insertedId = $this->clientSystemModel->insert([
            'id_users_cliente' => $user->id,
            'nombre_sistema' => $data['nombre_sistema'],
            'url_sistema' => $data['url_sistema'],
            'token_api' => $this->generateTokenForSystem()
        ]);

        if (!$insertedId) {
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorSystemNotAdded')
            ]);
        }

        return $this->response->setJSON([
            'type' => 'success',
            'message' => lang('ClientControllerLang.successSystemAdded')
        ]);
    }

    public function editSystem($id)
    {
        $system = $this->clientSystemModel->find($id);
        if (!$system) {
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorSystemNotFound')
            ]);
        }
        return $this->response->setJSON([
            'type' => 'success',
            'data' => $system,
            'urlUpdateSystem' => base_url(route_to('client/system/update'))
        ]);
    }

    public function updateSystem()
    {
        $rules = [
            'id_sistema_cliente' => [
                'label' => lang('ClientControllerLang.systemIdLabel'),
                'rules' => 'required|integer'
            ],
            'nombre_sistema' => [
                'label' => lang('ClientControllerLang.systemNameLabel'),
                'rules' => 'required|string|max_length[100]|min_length[1]'
            ],
            'url_sistema' => [
                'label' => lang('ClientControllerLang.systemUrlLabel'),
                'rules' => 'required|valid_url|max_length[255]|min_length[1]'
            ]
        ];

        $data = $this->request->getJSON(true);

        if (!$this->validateData($data, $rules)) {
            $errors = $this->validator->getErrors();
            $errorString = implode('<br>', $errors);
            return $this->response->setJSON([
                'type' => 'error',
                'message' => $errorString
            ]);
        }

        $updated = $this->clientSystemModel->update($data['id_sistema_cliente'], [
            'nombre_sistema' => $data['nombre_sistema'],
            'url_sistema' => $data['url_sistema']
        ]);

        if (!$updated) {
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorSystemNotUpdated')
            ]);
        }

        return $this->response->setJSON([
            'type' => 'success',
            'message' => lang('ClientControllerLang.successSystemUpdated')
        ]);
    }

    public function regenerateSystemToken(int $idClientSystem)
    {
        $user = auth()->user();
        $clientSystem = $this->clientSystemModel->where(['id_users_cliente' => $user->id, 'id_sistema_cliente' => $idClientSystem])->first();
        if (!$clientSystem)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorClientSystemNotFound')
            ]);
        $token = $this->generateTokenForSystem();
        $this->clientSystemModel->update($idClientSystem, ['token_api' => $token]);
        return $this->response->setJSON([
            'type' => 'success',
            'message' => lang('ClientControllerLang.successTokenRegenerated'),
            'data' => ['token' => $token]
        ]);
    }

    private function generateTokenForSystem(): string
    {
        $token = auth()->user()->generateAccessToken('sms');
        return $token->raw_token;
    }
}
