<?php

// Headers required

// Access from any site or device (*)
header("Access-Control-Allow-Origin: *");

// Format of the data sent
header("Content-Type: application/json; charset=UTF-8");

// Autorized methods
header("Access-Control-Allow-Methods: GET, POST");

// Timelife of a request
header("Access-Control-Max-Age: 3600");

// Authorized headers
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/../controller/UserManager.php';
require_once __DIR__ . '/../core/httpStatusAnswer.php';

// Instantiate connect
$database = new Database();
$db = $database->connect();
$userManager = new UserManager($db);

// GET     http://localhost/manager.one/apiPhp/users
if ($url == '/manager.one/apiPhp/users' && $_SERVER['REQUEST_METHOD'] == 'GET') {
  $userManager->read();
}

// POST    http://localhost/manager.one/apiPhp/users
else if ($url == '/manager.one/apiPhp/users' && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $userManager->create();
}

// GET     http://localhost/manager.one/apiPhp/users/1
else if (preg_match("/manager.one\/apiPhp\/users\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
  $userManager->read_single($matches[1]);
}

// DELETE  http://localhost/manager.one/apiPhp/users/1
else if (preg_match("/manager.one\/apiPhp\/users\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
  $userManager->delete($matches[1]);
}

// If routes doesnt handle methods type
else if (($url == '/manager.one/apiPhp/users') || preg_match("/manager.one\/apiPhp\/users\/([0-9]+)/", $url, $matches)) {
  httpStatusAnswer::send405status('Method is not allowed or not handled by the API');
}

// If route not found return error 404
else {
  httpStatusAnswer::send404status('API can t map the client s URI to a resource');
}
