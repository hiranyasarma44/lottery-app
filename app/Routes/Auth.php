<?php
// Auth routes
$authRoutes = [
  '/login' => 'LoginController::index',
  '/login/auth' => 'LoginController::loginAuth',
  '/dashboard' => 'LoginController::dashboard'
];

$routes->map($authRoutes);