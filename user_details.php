<?php

class UserDetail {

  //declare variables
  public $user_name;
  public $user_email;
  public $user_pass;
  public $user_mobile;
  public $user_id;

  private $conn;
  private $table_name;

  public function __construct($db){
    $this->conn = $db;
    $this->table_name = "UserDetail";
  }

  public function insert_user(){
    //sql query
    $query = "INSERT INTO ".$this->table_name." SET user_name = ?, user_email = ?, user_pass = ?, user_mobile = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->user_name = htmlspecialchars(strip_tags($this->user_name));
    $this->user_email = htmlspecialchars(strip_tags($this->user_email));
    $this->user_pass = htmlspecialchars(strip_tags($this->user_pass));
    $this->user_mobile = htmlspecialchars(strip_tags($this->user_mobile));
    //bind parameters to sql $query
    $obj->bind_param("ssss",$this->user_name,$this->user_email,$this->user_pass,$this->user_mobile);
    if($obj->execute()){
      return true;
    }

    return false;
  }

  public function update_user(){

    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    //sql query
    $query = "UPDATE ".$this->table_name." SET user_name = ?, user_email = ?, user_pass = ?, user_mobile = ? WHERE user_id = ".$this->user_id;
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->user_name = htmlspecialchars(strip_tags($this->user_name));
    $this->user_email = htmlspecialchars(strip_tags($this->user_email));
    $this->user_pass = htmlspecialchars(strip_tags($this->user_pass));
    $this->user_mobile = htmlspecialchars(strip_tags($this->user_mobile));
    //bind parameters to sql $query
    $obj->bind_param("ssss",$this->user_name,$this->user_email,$this->user_pass,$this->user_mobile);
    if($obj->execute()){
      return true;
    }

    return false;
  }

  public function validate_email(){
    //sql query
    $query = "SELECT user_id FROM ".$this->table_name." WHERE user_email = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->user_email = htmlspecialchars(strip_tags($this->user_email));
    //bind parameters to sql $query
    $obj->bind_param("s",$this->user_email);
    $obj->execute();
    $obj->store_result();
    if ($obj->num_rows >= 1) {
      return false;
    }

    return true;
  }

  public function validate_mobile(){
    //sql query
    $query = "SELECT user_id FROM ".$this->table_name." WHERE user_mobile = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->user_mobile = htmlspecialchars(strip_tags($this->user_mobile));
    //bind parameters to sql $query
    $obj->bind_param("s",$this->user_mobile);
    $obj->execute();
    $obj->store_result();
    if ($obj->num_rows >= 1) {
      return false;
    }

    return true;
  }

  public function get_all_data(){
    //sql query
    $query = "SELECT * FROM ".$this->table_name;
    //prepare statement
    $obj = $this->conn->prepare($query);

    $obj->execute();
    return $obj->get_result();
  }
}
 ?>
