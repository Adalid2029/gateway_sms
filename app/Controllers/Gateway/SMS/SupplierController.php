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
        $currentDate = date('Y-m-d');
        $tenDaysAgo = date('Y-m-d', strtotime('-10 days', strtotime($currentDate)));
        $economicInfo['sms_send_last_days'] = $this->supplierModel->getSentMessagesByDate($user->id, $tenDaysAgo, $currentDate);
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
    public function pendingMessages()
    {
        $user = auth()->user();
        $startTime = microtime(true);

        $this->logger->alert("PROVIDER_ACTIVITY - ID: {$user->id} - ACTION: pending_messages_request - START");

        $pendingMessage = $this->supplierModel->getPendingSmsWithoutProvider($user->id);
        if (!$pendingMessage) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->alert("PROVIDER_ACTIVITY - ID: {$user->id} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: no_pending_messages");
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontraron mensajes pendientes'
                ]);
        }

        $pendingMessage['id_users_proveedor_sms'] = $user->id;

        $assignMessageToProvider = $this->supplierModel->assignPendingSmsToProvider($pendingMessage);

        if (!$assignMessageToProvider) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->error("PROVIDER_ACTIVITY - ID: {$user->id} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: assign_failed");
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se pudo asignar el mensaje al proveedor'
                ]);
        }

        $processingSms = $this->supplierModel->getProcessingSmsForProvider([
            'proveedor_envio_sms.id_users_proveedor_sms' => $user->id,
            'proveedor_envio_sms.estado_envio' => 'PROCESANDO',
            'proveedor_envio_sms.id_proveedor_envio_sms' => $assignMessageToProvider
        ]);

        if (!$processingSms) {
            $endTime = microtime(true);
            $executionTime = $endTime - $startTime;
            $this->logger->error("PROVIDER_ACTIVITY - ID: {$user->id} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: processing_not_found");
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontró el mensaje en proceso'
                ]);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $this->logger->alert("PROVIDER_ACTIVITY - ID: {$user->id} - ACTION: pending_messages_request - END - DURATION: {$executionTime} - RESULT: success");

        return $this->response
            ->setJSON([
                'type' => 'success',
                'data' => $processingSms
            ]);
    }

    public function confirmSentMessage()
    {
        $user = auth()->user();
        $rules = [
            'id_proveedor_envio_sms' => 'required|numeric',
            'estado_envio' => 'required|in_list[COMPLETADO,RECHAZADO]'
        ];

        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'type' => 'error',
                    'message' => $this->validator->getErrors()
                ]);
        }

        $data = (array) $this->request->getJSON();
        $data['id_users_proveedor_sms'] = $user->id;
        $data['fecha_respuesta_sms'] = date('Y-m-d H:i:s');

        $updatedMessage = $this->supplierModel->confirmSentMessage($data);

        if (!$updatedMessage) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se pudo confirmar el envío del mensaje'
                ]);
        }

        return $this->response
            ->setJSON([
                'type' => 'success',
                'message' => 'Mensaje confirmado correctamente',
                'data' => $updatedMessage
            ]);
    }
}
