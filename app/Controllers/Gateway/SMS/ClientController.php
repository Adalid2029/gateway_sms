<?php

namespace App\Controllers\Gateway\SMS;

use App\Controllers\BaseController;
use App\Models\Client\SMS\ClientSystemModel;
use App\Models\Client\SMS\SendSmsModel;
use App\Models\Gateway\SMS\PushFcmEventModel;
use App\Models\Gateway\SMS\SupplierDeviceModel;
use Throwable;

class ClientController extends BaseController
{
    private $clientSystemModel;
    private $sendSmsModel;
    private $supplierDeviceModel;
    private $pushFcmEventModel;
    private $user;
    function __construct()
    {
        $this->clientSystemModel = new ClientSystemModel();
        $this->sendSmsModel = new SendSmsModel();
        $this->supplierDeviceModel = new SupplierDeviceModel();
        $this->pushFcmEventModel = new PushFcmEventModel();
        $this->user = auth()->user();
    }
    public function sendSms()
    {
        return $this->sendMessageByChannel('SMS');
    }

    public function sendWhatsapp()
    {
        return $this->sendMessageByChannel('WHATSAPP');
    }

    public function sendTelegram()
    {
        return $this->sendMessageByChannel('TELEGRAM');
    }

    private function sendMessageByChannel(string $channel)
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
        $token = explode(' ', $this->request->getHeaderLine('Authorization'))[1] ?? "";
        $clientSystem = $this->clientSystemModel->where(['id_users_cliente' => $this->user->id, 'token_api' => $token])->first();
        if (!$clientSystem)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorClientSystemNotFound')
            ]);

        // Validacion si la peticion nos realizan desde el dominio no verificado
        // if (getenv('CI_ENVIRONMENT') === 'production') {
        //     $domain = $this->getRequestedUrlInfo('domain');
        //     if ($clientSystem['url_sistema'] !== $domain)
        //         return $this->response->setJSON(['type' => 'error', 'message' => lang('ClientControllerLang.errorDomainMismatch')]);
        // }
        $suscriptionPlan = $this->clientSystemModel->getUserLatestActiveSuscriptionSmsUsage($this->user->id);
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
            'canal_envio' => $channel,
            'fecha_envio' => date('Y-m-d H:i:s'),
        ]);
        if (!$insertedId)
            return $this->response->setJSON([
                'type' => 'error',
                'message' => lang('ClientControllerLang.errorMessageNotSent')
            ]);

        if ($channel === 'SMS') {
            $this->notifyPendingSmsDevices((int) $insertedId, $channel);
        }

        return $this->response->setJSON([
            'type' => 'success',
            'message' => lang('ClientControllerLang.successMessageSent')
        ]);
    }

    private function notifyPendingSmsDevices(int $smsId, string $channel): void
    {
        $devices = $this->supplierDeviceModel->getPushEligibleDevices();

        log_message('info', 'SMS_PENDING - START - sms_id: {sms_id} - channel: {channel} - eligible_devices: {eligible_devices}', [
            'sms_id' => $smsId,
            'channel' => $channel,
            'eligible_devices' => count($devices),
        ]);

        if ($devices === []) {
            log_message('warning', 'SMS_PENDING - NO_ELIGIBLE_DEVICES - sms_id: {sms_id} - channel: {channel}', [
                'sms_id' => $smsId,
                'channel' => $channel,
            ]);

            return;
        }

        foreach ($devices as $device) {
            $this->notifyPendingSmsDevice($smsId, $channel, $device);
        }
    }

    private function notifyPendingSmsDevice(int $smsId, string $channel, array $device): void
    {
        $deviceId = (int) ($device['id_dispositivo_proveedor_gateway'] ?? 0);
        $providerId = (int) ($device['id_users_proveedor_sms'] ?? 0);

        if ($deviceId <= 0 || $providerId <= 0) {
            log_message('error', 'SMS_PENDING - INVALID_DEVICE_DATA - sms_id: {sms_id} - channel: {channel}', [
                'sms_id' => $smsId,
                'channel' => $channel,
            ]);

            return;
        }

        $eventIdentifier = $this->generateEventIdentifier();
        $eventId = $this->pushFcmEventModel->createPendingEvent(
            $deviceId,
            $providerId,
            $eventIdentifier,
            'SMS_PENDING',
            $smsId
        );

        if ($eventId === null) {
            log_message('error', 'SMS_PENDING - EVENT_CREATE_FAILED - sms_id: {sms_id} - provider_id: {provider_id} - device_id: {device_id} - event_id: {event_id}', [
                'sms_id' => $smsId,
                'provider_id' => $providerId,
                'device_id' => $deviceId,
                'event_id' => $eventIdentifier,
            ]);

            return;
        }

        try {
            $result = service('firebaseMessagingService')->sendToToken(
                (string) ($device['token_fcm'] ?? ''),
                'SMS_PENDING',
                [
                    'channel' => $channel,
                    'event_id' => $eventIdentifier,
                    'sms_id' => (string) $smsId,
                ]
            );
        } catch (Throwable $exception) {
            $this->pushFcmEventModel->markError(
                $eventId,
                'FCM_CONFIGURATION_ERROR',
                $exception->getMessage()
            );

            log_message('error', 'SMS_PENDING - CONFIG_ERROR - sms_id: {sms_id} - provider_id: {provider_id} - device_id: {device_id} - event_id: {event_id} - message: {message}', [
                'sms_id' => $smsId,
                'provider_id' => $providerId,
                'device_id' => $deviceId,
                'event_id' => $eventIdentifier,
                'message' => $exception->getMessage(),
            ]);

            return;
        }

        $serverTime = date('Y-m-d H:i:s');

        if ($result['success'] === true) {
            $this->supplierDeviceModel->markPushSent($deviceId, $serverTime);
            $this->pushFcmEventModel->markAccepted(
                $eventId,
                (string) $result['message_id'],
                $serverTime
            );

            log_message('info', 'SMS_PENDING - ACCEPTED - sms_id: {sms_id} - provider_id: {provider_id} - device_id: {device_id} - event_id: {event_id} - message_id: {message_id}', [
                'sms_id' => $smsId,
                'provider_id' => $providerId,
                'device_id' => $deviceId,
                'event_id' => $eventIdentifier,
                'message_id' => (string) $result['message_id'],
            ]);

            return;
        }

        $this->supplierDeviceModel->recordPushError(
            $deviceId,
            (string) $result['error_code'],
            (string) $result['error_message'],
            $serverTime
        );
        $this->pushFcmEventModel->markError(
            $eventId,
            (string) $result['error_code'],
            (string) $result['error_message'],
            $serverTime
        );

        if (($result['should_clear_token'] ?? false) === true) {
            $this->supplierDeviceModel->clearFcmToken($deviceId);

            log_message('warning', 'SMS_PENDING - TOKEN_CLEARED - sms_id: {sms_id} - provider_id: {provider_id} - device_id: {device_id} - event_id: {event_id} - error_code: {error_code} - message: {message}', [
                'sms_id' => $smsId,
                'provider_id' => $providerId,
                'device_id' => $deviceId,
                'event_id' => $eventIdentifier,
                'error_code' => (string) $result['error_code'],
                'message' => (string) $result['error_message'],
            ]);

            return;
        }

        log_message('error', 'SMS_PENDING - SEND_ERROR - sms_id: {sms_id} - provider_id: {provider_id} - device_id: {device_id} - event_id: {event_id} - error_code: {error_code} - message: {message}', [
            'sms_id' => $smsId,
            'provider_id' => $providerId,
            'device_id' => $deviceId,
            'event_id' => $eventIdentifier,
            'error_code' => (string) $result['error_code'],
            'message' => (string) $result['error_message'],
        ]);
    }

    private function generateEventIdentifier(): string
    {
        $bytes = random_bytes(16);
        $hex = bin2hex($bytes);

        return sprintf(
            '%s-%s-%s-%s-%s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12)
        );
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

        $insertedId = $this->clientSystemModel->insert([
            'id_users_cliente' => $this->user->id,
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
        $clientSystem = $this->clientSystemModel->where(['id_users_cliente' => $this->user->id, 'id_sistema_cliente' => $idClientSystem])->first();
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
    private function getRequestedUrlInfo(string $part = 'all'): string
    {
        $fullURL = current_url();
        $parsedURL = parse_url($fullURL);
        $protocol = isset($parsedURL['scheme']) ? $parsedURL['scheme'] . '://' : '';
        $domain = $parsedURL['host'] ?? 'unknown';
        $fullDomain = $protocol . $domain;
        switch ($part) {
            case 'protocol':
                return $protocol;
            case 'domain':
                return $domain;
            case 'full_domain':
                return $fullDomain;
            case 'full_url':
                return $fullURL;
            case 'all':
            default:
                return json_encode([
                    'protocol' => $protocol,
                    'domain' => $domain,
                    'full_domain' => $fullDomain,
                    'full_url' => $fullURL
                ]);
        }
    }
}
