<?php

namespace App\Controllers\Monitoring;

use App\Controllers\BaseController;
use App\Libraries\LogParser;
use App\Models\Gateway\SMS\SupplierDeviceModel;
use App\Models\Monitoring\MessageModel;
use App\Models\Monitoring\MonitoringModel;
use App\Services\Gateway\SMS\DeviceStatusService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class MonitoringController extends BaseController
{
    protected $format = 'json';
    protected $providerModel;
    protected $messageModel;
    protected $supplierDeviceModel;
    protected $deviceStatusService;
    protected $logParser;

    use ResponseTrait;

    public function __construct()
    {
        $this->providerModel = new MonitoringModel();
        $this->messageModel = new MessageModel();
        $this->supplierDeviceModel = new SupplierDeviceModel();
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
}
