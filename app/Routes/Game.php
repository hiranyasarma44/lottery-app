<?php
// Game routes
$gameRoutes = [
  '/game/list' => 'GameController::index',
  '/game/create' => 'GameController::create'
];

$routes->map($gameRoutes);