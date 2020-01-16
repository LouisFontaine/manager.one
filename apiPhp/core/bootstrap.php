<?php
require __DIR__.'/../config/db_connect.php';
require __DIR__.'/../core/Router.php';
require __DIR__.'/../routes.php';

$router = new Router;

$router->setRoutes($routes);

$url = $_SERVER['REQUEST_URI'];
require __DIR__.'/../api/'.$router->getFilename($url);
