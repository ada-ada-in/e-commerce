<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// admin
$routes->group('admin', static function($routes) {
    $routes->get('dashboard', 'PagesController::dashboard', ['as' => 'dashboard']);
});


//  auth
$routes->group('auth', static function($routes){
    // Views
    $routes->get('login', 'PagesController::login', ['as' => 'login']);
    $routes->get('register', 'PagesController::register', ['as' => 'register']);
});

// users 
$routes->group('users', static function($routes){
    // routes api
    $routes->post('', 'User\UserController::register', ['as' => 'register']);
    $routes->post('login', 'Auth\LoginController::login',['as' => 'login']);
});

