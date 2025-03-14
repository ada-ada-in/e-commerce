<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// admin
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
});