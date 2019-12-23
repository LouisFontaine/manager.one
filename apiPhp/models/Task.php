<?php
class Task
{
  // Task Properties
  private $_id;
  private $_user_id;
  private $_title;
  private $_description;
  private $_creation_date;
  private $_status;

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
      'user_id' => $this->_user_id,
      'title' => $this->_title,
      'description' => $this->_description,
      'creation_date' => $this->_creation_date,
      'status' => $this->_status
    );
    return $task_array;
  }

  // GETTERS
  public function id()
  {
    return $this->_id;
  }
  public function user_id()
  {
    return $this->_user_id;
  }
  public function title()
  {
    return $this->_title;
  }
  public function description()
  {
    return $this->_description;
  }
  public function creation_date()
  {
    return $this->_creation_date;
  }
  public function status()
  {
    return $this->_status;
  }

  // SETERS
  public function set_id($id)
  {
    $this->_id = (int) $id;
  }

  public function set_user_id($user_id)
  {
    $this->_user_id = (int) $user_id;
  }

  public function set_title($title)
  {
    if (is_string($title)) {
      $this->_title = $title;
    }
  }

  public function set_description($description)
  {
    if (is_string($description)) {
      $this->_description = $description;
    }
  }

  public function set_creation_date($creation_date)
  {
    $this->_creation_date = $creation_date;
  }

  public function set_status($status)
  {
    $this->_status = $status;
  }
}
