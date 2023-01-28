<?php
$routes->group('', ['filter' => 'authFilter'],static function($routes) {
$routes->get('member/list', 'MemberController::index');
});