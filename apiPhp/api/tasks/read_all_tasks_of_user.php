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

include_once '../../config/db_connect.php';
include_once '../../models/Task.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate tasks object
    $tasks = new Task($db);

    // Get ID
    $tasks->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

    // tasks query
    $result = $tasks->read_tasks_of_user();

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
    // Wrong method, we handle the error
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
