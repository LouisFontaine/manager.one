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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate users object
    $User = new User($db);

    // Get ID
    $User->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get user
    $User->read_single();

    // Create array
    $User = array(
        'id' => $User->id,
        'name' => $User->name,
        'email' => $User->email
    );

    // Make JSON
    print_r(json_encode($User));
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        // Instantiate user
        $user = new User($db);

        // Set ID to delete
        $user->id = isset($_GET['id']) ? $_GET['id'] : die();

        // Delete user
        if ($user->delete()) {
            echo json_encode(
                array('message' => 'User deleted')
            );
        } else {
            echo json_encode(
                array('message' => 'User not deleted')
            );
        }
    } else {
        // Wrong method, we handle the error
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
    }
}
