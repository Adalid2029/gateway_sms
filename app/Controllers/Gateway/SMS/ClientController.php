<?php

namespace App\Controllers\Gateway\SMS;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ClientController extends BaseController
{
    public function send()
    {
        $rules = [
            'message' => 'required|string',
            'to' => 'required|string',
        ];
    }
}
