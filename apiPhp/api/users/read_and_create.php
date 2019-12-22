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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate users object
    $users = new User($db);

    // users query
    $result = $users->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any users
    if ($num > 0) {
        // users array
        $users_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $users_item = array(
                'id' => $id,
                'name' => $name,
                'email' => $email
            );

            // Push to "data"
            array_push($users_arr, $users_item);
        }

        // Turn to JSON & output
        echo json_encode($users_arr);
    } else {
        // No users
        echo json_encode(
            array('message' => 'No users Found')
        );
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Instantiate DB & connect
      $database = new Database();
      $db = $database->connect();
  
      // Instantiate task object
      $user = new User($db);
  
      // Get raw posted data
      $data = json_decode(file_get_contents("php://input"), true);
  
      $user->name = $data["name"];
      $user->email = $data["email"];
  
      // Create user
      if ($user->create()) {
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