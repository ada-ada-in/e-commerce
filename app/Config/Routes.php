<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// admin
// $routes->group('admin', ['filter' => 'auth'], static function($routes) {
$routes->group('admin', static function($routes) {
    $routes->get('dashboard', 'PagesController::dashboard', ['as' => 'dashboard']);
    $routes->get('product', 'PagesController::product', ['as' => 'product']);
    $routes->get('category', 'PagesController::category', ['as' => 'category']);
    $routes->get('paid', 'PagesController::paid', ['as' => 'paid']);
    $routes->get('pending', 'PagesController::pending', ['as' => 'pending']);
    $routes->get('due', 'PagesController::due', ['as' => 'due']);
    $routes->get('data', 'PagesController::data', ['as' => 'data']);
    $routes->get('order', 'PagesController::order', ['as' => 'order']);
    $routes->get('send', 'PagesController::send', ['as' => 'send']);
    $routes->get('pickup', 'PagesController::pickup', ['as' => 'pickup']);
    $routes->get('report', 'PagesController::report', ['as' => 'report']);
    $routes->get('users', 'PagesController::users', ['as' => 'users']);
    $routes->get('profile', 'PagesController::profile', ['as' => 'profile']);
});

// auth
$routes->group('auth', static function($routes) {
    $routes->get('login', 'PagesController::login', ['as' => 'login']);
    $routes->get('register', 'PagesController::register', ['as' => 'register']);
});


// api
$routes->group('api/v1', static function($routes) {
    $routes->group('auth', static function($routes) {
        $routes->post('login', 'Api\V1\auth\AuthController::login', ['as' => 'auth.login']);
        $routes->post('register', 'Api\V1\auth\AuthController::register', ['as' => 'auth.register']);
    });
});