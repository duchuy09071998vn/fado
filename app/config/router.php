<?php

$router = $di->getRouter();

// Default route
$router->add('/', ['controller' => 'index', 'action' => 'index']);

// Define your routes here

$router->add('/user/login', ['controller' => 'user', 'action' => 'login']);
$router->add('/user/login/submit', ['controller' => 'user', 'action' => 'loginSubmit']);
$router->add('/signup/register', ['controller' => 'user', 'action' => 'register']);
$router->add('/signup/register/submit', ['controller' => 'user', 'action' => 'registerSubmit']);

$router->handle();
