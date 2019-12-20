<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/db_connect.php';
  include_once '../../models/Task.php';

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
  if($num > 0) {
    // Tasks array
    $tasks_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
?>