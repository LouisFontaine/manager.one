<?php
require __DIR__ . '/../config/db_connect.php';
require __DIR__ . '/../core/Router.php';
require __DIR__ . '/../routes.php';

$router = new Router;
$router->setRoutes($routes);

$url = $_SERVER['REQUEST_URI'];

$fileName = $router->getFilename($url);

if ($fileName) require __DIR__ . '/../api/' . $router->getFilename($url);
else {
    echo json_encode(
        array(
            'status' => '404',
            'title' => 'Not Found Exception',
            'details' => 'API can t map the client s URI to a resource',
            'type' => 'about:blank'
        )
    );
}
