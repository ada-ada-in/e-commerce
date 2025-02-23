<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// admin
$routes->group('admin', static function($routes) {
    $routes->get('', 'PagesController::admin', ['as' => 'admin']);
    $routes->get('surat-masuk', 'PagesController::suratMasuk', ['as' => 'suratMasuk']);
    $routes->get('surat-keluar', 'PagesController::suratKeluar', ['as' => 'suratKeluar']);
    $routes->get('disposisi', 'PagesController::disposisi', ['as' => 'disposisi']);
    $routes->get('pengguna', 'PagesController::pengguna', ['as' => 'pengguna']);
    $routes->get('arsip', 'PagesController::arsip', ['as' => 'arsip']);
});


// auth
$routes->group('auth', static function($routes){
    $routes->get('login', 'PagesController::login', ['as' => 'login']);
});