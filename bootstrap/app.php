<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Respect\Validation\Validator as v;

session_start();

require __DIR__ .'/../vendor/autoload.php';


$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails' => true,
    ],
    'db'=> [
        'driver'=>'mysql',
        'host'=>'localhost',
        'database'=>'scratch',
        'username'=>'root',
        'password'=>'',
        'collation'=>'utf_unicode_ci',
        'prefix'=>''
    ]   
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();


$container['db'] = function ($container) use ($capsule){
    return $capsule;  
};

$container['auth'] = function ($container){
    return new \App\Auth\Auth;
};

$container['view'] = function ($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth', $container->auth,[
            'check'=> $container->auth->check(),
            'user' =>$container->auth->user(),
        ]);
    $view->getEnvironment()->addGlobal('flash', $container->flash);

    return $view;
};

$container['validator'] = function ($container){
    return new App\Validation\Validator;
};
$container['homecontroller'] = function($container){
    return new \App\controllers\homecontroller($container);
};

$container['authcontroller'] = function($container){
    return new \App\controllers\auth\authcontroller($container);
};
$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard;
};
$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};



$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
//$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__.'/../app/routes.php';

