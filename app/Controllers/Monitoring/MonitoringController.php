<?php

namespace App\Controllers\Monitoring;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Monitoring\MonitoringModel;
use App\Models\Monitoring\MessageModel;
use CodeIgniter\API\ResponseTrait;

class MonitoringController extends BaseController
{
    protected $format = 'json';
    protected $providerModel;
    protected $messageModel;
    use ResponseTrait;

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
}
