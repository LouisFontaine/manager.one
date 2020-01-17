<?php
class TaskManager
{
  // DB stuff
  private $_conn;
  private $table = 'tasks';

  // Constructor with DB
  public function __construct($conn)
  {
    $this->set_conn($conn);
  }

  // Get tasks
  public function read()
  {
    $tasks = [];

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table);

    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
      $tasks[] = new Task($data);
    }

    for ($i = 0; $i < count($tasks); $i++) {
      $tasks[$i] = $tasks[$i]->to_array();
    }

    // Get row count
    $num = count($tasks);

    // Check if any tasks
    if ($num > 0) {
      // Turn to JSON & output
      echo json_encode($tasks);
      return true;
    } else {
      // No tasks
      httpStatusAnswer::send404status('API can t find any tasks in the database');
      return false;
    }
  }

  // Get Single tasks
  public function read_single($id)
  {
    $id = (int) $id;

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);

    $data = $q->fetch(PDO::FETCH_ASSOC);

    if ($data) {
      echo (json_encode($data));
      return true;
    } else {
      httpStatusAnswer::send404status('API can t find this task');
      return false;
    }
  }

  // Get all tasks of a userID
  public function read_tasks_of_user($id)
  {
    $tasks = [];
    $id = (int) $id;

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table . ' WHERE user_id = ' . $id);

    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
      $tasks[] = new Task($data);
    }

    for ($i = 0; $i < count($tasks); $i++) {
      $tasks[$i] = $tasks[$i]->to_array();
    }
    // Get row count
    $num = count($tasks);
    if ($num > 0) {
      // Turn to JSON & output
      echo json_encode($tasks);
      return true;
    } else {
      // No tasks
      httpStatusAnswer::send404status('API can t find any tasks for this userID in the database');
      return false;
    }
  }

  // Create tasks
  public function create()
  {

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);

    $task = new Task($data);

    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET user_id = :user_id, title = :title, description = :description, creation_date = :creation_date, status =:status';

    // Prepare statement
    $stmt = $this->_conn->prepare($query);

    // Bind data
    $stmt->bindValue(':user_id', $task->user_id());
    $stmt->bindValue(':title', $task->title());
    $stmt->bindValue(':description', $task->description());
    $stmt->bindValue(':creation_date', $task->creation_date());
    $stmt->bindValue(':status', $task->status());

    // Execute query
    try {
      $stmt->execute();
      httpStatusAnswer::send204status('The task was successfully created and added to the database');
      return true;
    } catch (PDOException $e) {
      httpStatusAnswer::send424status('The user wasn t created ' . $e->getMessage());
      return false;
    }
  }

  // Delete tasks
  public function delete($id)
  {
    $id = (int) $id;

    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->_conn->prepare($query);

    // clean data
    $id = htmlspecialchars(strip_tags($id));

    // Bind Data
    $stmt->bindParam(':id', $id);

    // Execute query
    try {
      $stmt->execute();
      if ($stmt->rowCount()) {
        httpStatusAnswer::send204status('The task was successfully deleted from the database');
        return true;
      } else {
        throw new Exception("No task witth this ID");
      }
    } catch (Exception $e) {
      httpStatusAnswer::send424status('Task not deleted : ' . $e->getMessage());
      return false;
    }
  }

  public function set_conn(PDO $conn)
  {
    $this->_conn = $conn;
  }
}
