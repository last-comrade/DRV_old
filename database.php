<?php

class Database {

  //declare variables
  private $hostname;
  private $dbname;
  private $username;
  private $password;
  private $conn;

  public function connect() {
    //initialize variables
    $this->hostname = "localhost";
    $this->dbname = "DRV";
    $this->username = "root";
    $this->password = "galileo";

    $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

    if($this->conn->connect_errno){
        return $this->conn->connect_error;
    }
    else{
      return $this->conn;
      //echo "--success--";
      //print_r($this->conn);
    }
  }

}

//$db = new Database();
//$db->connect();
 ?>
