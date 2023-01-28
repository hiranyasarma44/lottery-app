<?php
// public routes
$routes->get('/details/(:num)', 'Home::details/$1', ['as' => 'view.details']);
$routes->get('/view-more', 'Home::viewMore', ['as' => 'view.more']);
