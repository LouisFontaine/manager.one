<?php
// Headers required

// Access from any site or device (*)
header("Access-Control-Allow-Origin: *");

// Format of the data sent
header("Content-Type: application/json; charset=UTF-8");

// Autorized methods
header("Access-Control-Allow-Methods: GET");

// Timelife of a request
header("Access-Control-Max-Age: 3600");

// Authorized headers
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../models/Task.php';
include_once __DIR__ . '/../controller/TaskManager.php';

// Instantiate connect
$database = new Database();
$db = $database->connect();
$taskManager = new TaskManager($db);

// GET     http://localhost/manager.one/apiPhp/tasks
if ($url == '/manager.one/apiPhp/tasks' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $taskManager->read();
}

// POST    http://localhost/manager.one/apiPhp/tasks
if ($url == '/manager.one/apiPhp/tasks' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskManager->create();
}

// GET     http://localhost/manager.one/apiPhp/tasks/{taskID}
if (preg_match("/manager.one\/apiPhp\/tasks\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $taskManager->read_single($matches[1]);
}

// DELETE  http://localhost/manager.one/apiPhp/tasks/{taskID}
if (preg_match("/manager.one\/apiPhp\/tasks\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $taskManager->delete($matches[1]);
}

// GET  http://localhost/manager.one/apiPhp/users/{userID}/tasks
if (preg_match ("/manager.one\/apiPhp\/users\/([0-9]+)\/tasks/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $tasks = $taskManager->read_tasks_of_user($matches[1]);
}
