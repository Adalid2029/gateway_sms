<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);
$routes->get('/', 'Home::index');
$routes->group('v1', static function ($routes) {
    $routes->group('auth', static function ($routes) {
        $routes->post('mobile-login', 'Security\AuthController::mobileLogin');
    });
    $routes->group('gateway', static function ($routes) {
        $routes->group('sms', static function ($routes) {
            $routes->group('supplier', ['filter' => 'tokenAuth'], static function ($routes) {
                $routes->get('details-dashboard', 'Gateway\SMS\SupplierController::detailsDashboard');
            });
        });
    });
});
