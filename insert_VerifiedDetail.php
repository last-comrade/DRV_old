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
include_once("../classes/verify_details.php");

$db = new Database();
$mysql = $db->connect();

$in_usr = new VerifiedDetail($mysql);

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
        $verified_by = $u_data->data->id;
        if(!empty($data->message_id) && !empty($data->is_verified)){
          $in_usr->message_id = $data->message_id;
          $in_usr->is_verified = $data->is_verified;
          $in_usr->verified_by = $verified_by;

          if($in_usr->insert_verify()){
                http_response_code(200);//200 means ok
                echo json_encode(array(
                  "status" => 1,
                  "message" => "message verified successfully"
                ));
              }
              else {
                http_response_code(500);//500 means internal server error
                echo json_encode(array(
                  "status" => 0,
                  "message" => "failed to verify data"
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
