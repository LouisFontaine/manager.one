<?php
class User
{
  // DB stuff
  private $conn;
  private $table = 'users';

  // Post Properties
  public $id;
  public $name;
  public $email;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get users
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

  // Get Single users
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
    $this->name = $row['name'];
    $this->email = $row['email'];
  }

  // Create user
  public function create()
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = strip_tags($this->email);

    // Bind data
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Delete user
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: ", $stmt->error);

    return false;
  }
}
