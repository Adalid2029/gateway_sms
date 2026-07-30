<?php

namespace App\Controllers\Monitoring;

use App\Controllers\BaseController;
use App\Libraries\LogParser;
use App\Models\Gateway\SMS\PushFcmEventModel;
use App\Models\Gateway\SMS\SupplierDeviceModel;
use App\Models\Monitoring\MessageModel;
use App\Models\Monitoring\MonitoringModel;
use App\Services\Gateway\SMS\DeviceStatusService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class MonitoringController extends BaseController
{
    protected $format = 'json';
    protected $providerModel;
    protected $messageModel;
    protected $supplierDeviceModel;
    protected $pushFcmEventModel;
    protected $deviceStatusService;
    protected $logParser;

    use ResponseTrait;

    public function __construct()
    {
        $this->providerModel = new MonitoringModel();
        $this->messageModel = new MessageModel();
        $this->supplierDeviceModel = new SupplierDeviceModel();
        $this->pushFcmEventModel = new PushFcmEventModel();
        $this->deviceStatusService = new DeviceStatusService();
        $this->logParser = new LogParser(WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log');
    }
    public function index()
    {
        return view('monitoring/index');
    }

    public function getMessagesData()
    {
        $messageModel = new MessageModel();

        $page = (int)$this->request->getVar('page') ?? 1;
        $limit = (int)$this->request->getVar('limit') ?? 10;
        $search = $this->request->getVar('search') ?? '';

        $offset = ($page - 1) * $limit;

        $messages = $messageModel->getAllMessages($limit, $offset, $search);
        $totalMessages = $messageModel->getTotalMessagesCount($search);


        $data = [
            'messages' => $messages,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $totalMessages
            ]
        ];

        return $this->respond($data);
    }
    public function getDashboardData()
    {
        $page = (int)$this->request->getVar('page') ?? 1;
        $limit = (int)$this->request->getVar('limit') ?? 10;
        $search = $this->request->getVar('search') ?? '';

        $messageStatus = $this->messageModel->getMessageStatusCounts();
        $totalMessagesSent = $messageStatus['sent'] + $messageStatus['rejected'] + $messageStatus['pending'];
        $successRate = $totalMessagesSent > 0 ? round(($messageStatus['sent'] / $totalMessagesSent) * 100, 2) : 0;

        $activeProviders = $this->logParser->getActiveProviders(600);  // 20 minutos
        $providerDetails = $this->providerModel->getProvidersDetails($page, $limit, $search);
        $providerIds = array_map(
            static fn (array $provider): int => (int) $provider['id'],
            $providerDetails
        );
        $devicesByProviderId = $this->supplierDeviceModel
            ->getLatestDevicesByProviderIds($providerIds);
        $heartbeatActiveProviders = 0;

        foreach ($providerDetails as &$provider) {
            $activeProvider = array_filter($activeProviders, function ($ap) use ($provider) {
                return $ap['id'] == $provider['id'];
            });
            $provider['active'] = !empty($activeProvider);
            $provider['legacy_log_active'] = $provider['active'];

            $device = $devicesByProviderId[(int) $provider['id']] ?? null;
            $diagnostic = $device !== null
                ? $this->deviceStatusService->determineStatus($device)
                : $this->deviceStatusService->determineStatus(['activo' => 1]);

            $provider['heartbeat_status'] = $diagnostic['status'];
            $provider['heartbeat_severity'] = $diagnostic['severity'];
            $provider['heartbeat_message'] = $diagnostic['message'];
            $provider['heartbeat_last_seconds_ago'] = $diagnostic['last_heartbeat_seconds_ago'];
            $provider['heartbeat_active'] = $diagnostic['is_online'];
            $provider['requires_attention'] = $diagnostic['requires_attention'];
            $provider['device'] = [
                'status' => $diagnostic['status'],
                'severity' => $diagnostic['severity'],
                'message' => $diagnostic['message'],
                'is_online' => $diagnostic['is_online'],
                'requires_attention' => $diagnostic['requires_attention'],
                'last_heartbeat_seconds_ago' => $diagnostic['last_heartbeat_seconds_ago'],
                'thresholds' => $diagnostic['thresholds'],
                'details' => $device,
            ];

            if ($diagnostic['is_online']) {
                $heartbeatActiveProviders++;
            }

            if (!empty($activeProvider)) {
                $activeProviderData = reset($activeProvider);
                $lastActivityTime = strtotime($activeProviderData['last_activity']);
                $currentTime = time();
                $timeDiff = $currentTime - $lastActivityTime;

                $provider['last_activity'] = $activeProviderData['last_activity'];
                $provider['last_activity_seconds_ago'] = $timeDiff;
                $provider['server_current_time'] = date('Y-m-d H:i:s', $currentTime);
                $provider['recent_actions'] = $activeProviderData['actions'];

                // Calcular estadísticas
                $totalRequests = count($activeProviderData['actions']);
                $totalDuration = array_sum(array_column($activeProviderData['actions'], 'duration'));
                $avgDuration = $totalRequests > 0 ? $totalDuration / $totalRequests : 0;

                $provider['stats'] = [
                    'total_requests' => $totalRequests,
                    'avg_duration' => round($avgDuration, 4),
                    'last_request_time' => end($activeProviderData['actions'])['timestamp'] ?? null,
                ];
            } else {
                $provider['last_activity'] = null;
                $provider['recent_actions'] = [];
                $provider['stats'] = [
                    'total_requests' => 0,
                    'avg_duration' => 0,
                    'last_request_time' => null,
                ];
            }
        }


        $data = [
            'activeProviders' => $this->providerModel->getActiveProvidersCount(),
            'totalMessagesSent' => $totalMessagesSent,
            'successRate' => $successRate,
            'messageStatus' => $messageStatus,
            'providerActivity' => $this->providerModel->getProviderActivity(),
            'providers' => $this->providerModel->getProvidersDetails($page, $limit, $search),
            'providersReal' => $providerDetails,
            'activeProvidersReal' => count($activeProviders),
            'activeProvidersHeartbeat' => $heartbeatActiveProviders,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $this->providerModel->getTotalProvidersCount($search)
            ]
        ];

        return $this->respond($data);
    }

    public function testFcm(int $providerId)
    {
        if (!auth()->loggedIn()) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'Debes iniciar sesión para probar FCM.',
                ]);
        }

        $user = auth()->user();
        if ($user === null || !$user->can('admin.access')) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No tienes permisos para ejecutar esta prueba FCM.',
                ]);
        }

        $device = $this->supplierDeviceModel->getPushEligibleDeviceForProvider($providerId);
        if ($device === null) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se encontró un dispositivo elegible para este proveedor.',
                ]);
        }

        $diagnostic = $this->deviceStatusService->determineStatus($device);

        if (!$this->isPushEligibleDiagnostic($diagnostic['status'])) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_CONFLICT)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'El dispositivo no está en un estado adecuado para una prueba FCM.',
                    'data' => [
                        'provider_id' => $providerId,
                        'device_id' => (int) $device['id_dispositivo_proveedor_gateway'],
                        'device_status' => $diagnostic,
                    ],
                ]);
        }

        $eventIdentifier = $this->generateEventIdentifier();
        $eventId = $this->pushFcmEventModel->createPendingEvent(
            (int) $device['id_dispositivo_proveedor_gateway'],
            $providerId,
            $eventIdentifier,
            'FCM_TEST'
        );

        if ($eventId === null) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'No se pudo registrar el evento FCM antes del envío.',
                ]);
        }

        try {
            $result = service('firebaseMessagingService')->sendToToken(
                (string) $device['token_fcm'],
                'FCM_TEST',
                [
                    'provider_id' => (string) $providerId,
                    'device_id' => (string) $device['id_dispositivo_proveedor_gateway'],
                    'channel' => 'SMS',
                    'event_id' => $eventIdentifier,
                ]
            );
        } catch (Throwable $exception) {
            $this->pushFcmEventModel->markError(
                $eventId,
                'FCM_CONFIGURATION_ERROR',
                $exception->getMessage()
            );

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'La configuración de Firebase no es válida.',
                    'errors' => $exception->getMessage(),
                ]);
        }

        $serverTime = date('Y-m-d H:i:s');

        if ($result['success'] === true) {
            $this->supplierDeviceModel->markPushSent(
                (int) $device['id_dispositivo_proveedor_gateway'],
                $serverTime
            );
            $this->pushFcmEventModel->markAccepted(
                $eventId,
                (string) $result['message_id'],
                $serverTime
            );

            return $this->response->setJSON([
                'type' => 'success',
                'message' => 'Push enviado correctamente',
                'data' => [
                    'provider_id' => $providerId,
                    'device_id' => (int) $device['id_dispositivo_proveedor_gateway'],
                    'event' => $result['event'],
                    'event_id' => $eventIdentifier,
                    'message_id' => $result['message_id'],
                    'device_status' => $diagnostic,
                    'server_time' => $serverTime,
                ],
            ]);
        }

        $this->supplierDeviceModel->recordPushError(
            (int) $device['id_dispositivo_proveedor_gateway'],
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

        if ($result['should_clear_token'] === true) {
            $this->supplierDeviceModel->clearFcmToken(
                (int) $device['id_dispositivo_proveedor_gateway']
            );

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'type' => 'error',
                    'message' => 'El token FCM del dispositivo es inválido y fue limpiado.',
                    'data' => [
                        'provider_id' => $providerId,
                        'device_id' => (int) $device['id_dispositivo_proveedor_gateway'],
                        'event' => $result['event'],
                        'event_id' => $eventIdentifier,
                        'error_code' => $result['error_code'],
                        'error_message' => $result['error_message'],
                    ],
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_BAD_GATEWAY)
            ->setJSON([
                'type' => 'error',
                'message' => 'No se pudo enviar el push FCM.',
                'data' => [
                    'provider_id' => $providerId,
                    'device_id' => (int) $device['id_dispositivo_proveedor_gateway'],
                    'event' => $result['event'],
                    'event_id' => $eventIdentifier,
                    'error_code' => $result['error_code'],
                    'error_message' => $result['error_message'],
                ],
            ]);
    }

    private function isPushEligibleDiagnostic(string $status): bool
    {
        $blockedStatuses = [
            DeviceStatusService::STATUS_DISABLED,
            DeviceStatusService::STATUS_OFFLINE,
            DeviceStatusService::STATUS_SERVICE_ERROR,
            DeviceStatusService::STATUS_SERVICE_STOPPED,
            DeviceStatusService::STATUS_NETWORK_ERROR,
        ];

        return !in_array($status, $blockedStatuses, true);
    }

    private function generateEventIdentifier(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }
}
