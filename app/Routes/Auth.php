<?php
// Auth routes
$routes->get('/login', 'LoginController::index');
$routes->post('/login/auth', 'LoginController::loginAuth');
$routes->group('', ['filter' => 'authFilter'],static function($routes) {
  $routes->get('/dashboard', 'LoginController::dashboard');
  $routes->get('/is-logged-in', 'LoginController::is_logged_in');
  $routes->get('/logout', 'LoginController::logout');
});