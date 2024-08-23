<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);
$routes->get('/', 'Home::index');
$routes->group('v1/auth', static function ($routes) {
    $routes->post('mobile-login', 'Security\AuthController::mobileLogin');
});
