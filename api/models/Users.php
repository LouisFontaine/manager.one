<?php
  class Users {
    // DB stuff
    private $conn;
    private $table = 'users';

    // Post Properties
    public $id;
    public $name;
    public $email;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get users
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single users
    public function read_single() {

    }

    // Create users
    public function create() {

    }

    // Update users
    public function update() {

    }
    
    // Delete users
    public function delete() {

    }
  }
?>