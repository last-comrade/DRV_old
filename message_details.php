<?php

class MessageDetail {

  //declare variables
  public $msg_code;
  public $msg_title;
  public $msg_content;
  public $msg_link;

  private $conn;
  private $table_name;

  public function __construct($db){
    $this->conn = $db;
    $this->table_name = "MessageDetail";
  }

  public function insert_message(){
    //sql query
    $query = "INSERT INTO ".$this->table_name." SET message_code = ?, message_title = ?, message_content = ?, message_link = ?";
    //prepare statement
    $obj = $this->conn->prepare($query);
    //sanitize input variables
    $this->msg_code = htmlspecialchars(strip_tags($this->msg_code));
    $this->msg_title = htmlspecialchars(strip_tags($this->msg_title));
    $this->msg_content = htmlspecialchars(strip_tags($this->msg_content));
    $this->msg_link = htmlspecialchars(strip_tags($this->msg_link));
    //bind parameters to sql $query
    $obj->bind_param("ssss",$this->msg_code,$this->msg_title,$this->msg_content,$this->msg_link);
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
