<?php
// Game routes
$routes->get('/game/list', 'GameController::index');
$routes->post('/game/create', 'GameController::create');
$routes->post('/game/update', 'GameController::update');
$routes->get('/game/info/(:num)', 'GameController::getGameInfo/$1');