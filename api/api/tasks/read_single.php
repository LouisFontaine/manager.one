<?php
// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: GET");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
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
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
