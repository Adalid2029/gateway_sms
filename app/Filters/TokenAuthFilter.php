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
            return service('response')->setJSON(['error' => 'No token provided'])->setStatusCode(401);
        }

        $token = explode(' ', $tokenHeader)[1] ?? '';

        $authenticator = auth('tokens')->getAuthenticator();

        $result = $authenticator->attempt(['token' => $token]);

        if (! $result->isOK()) {
            return service('response')->setJSON(['error' => 'Invalid token'])->setStatusCode(401);
        }

        // Token is valid, you can access the user with auth()->user()
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
