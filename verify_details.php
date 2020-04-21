<?php

class VerifiedDetail {

  //declare variables
  public $message_id;
  public $is_verified;
  public $msg_content;

  private $conn;
  private $table_name;

  public function __construct($db){
    $this->conn = $db;
    $this->table_name = "VerificationDetail";
  }

  public function insert_verify(){
    //sql query
    $query = "INSERT INTO ".$this->table_name." SET message_id = ?, is_verified = ?, verified_by = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->message_id = htmlspecialchars(strip_tags($this->message_id));
    $this->is_verified = htmlspecialchars(strip_tags($this->is_verified));
    $this->verified_by = htmlspecialchars(strip_tags($this->verified_by));
    //bind parameters to sql $query
    $obj->bind_param("iii",$this->message_id,$this->is_verified,$this->verified_by);
    if($obj->execute()){
      return true;
    }

    return false;
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
