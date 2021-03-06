<?php
class UserManager
{
  // DB stuff
  private $_conn;
  const TABLE = "users";

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
    $q = $this->_conn->query('SELECT * FROM ' . UserManager::TABLE);

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
      return true;
    } else {
      // No users
      httpStatusAnswer::send404status('API can t find any user in the database');
      return false;
    }
  }

  // Get Single users
  public function read_single($id)
  {
    $id = htmlspecialchars(strip_tags($id));
    $id = (int) $id;

    $stmt = $this->_conn->prepare("SELECT * FROM " . UserManager::TABLE . " WHERE id = ?");
    $stmt->execute([$id]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;

    if ($data) {
      echo (json_encode($data));
      return true;
    } else {
      httpStatusAnswer::send404status('API can t find this user');
      return false;
    }
  }

  // Create user
  public function create()
  {
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"), true);

    $user = new User($data);

    // Create query
    $query = 'INSERT INTO ' . UserManager::TABLE . ' SET name = :name, email = :email';

    // Prepare statement
    $stmt = $this->_conn->prepare($query);

    // Bind data
    $stmt->bindValue(':name', htmlspecialchars(strip_tags($user->name())));
    $stmt->bindValue(':email', htmlspecialchars(strip_tags($user->email())));

    // Execute query
    try {
      $stmt->execute();
      httpStatusAnswer::send204status('The user was successfully created and added to the database');
      return true;
    } catch (Exception $e) {
      httpStatusAnswer::send424status('The user wasn t created : ' . $e->getMessage());
      return false;
    }
  }

  // Delete user
  public function delete($id)
  {
    $id = (int) $id;

    // Create query
    $query = 'DELETE FROM ' . UserManager::TABLE . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->_conn->prepare($query);

    // Bind Data
    $stmt->bindValue(':id', htmlspecialchars(strip_tags($id)));

    // Execute query
    try {
      $stmt->execute();
      if ($stmt->rowCount()) {
        httpStatusAnswer::send204status('The user was successfully deleted from the database');
        return true;
      } else {
        throw new Exception("No user witth this ID");
      }
    } catch (Exception $e) {
      httpStatusAnswer::send424status('User not deleted : ' . $e->getMessage());
      return false;
    }
  }

  public function set_conn(PDO $conn)
  {
    $this->_conn = $conn;
  }
}
