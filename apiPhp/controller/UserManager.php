<?php
class UserManager
{
  // DB stuff
  private $_conn;
  private $table = 'users';

  // Constructor with DB
  public function __construct($conn)
  {
    $this->set_conn($conn);
  }

  // Get users
  public function read()
  {
    $users = [];

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table);

    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
      $users[] = new User($data);
    }

    for ($i = 0; $i < count($users); $i++) {
      $users[$i] = $users[$i]->to_array();
    }

    // Get row count
    $num = count($users);

    // Check if any tasks
    if ($num > 0) {
      // Turn to JSON & output
      echo json_encode($users);
    } else {
      // No users
      echo json_encode(
        array('message' => 'No users Found')
      );
    }
  }

  // Get Single users
  public function read_single($id)
  {
    $id = (int) $id;

    // get query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);

    $data = $q->fetch(PDO::FETCH_ASSOC);

    if ($data) {
      echo (json_encode($data));
    } else {
      echo json_encode(
        array('message' => 'User not found')
      );
    }
  }

  // Create user
  public function create()
  {
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);

    $user = new User($data);

    // Create user
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email';

    // Prepare statement
    $stmt = $this->_conn->prepare($query);

    // Bind data
    $stmt->bindValue(':name', $user->name());
    $stmt->bindValue(':email', $user->email());

    // Execute query
    if ($stmt->execute()) {
      echo json_encode(
        array('message' => 'user Created')
      );
      return true;
    } else {
      echo json_encode(
        array('message' => 'user Not Created')
      );
    }
  }

  // Delete user
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
      echo json_encode(
        array('message' => 'User deleted')
      );
      return true;
    }

    // Print error if something goes wrong
    printf("Error: ", $stmt->error);
    echo json_encode(
      array('message' => 'User not deleted')
    );
    return false;
  }

  public function set_conn(PDO $conn)
  {
    $this->_conn = $conn;
  }
}
