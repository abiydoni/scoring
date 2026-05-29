<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/sports', 'Sports::index');
$routes->get('/sports/select/(:any)', 'Sports::select/$1');

$routes->get('/anggota', 'Anggota::index');
$routes->post('/anggota/store', 'Anggota::store');
$routes->post('/anggota/update/(:num)', 'Anggota::update/$1');
$routes->get('/anggota/delete/(:num)', 'Anggota::delete/$1');

$routes->get('/panahan', 'Panahan::index');
$routes->get('/panahan/anggota/(:num)', 'Panahan::anggota/$1');
$routes->post('/panahan/create', 'Panahan::create');
$routes->get('/panahan/game/(:num)', 'Panahan::game/$1');
$routes->get('/panahan/game/(:num)/sesi/(:num)', 'Panahan::sesi/$1/$2');
$routes->post('/panahan/game/(:num)/shoot', 'Panahan::saveShoot/$1');

// Bulutangkis Routes
$routes->group('bulutangkis', function($routes) {
    $routes->get('/', 'Bulutangkis::index');
    $routes->get('riwayat/(:num)', 'Bulutangkis::riwayat/$1');
    $routes->post('create', 'Bulutangkis::create');
    $routes->get('scoring/(:num)', 'Bulutangkis::scoring/$1');
    $routes->post('update_score', 'Bulutangkis::update_score');
    $routes->post('finish_game', 'Bulutangkis::finish_game');
    $routes->post('finish_match', 'Bulutangkis::finish_match');
});

// User Tracking & Admin
$routes->post('/user/record-online', 'UserTracking::record_online');
$routes->get('/users', 'UserTracking::index');
