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

    return $users;
  }

  // Get Single users
  public function read_single($id)
  {
    $id = (int) $id;

    // Create query
    $q = $this->_conn->query('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);

    $data = $q->fetch(PDO::FETCH_ASSOC);

    return new User($data);
  }

  // Create user
  public function create(User $user)
  {
    // Create query
    $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email';

    // Prepare statement
    $stmt = $this->_conn->prepare($query);

    // Bind data
    $stmt->bindValue(':name', $user->name());
    $stmt->bindValue(':email', $user->email());

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
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
