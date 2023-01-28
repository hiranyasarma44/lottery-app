<?php
// Game routes

$routes->group('', ['filter' => 'authFilter'],static function($routes) {
  $routes->get('/game/list', 'GameController::index');
  $routes->post('/game/create', 'GameController::create');
  $routes->post('/game/update', 'GameController::update');
  $routes->get('/game/delete/(:num)', 'GameController::delete/$1');
  $routes->get('/game/info/(:num)', 'GameController::getGameInfo/$1');
  $routes->get('/game/results/(:num)', 'GameController::getResults/$1');
});