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
include_once '../../models/User.php';
include_once '../../controller/UserManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate tasks object
    $userManager = new UserManager($db);

    // Get ID
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Task
    $user = $userManager->read_single($id);

    // Make JSON
    echo (json_encode($user->to_array()));
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        // Instantiate tasks object
        $userManager = new UserManager($db);

        // Get ID
        $id = isset($_GET['id']) ? $_GET['id'] : die();

        // Delete task
        if ($userManager->delete($id)) {
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
