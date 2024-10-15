<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class TokenAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $tokenHeader = $request->getHeaderLine('Authorization');

        if (empty($tokenHeader)) {
            return service('response')->setJSON([
                'type' => 'error',
                'message' => 'Token not provided'
            ])->setStatusCode(401);
        }

        $token = explode(' ', $tokenHeader)[1] ?? '';
        $authenticator = auth('tokens')->getAuthenticator();

        $result = $authenticator->attempt(['token' => $token]);

        if (! $result->isOK()) {
            return service('response')->setJSON([
                'type' => 'error',
                'message' => 'Invalid token'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
