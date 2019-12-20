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
    include_once '../../models/User.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
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
        if($num > 0) {
        // users array
        $users_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
    }else{
        // Mauvaise méthode, on gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
    }


?>