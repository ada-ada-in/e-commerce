<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');



// admin
$routes->group('admin', static function($routes){
    $routes->group('', [], static function($routes){
        $routes->get('', 'PagesController::admin');
    });

    $routes->group('', [], static function($routes){
        $routes->get('surat-masuk', 'PagesController::suratMasuk', ['as' => 'suratMasuk']);
    });

    $routes->group('', [], static function($routes){
        $routes->get('surat-keluar', 'PagesController::suratKeluar', ['as' => 'suratKeluar']);
    });
});


// auth
$routes->group('auth', static function($routes){
    $routes->group('', [], static function($routes){
        $routes->get('identify', 'PagesController::admin');
    });
});