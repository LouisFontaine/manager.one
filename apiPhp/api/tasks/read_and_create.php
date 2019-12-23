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

include_once '../../config/db_connect.php';
include_once '../../models/Task.php';
include_once '../../controller/TaskManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate tasks object
  $taskManager = new TaskManager($db);

  // tasks query
  $tasks = $taskManager->read();

  for ($i = 0; $i < count($tasks); $i++) {
    $tasks[$i] = $tasks[$i]->to_array();
  }

  // Get row count
  $num = count($tasks);

  // Check if any tasks
  if ($num > 0) {
    // Turn to JSON & output
    echo json_encode($tasks);
  } else {
    // No tasks
    echo json_encode(
      array('message' => 'No tasks Found')
    );
  }
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate tasks object
    $taskManager = new TaskManager($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);


    $task = new Task($data);

    // Create task
    if ($taskManager->create($task)) {
      echo json_encode(
        array('message' => 'task Created')
      );
    } else {
      echo json_encode(
        array('message' => 'task Not Created')
      );
    }
  } else {
    // Wrong method, we handle the error
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
  }
}
