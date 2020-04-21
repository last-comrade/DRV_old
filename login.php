<?php
class Login{
  //declare variables
  public $user_email;
  public $user_pass;

  private $conn;
  private $table_name;

  public function __construct($db){
    $this->conn = $db;
    $this->table_name = "UserDetail";
  }

  public function check_login(){
    //sql query
    $query = "SELECT * FROM ".$this->table_name." WHERE user_email = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->user_email = htmlspecialchars(strip_tags($this->user_email));
    //bind parameters to sql $query
    $obj->bind_param("s",$this->user_email);
    if ($obj->execute()) {
      $data = $obj->get_result();
      return $data->fetch_assoc();
    }

    return array();
  }
}

 ?>
