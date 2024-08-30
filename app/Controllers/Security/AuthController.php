<?php

namespace App\Controllers\Security;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends ResourceController
{
    protected $format = 'json';

    public function mobileLogin()
    {
        log_message('debug', 'Received data: ' . json_encode($this->request->getJSON(true)));

        // Validate credentials
        $rules = setting('Validation.login') ?? [
            'email' => [
                'label' => 'Auth.email',
                'rules' => 'required|valid_email',
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required',
            ],
            'device_name' => [
                'label' => 'Device Name',
                'rules' => 'required|string',
            ],
        ];

        $data = $this->request->getJSON(true);
        if (!$this->validateData($data, $rules, [], config('Auth')->DBGroup)) {
            return $this->response
                ->setJSON(['type' => 'error', 'message' => $this->validator->getErrors()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Get the credentials for login
        $credentials = array_intersect_key($data, array_flip(setting('Auth.validFields')));
        $credentials['password'] = $data['password'];

        // Attempt to login
        $result = auth()->attempt($credentials);
        if (!$result->isOK()) {
            return $this->response
                ->setJSON(['type' => 'error', 'message' => $result->reason()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Generate token and return to client
        $token = auth()->user()->generateAccessToken($data['device_name']);

        return $this->response
            ->setJSON(['token' => $token->raw_token]);
    }
}
