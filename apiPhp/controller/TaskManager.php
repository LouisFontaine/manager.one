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

    return $tasks;
  }

  // Get Single tasks
  public function read_single($id)
  {
    $id = (int) $id;

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);

    $data = $q->fetch(PDO::FETCH_ASSOC);

    return new Task($data);
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

    return $tasks;
  }

  // Create tasks
  public function create(Task $task)
  {
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
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
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
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: ", $stmt->error);

    return false;
  }

  public function set_conn(PDO $conn)
  {
    $this->_conn = $conn;
  }
}
