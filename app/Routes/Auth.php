<?php
// Auth routes
$routes->get('/login', 'LoginController::index');
$routes->post('/login/auth', 'LoginController::loginAuth');
$routes->get('/dashboard', 'LoginController::dashboard');
$routes->get('/logout', 'LoginController::logout');