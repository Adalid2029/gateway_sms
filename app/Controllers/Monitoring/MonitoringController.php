<?php

namespace App\Controllers\Monitoring;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Monitoring\MonitoringModel;
use App\Models\Monitoring\MessageModel;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\LogParser;

class MonitoringController extends BaseController
{
    protected $format = 'json';
    protected $providerModel;
    protected $messageModel;
    protected $logParser;

    use ResponseTrait;

    public function __construct()
    {
        $this->providerModel = new MonitoringModel();
        $this->messageModel = new MessageModel();
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

        $activeProviders = $this->logParser->getActiveProviders(5); // 5 seconds threshold
        $providerDetails = $this->providerModel->getProvidersDetails($page, $limit, $search);
        foreach ($providerDetails as &$provider) {
            $activeProvider = array_filter($activeProviders, function ($ap) use ($provider) {
                return $ap['id'] == $provider['id'];
            });
            $provider['active'] = !empty($activeProvider);
            if (!empty($activeProvider)) {
                $activeProviderData = reset($activeProvider);
                $provider['last_activity'] = $activeProviderData['last_activity'];
                $provider['recent_actions'] = $activeProviderData['actions'];
            } else {
                $provider['last_activity'] = null;
                $provider['recent_actions'] = [];
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
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $this->providerModel->getTotalProvidersCount($search)
            ]
        ];

        return $this->respond($data);
    }
}