<?php
//include vendor
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

//include headers
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");

ini_set('display_errors',1);
//include requered files
include_once("../config/database.php");
include_once("../classes/user_details.php");

$db = new Database();
$mysql = $db->connect();

$in_usr = new UserDetail($mysql);

if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $data = json_decode(file_get_contents('php://input'));
    $all_headers = getallheaders();
    $data->jwt = $all_headers['Authorization'];
    if(!empty($data->jwt)) {
      $jwt = $data->jwt;
      $sec_key = "jar369";
      try {
        $u_data = JWT::decode($jwt,$sec_key, array('HS512'));
        $u_id = $u_data->data->id;
        if(!empty($data->user_name) && !empty($data->user_email) && !empty($data->user_pass) && !empty($data->user_mobile)){
          $in_usr->user_name = $data->user_name;
          $in_usr->user_email = $data->user_email;
          $in_usr->user_pass = PASSWORD_HASH($data->user_pass,PASSWORD_DEFAULT);
          $in_usr->user_mobile = $data->user_mobile;
          $in_usr->user_id = $u_id;

          if($in_usr->update_user()){
                http_response_code(200);//200 means ok
                echo json_encode(array(
                  "status" => 1,
                  "message" => "user updated successfully",
                ));
              }
              else {
                http_response_code(500);//500 means internal server error
                echo json_encode(array(
                  "status" => 0,
                  "message" => "failed to update data"
                ));
              }
        }
        else {
          http_response_code(404);//404 means not found
          echo json_encode(array(
            "status" => 0,
            "message" => "fill all values"
          ));
    }
  }
  catch(Exception $ex){
    http_response_code(503);//503 service not available
    echo json_encode(array(
      "status" => 0,
      "message" => "token expired"
    ));
  }
}
  else {
    http_response_code(503);//503 means service not available
    echo json_encode(array(
      "status" => 0,
      "message" => "please login to continue"
    ));
  }
}
else {
  http_response_code(503);//503 means service not available
  echo json_encode(array(
    "status" => 0,
    "message" => "access denied"
  ));
}

?>
