<?php
class User
{
  // Post Properties
  public $_id;
  public $_name;
  public $_email;

  public function __construct(array $data)
  {
    $this->hydrate($data);
  }

  // Hydrate function
  public function hydrate(array $data)
  {
    foreach ($data as $key => $value) {
      // On récupère le nom du setter correspondant à l'attribut.
      $method = 'set_' . ucfirst($key);

      // Si le setter correspondant existe.
      if (method_exists($this, $method)) {
        // On appelle le setter.
        $this->$method($value);
      }
    }
  }

  public function to_array()
  {
    $task_array = array(
      'id' => $this->_id,
      'name' => $this->_name,
      'email' => $this->_email
    );
    return $task_array;
  }

  // GETTERS
  public function id()
  {
    return $this->_id;
  }
  public function name()
  {
    return $this->_name;
  }
  public function email()
  {
    return $this->_email;
  }

  // SETERS
  public function set_id($id)
  {
    $this->_id = (int) $id;
  }
  public function set_name($name)
  {
    if (is_string($name)) {
      $this->_name = $name;
    }
  }
  public function set_email($email)
  {
    if (is_string($email)) {
      $this->_email = $email;
    }
  }
}
