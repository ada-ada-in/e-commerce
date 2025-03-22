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
        $routes->post('login', 'Api\V1\auth\AuthController::login', ['as' => 'api.auth.login']);
        $routes->post('register', 'Api\V1\auth\AuthController::register', ['as' => 'api.auth.register']);
    });

    $routes->group('users', static function($routes) {
        $routes->get('', 'Api\V1\User\UserController::getDataUser', ['as' => 'api.users.getDataUser']);
        $routes->get('(:num)', 'Api\V1\User\UserController::getDataUserById/$1', ['as' => 'api.users.getDataUserById']);
        $routes->delete('(:num)', 'Api\V1\User\UserController::deleteDataUserById/$1', ['as' => 'api.userss.deleteDataUserById']);
        $routes->put('(:num)', 'Api\V1\User\UserController::updateDataUserById/$1', ['as' => 'api.users.updateDataUserById']);
    });

    $routes->group('category', static function($routes) {
        $routes->post('', 'Api\V1\Category\CategoryController::addCategory', ['as' => 'api.category.addCategory']);
        $routes->delete('(:num)', 'Api\V1\Category\CategoryController::deleteCategory/$1', ['as' => 'api.category.deleteCategory']);
        $routes->get('', 'Api\V1\Category\CategoryController::getDataCategory', ['as' => 'api.category.getDataCategory']);
        $routes->get('(:num)', 'Api\V1\Category\CategoryController::getDataCategoryById/$1', ['as' => 'api.category.getDataCategoryById']);
        $routes->put('(:num)', 'Api\V1\Category\CategoryController::updateDataCategoryById/$1', ['as' => 'api.category.updateDataCategoryById']);
    });

    $routes->group('transactions', static function($routes) {
        $routes->post('', 'Api\V1\Transactions\TransactionsController::addTransaction', ['as' => 'api.transactions.addTransaction']);
        $routes->delete('(:num)', 'Api\V1\Transactions\TransactionsController::deleteTransaction/$1', ['as' => 'api.transactions.deleteTransaction']);
        $routes->get('', 'Api\V1\Transactions\TransactionsController::getDataTransaction', ['as' => 'api.transactions.getDataTransaction']);
        $routes->get('(:num)', 'Api\V1\Transactions\TransactionsController::getDataTransactionById/$1', ['as' => 'api.transactions.getDataTransactionById']);
        $routes->put('(:num)', 'Api\V1\Transactions\TransactionsController::updateDataTransactionyById/$1', ['as' => 'api.transactions.updateDataTransactionyById']);
    }); 
    
});