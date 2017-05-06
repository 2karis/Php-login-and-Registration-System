<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'homecontroller:index')->setName('home');

$app->group('', function(){
	$this->get('/signup', 'authcontroller:getsignup')->setName('auth.signup');
	$this->post('/signup', 'authcontroller:postsignup');

	$this->get('/signin', 'authcontroller:getSignIn')->setName('auth.signin');
	$this->post('/signin', 'authcontroller:postSignIn');
})->add(new GuestMiddleware($container));

$app->group('', function(){
	$this->get('/signout', 'authcontroller:getsignout')->setName('auth.signout');

	$this->get('/change-password', 'authcontroller:getChangePassword')->setName('auth.password.change');
	$this->post('/change-password', 'authcontroller:postChangePassword');
})->add(new AuthMiddleware($container));

