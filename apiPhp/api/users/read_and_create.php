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
include_once '../../models/User.php';
include_once '../../controller/UserManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  // Instantiate connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate users object
  $userManager = new UserManager($db);

  // users query
  $users = $userManager->read();

  for ($i = 0; $i < count($users); $i++) {
    $users[$i] = $users[$i]->to_array();
  }

  // Get row count
  $num = count($users);

  // Check if any tasks
  if ($num > 0) {
    // Turn to JSON & output
    echo json_encode($users);
  } else {
    // No tasks
    echo json_encode(
      array('message' => 'No users Found')
    );
  }
} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Instantiate connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate users object
    $userManager = new UserManager($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);


    $user = new User($data);

    // Create user
    if ($userManager->create($user)) {
      echo json_encode(
        array('message' => 'user Created')
      );
    } else {
      echo json_encode(
        array('message' => 'user Not Created')
      );
    }
  } else {
    // Wrong method, we handle the error
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
  }
}
