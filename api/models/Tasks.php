<?php
  class Tasks {
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
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get tasks
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single tasks
    public function read_single() {

    }

    // Create tasks
    public function create() {

    }

    // Update tasks
    public function update() {

    }
    
    // Delete tasks
    public function delete() {

    }
  }
?>