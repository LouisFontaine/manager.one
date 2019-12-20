<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/db_connect.php';
  include_once '../../models/Users.php';

   // Instantiate DB & connect
   $database = new Database();
   $db = $database->connect();
   
   // Instantiate users object
   $users = new Users($db);

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
?>