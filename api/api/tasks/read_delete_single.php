<?php
// Headers required

// Access from any site or device (*)
header("Access-Control-Allow-Origin: *");

// Format of the data sent
header("Content-Type: application/json; charset=UTF-8");

// Autorized methods
header("Access-Control-Allow-Methods: GET, DELETE");

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

    // Instantiate Task object
    $Task = new Task($db);

    // Get ID
    $Task->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Task
    $Task->read_single();

    // Create array
    $Task = array(
        'id' => $Task->id,
        'user_id' => $Task->user_id,
        'title' => $Task->title,
        'description' => $Task->description,
        'creation_date' => $Task->creation_date,
        'status' => $Task->status
    );

    // Make JSON
    print_r(json_encode($Task));
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        // Instantiate blog post object
        $task = new Task($db);

        // Set ID to delete
        $task->id = isset($_GET['id']) ? $_GET['id'] : die();

        // Delete post
        if ($task->delete()) {
            echo json_encode(
                array('message' => 'Task deleted')
            );
        } else {
            echo json_encode(
                array('message' => 'Task not deleted')
            );
        }
    } else {
        // Wrong method, we handle the error
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
    }
}
