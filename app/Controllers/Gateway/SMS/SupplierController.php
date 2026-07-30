<?php

namespace App\Controllers\Gateway\SMS;

use App\Models\Gateway\SMS\SupplierDeviceModel;
use App\Models\Gateway\SMS\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class SupplierController extends ResourceController
{
    protected $format = 'json';
    protected $supplierModel;
    protected $supplierDeviceModel;
    protected $user;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->supplierDeviceModel = new SupplierDeviceModel();
        $this->user = auth()->user();
    }

    public function detailsDashboard()
    {
        $economicInfo = $this->supplierModel->getEconomicInfoProvider($this->user->id);
        $currentDate = date('Y-m-d');
        $tenDaysAgo = date('Y-m-d', strtotime('-10 days', strtotime($currentDate)));
        $economicInfo['sms_send_last_days'] = $this->supplierModel->getSentMessagesByDate($this->user->id, $tenDaysAgo, $currentDate);
        $economicInfo['payment_economic'] = $this->supplierModel->getPaymentEconomicInfoProvider($this->user->id);
        if (!$economicInfo) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontraron datos económicos del proveedor',
                ]);
        }

        return $this->response
            ->setJSON([
                'type' => 'success',
                'data' => $economicInfo,
            ]);
    }

    public function pendingMessages(string $channel = 'SMS')
    {
        $channel = $this->normalizeChannel($channel);
        $startTime = microtime(true);

        $this->logger->alert("PROVIDER_ACTIVITY - ID: {$this->user->id} - CHANNEL: {$channel} - ACTION: pending_messages_request - START");

        $pendingMessage = $this->supplierModel->getPendingSmsWithoutProvider($this->user->id, $channel);
        if (!$pendingMessage) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->alert("PROVIDER_ACTIVITY - ID: {$this->user->id} - CHANNEL: {$channel} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: no_pending_messages");

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON([
                    'type' => 'success',
                    'data' => null,
                ]);
        }

        $pendingMessage['id_users_proveedor_sms'] = $this->user->id;
        $pendingMessage['canal_envio'] = $channel;

        $assignMessageToProvider = $this->supplierModel->assignPendingSmsToProvider($pendingMessage);

        if (!$assignMessageToProvider) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->error("PROVIDER_ACTIVITY - ID: {$this->user->id} - CHANNEL: {$channel} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: assign_failed");

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se pudo asignar el mensaje al proveedor',
                ]);
        }

        $processingSms = $this->supplierModel->getProcessingSmsForProvider([
            'proveedor_envio_sms.id_users_proveedor_sms' => $this->user->id,
            'proveedor_envio_sms.estado_envio' => 'PROCESANDO',
            'proveedor_envio_sms.id_proveedor_envio_sms' => $assignMessageToProvider,
            'proveedor_envio_sms.canal_envio' => $channel,
        ]);

        if (!$processingSms) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->error("PROVIDER_ACTIVITY - ID: {$this->user->id} - CHANNEL: {$channel} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: processing_not_found");

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontró el mensaje en proceso',
                ]);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $this->logger->alert("PROVIDER_ACTIVITY - ID: {$this->user->id} - CHANNEL: {$channel} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: success");

        return $this->response
            ->setJSON([
                'type' => 'success',
                'data' => $processingSms,
            ]);
    }

    public function confirmSentMessage(string $channel = 'SMS')
    {
        $channel = $this->normalizeChannel($channel);
        $rules = [
            'id_proveedor_envio_sms' => 'required|numeric',
            'estado_envio' => 'required|in_list[COMPLETADO,RECHAZADO]',
        ];

        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'type' => 'error',
                    'message' => $this->validator->getErrors(),
                ]);
        }

        $data = (array) $this->request->getJSON();
        $data['id_users_proveedor_sms'] = $this->user->id;
        $data['fecha_respuesta_sms'] = date('Y-m-d H:i:s');
        $data['canal_envio'] = $channel;

        $updatedMessage = $this->supplierModel->confirmSentMessage($data);

        if (!$updatedMessage) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se pudo confirmar el envío del mensaje',
                ]);
        }

        return $this->response
            ->setJSON([
                'type' => 'success',
                'message' => 'Mensaje confirmado correctamente',
                'data' => $updatedMessage,
            ]);
    }

    public function heartbeat()
    {
        $payload = $this->request->getJSON(true);
        if (!is_array($payload)) {
            $payload = [];
        }

        $validationPayload = $this->buildHeartbeatValidationPayload($payload);

        $rules = [
            'installation_id' => 'required|max_length[100]',
            'service_state' => 'if_exist|in_list[RUNNING,STOPPED,STARTING,ERROR,UNKNOWN]',
            'network_type' => 'if_exist|in_list[WIFI,CELLULAR,ETHERNET,OTHER,NONE,UNKNOWN]',
            'network_validated' => 'if_exist|in_list[0,1,true,false]',
            'build_number' => 'if_exist|is_natural',
            'consecutive_failures' => 'if_exist|is_natural',
        ];

        if (!$this->validateData($validationPayload, $rules)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'type' => 'error',
                    'message' => $this->validator->getErrors(),
                ]);
        }

        $installationId = trim((string) $payload['installation_id']);
        $existingDevice = $this->supplierDeviceModel
            ->where('id_instalacion', $installationId)
            ->first();

        if (
            $existingDevice !== null
            && (int) $existingDevice['id_users_proveedor_sms'] !== (int) $this->user->id
        ) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_CONFLICT)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'La instalacion ya pertenece a otro proveedor',
                ]);
        }

        $serverTime = date('Y-m-d H:i:s');

        if ($existingDevice === null) {
            $deviceData = $this->buildHeartbeatInsertData($payload, $serverTime);
            $saved = $this->supplierDeviceModel->insert($deviceData, true);

            if ($saved === false) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                    ->setJSON([
                        'type' => 'error',
                        'message' => 'No se pudo registrar el heartbeat',
                        'errors' => $this->supplierDeviceModel->errors(),
                    ]);
            }

            $deviceId = (int) $saved;
        } else {
            $deviceData = $this->buildHeartbeatUpdateData($payload, $serverTime);
            $saved = $this->supplierDeviceModel
                ->update($existingDevice['id_dispositivo_proveedor_gateway'], $deviceData);

            if ($saved === false) {
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                    ->setJSON([
                        'type' => 'error',
                        'message' => 'No se pudo registrar el heartbeat',
                        'errors' => $this->supplierDeviceModel->errors(),
                    ]);
            }

            $deviceId = (int) $existingDevice['id_dispositivo_proveedor_gateway'];
        }

        return $this->response
            ->setJSON([
                'type' => 'success',
                'message' => 'Heartbeat registrado correctamente',
                'data' => [
                    'device_id' => $deviceId,
                    'server_time' => $serverTime,
                    'heartbeat_interval_seconds' => 60,
                ],
            ]);
    }

    private function normalizeChannel(string $channel): string
    {
        $channel = strtoupper($channel);
        $allowedChannels = ['SMS', 'WHATSAPP', 'TELEGRAM'];

        return in_array($channel, $allowedChannels, true) ? $channel : 'SMS';
    }

    private function buildHeartbeatInsertData(array $payload, string $serverTime): array
    {
        return array_merge(
            [
                'id_users_proveedor_sms' => (int) $this->user->id,
                'id_instalacion' => trim((string) $payload['installation_id']),
                'ultimo_latido_en' => $serverTime,
            ],
            $this->extractOptionalHeartbeatFields($payload)
        );
    }

    private function buildHeartbeatUpdateData(array $payload, string $serverTime): array
    {
        return array_merge(
            [
                'ultimo_latido_en' => $serverTime,
            ],
            $this->extractOptionalHeartbeatFields($payload)
        );
    }

    private function extractOptionalHeartbeatFields(array $payload): array
    {
        $fieldMap = [
            'id_sesion_servicio' => ['service_session_id', 'id_sesion_servicio'],
            'fabricante' => ['manufacturer', 'fabricante'],
            'modelo' => ['model', 'modelo'],
            'version_android' => ['android_version', 'version_android'],
            'version_app' => ['app_version', 'version_app'],
            'numero_build' => ['build_number', 'numero_build'],
            'estado_servicio' => ['service_state', 'estado_servicio'],
            'estado_configuracion' => ['configuration_state', 'estado_configuracion'],
            'codigo_error_configuracion' => ['configuration_error_code', 'codigo_error_configuracion'],
            'tipo_red' => ['network_type', 'tipo_red'],
            'red_validada' => ['network_validated', 'red_validada'],
            'sim_disponible' => ['sim_available', 'sim_disponible'],
            'cantidad_sim' => ['sim_count', 'cantidad_sim'],
            'slot_sim_seleccionado' => ['selected_sim_slot', 'slot_sim_seleccionado'],
            'operadora_sim' => ['sim_operator', 'operadora_sim'],
            'optimizacion_bateria_ignorada' => ['battery_optimization_ignored', 'optimizacion_bateria_ignorada'],
            'porcentaje_bateria' => ['battery_percentage', 'porcentaje_bateria'],
            'cargando_bateria' => ['battery_charging', 'cargando_bateria'],
            'servicio_iniciado_en' => ['service_started_at', 'servicio_iniciado_en'],
            'ultimo_poll_intento_en' => ['last_poll_attempt_at', 'ultimo_poll_intento_en'],
            'ultimo_poll_exitoso_en' => ['last_successful_poll_at', 'ultimo_poll_exitoso_en'],
            'ultimo_sms_enviado_en' => ['last_sms_sent_at', 'ultimo_sms_enviado_en'],
            'ultima_confirmacion_sms_en' => ['last_sms_confirmation_at', 'ultima_confirmacion_sms_en'],
            'fallos_consecutivos' => ['consecutive_failures', 'fallos_consecutivos'],
            'codigo_ultimo_error' => ['last_error_code', 'codigo_ultimo_error'],
            'mensaje_ultimo_error' => ['last_error_message', 'mensaje_ultimo_error'],
            'ultimo_error_en' => ['last_error_at', 'ultimo_error_en'],
            'token_fcm' => ['fcm_token', 'token_fcm'],
            'token_fcm_actualizado_en' => ['fcm_token_updated_at', 'token_fcm_actualizado_en'],
            'ultimo_push_fcm_en' => ['last_fcm_push_at', 'ultimo_push_fcm_en'],
            'ultimo_fcm_recibido_en' => ['last_fcm_received_at', 'ultimo_fcm_recibido_en'],
            'activo' => ['active', 'activo'],
        ];

        $data = [];

        foreach ($fieldMap as $targetField => $sourceKeys) {
            if (!$this->hasAnyPayloadKey($payload, $sourceKeys)) {
                continue;
            }

            $data[$targetField] = $this->transformHeartbeatField($targetField, $payload, $sourceKeys);
        }

        return $data;
    }

    private function transformHeartbeatField(string $targetField, array $payload, array $sourceKeys)
    {
        return match ($targetField) {
            'numero_build',
            'cantidad_sim',
            'slot_sim_seleccionado',
            'porcentaje_bateria',
            'fallos_consecutivos' => $this->nullableInt($payload, $sourceKeys),
            'red_validada',
            'sim_disponible',
            'optimizacion_bateria_ignorada',
            'cargando_bateria',
            'activo' => $this->nullableBoolAsInt($payload, $sourceKeys),
            'estado_servicio',
            'estado_configuracion',
            'tipo_red' => $this->enumValue($payload, $sourceKeys, 'UNKNOWN'),
            'servicio_iniciado_en',
            'ultimo_poll_intento_en',
            'ultimo_poll_exitoso_en',
            'ultimo_sms_enviado_en',
            'ultima_confirmacion_sms_en',
            'ultimo_error_en',
            'token_fcm_actualizado_en',
            'ultimo_push_fcm_en',
            'ultimo_fcm_recibido_en' => $this->nullableDateTime($payload, $sourceKeys),
            default => $this->nullableString($payload, $sourceKeys),
        };
    }

    private function hasAnyPayloadKey(array $payload, array $keys): bool
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $payload)) {
                return true;
            }
        }

        return false;
    }

    private function buildHeartbeatValidationPayload(array $payload): array
    {
        $validationPayload = $payload;

        if (array_key_exists('service_state', $validationPayload)) {
            $validationPayload['service_state'] = strtoupper((string) $validationPayload['service_state']);
        }

        if (array_key_exists('network_type', $validationPayload)) {
            $validationPayload['network_type'] = strtoupper((string) $validationPayload['network_type']);
        }

        if (array_key_exists('network_validated', $validationPayload)) {
            $value = $validationPayload['network_validated'];

            if (is_bool($value)) {
                $validationPayload['network_validated'] = $value ? 'true' : 'false';
            } elseif (is_numeric($value)) {
                $validationPayload['network_validated'] = ((int) $value) === 1 ? '1' : '0';
            } else {
                $validationPayload['network_validated'] = strtolower(trim((string) $value));
            }
        }

        return $validationPayload;
    }

    private function getPayloadValue(array $payload, array $keys)
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $payload)) {
                return $payload[$key];
            }
        }

        return null;
    }

    private function nullableString(array $payload, array $keys): ?string
    {
        $value = $this->getPayloadValue($payload, $keys);
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function nullableInt(array $payload, array $keys, ?int $default = null): ?int
    {
        $value = $this->getPayloadValue($payload, $keys);
        if ($value === null || $value === '') {
            return $default;
        }

        return (int) $value;
    }

    private function nullableBoolAsInt(array $payload, array $keys, ?int $default = null): ?int
    {
        $value = $this->getPayloadValue($payload, $keys);
        if ($value === null || $value === '') {
            return $default;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if (is_numeric($value)) {
            return ((int) $value) === 1 ? 1 : 0;
        }

        $normalized = strtolower(trim((string) $value));

        return in_array($normalized, ['1', 'true', 'yes'], true) ? 1 : 0;
    }

    private function enumValue(array $payload, array $keys, string $default): string
    {
        $value = $this->nullableString($payload, $keys);

        return $value === null ? $default : strtoupper($value);
    }

    private function nullableDateTime(array $payload, array $keys): ?string
    {
        $value = $this->nullableString($payload, $keys);
        if ($value === null) {
            return null;
        }

        $timestamp = strtotime($value);

        return $timestamp === false ? null : date('Y-m-d H:i:s', $timestamp);
    }
}
