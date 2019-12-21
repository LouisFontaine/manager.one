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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate tasks object
  $tasks = new Task($db);

  // tasks query
  $result = $tasks->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any tasks
  if ($num > 0) {
    // Tasks array
    $tasks_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $tasks_item = array(
        'id' => $id,
        'user_id' => $user_id,
        'title' => $title,
        'description' => $description,
        'creation_date' => $creation_date,
        'status' => $status
      );

      // Push to "data"
      array_push($tasks_arr, $tasks_item);
    }

    // Turn to JSON & output
    echo json_encode($tasks_arr);
  } else {
    // No tasks
    echo json_encode(
      array('message' => 'No tasks Found')
    );
  }
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate task object
    $task = new Task($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);

    //echo json_encode($data);

    $task->user_id = $data["user_id"];
    $task->title = $data["title"];
    $task->description = $data["description"];
    $task->creation_date = $data["creation_date"];
    $task->status = $data["status"];

    // Create Category
    if ($task->create()) {
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
