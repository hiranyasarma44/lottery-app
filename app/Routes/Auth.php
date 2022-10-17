<?php
// Auth routes
$loginRoutes = [
  '/login' => 'LoginController::index',
  '/auth' => 'LoginController::loginAuth',
];
$routes->map($loginRoutes);