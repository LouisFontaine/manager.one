<?php
class Task
{
  // DB stuff
  private $conn;
  private $table = 'tasks';

  // Post Properties
  public $id;
  public $user_id;
  public $title;
  public $description;
  public $creation_date;
  public $status;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get tasks
  public function read()
  {
    // Create query
    $query = 'SELECT * FROM ' . $this->table;

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single tasks
  public function read_single()
  {
    // Create query
    $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set properties
    $this->id = $row['id'];
    $this->user_id = $row['user_id'];
    $this->title = $row['title'];
    $this->description = $row['description'];
    $this->creation_date = $row['creation_date'];
    $this->status = $row['status'];
  }

  // Get all tasks of a userID
  public function read_tasks_of_user()
  {
    // Create query
    $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = ?';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->user_id);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Create tasks
  public function create()
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET user_id = :user_id, title = :title, description = :description, creation_date = :creation_date, status =:status';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->description = htmlspecialchars(strip_tags($this->description));
    $this->creation_date = htmlspecialchars(strip_tags($this->creation_date));
    $this->status = htmlspecialchars(strip_tags($this->status));

    // Bind data
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':creation_date', $this->creation_date);
    $stmt->bindParam(':status', $this->status);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete tasks
  public function delete()
  {
  }
}
