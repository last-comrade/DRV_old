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
include_once("../classes/login.php");

$db = new Database();
$mysql = $db->connect();

$in_usr = new Login($mysql);

if($_SERVER['REQUEST_METHOD'] === "POST"){
  $data = json_decode(file_get_contents('php://input'));
  if(!empty($data->user_email) && !empty($data->user_pass)){
    $in_usr->user_email = $data->user_email;

    $user_data = $in_usr->check_login();
    if(!empty($user_data)){
      $email = $user_data['user_email'];
      $pass = $user_data['user_pass'];
      $name = $user_data['user_name'];

      if(password_verify($data->user_pass,$pass)){
        $iss = "DRV";
        $iat = time();
        $nbf = $iat + 3;
        $exp = $iat + 600;
        $aud = "drv_volunteers";
        $user_arr_data = array(
          'id' => $user_data['user_id'],
          'name' => $user_data['user_name'],
          'email' => $user_data['user_email'],
          'mobile' => $user_data['user_mobile'],
          'password' => $user_data['user_pass']
        );

        $secret_key = "jar369";

        $payload_info = array(
          "iss" =>$iss, //issuer
          "iat" =>$iat,  //in at current time
          "nbf" =>$nbf, //not before
          "exp" =>$exp, //expiry date
          "aud" =>$aud, //audience
          "data" => $user_arr_data
        );

        $jwt = JWT::encode($payload_info, $secret_key, 'HS512');

        http_response_code(200);
        echo json_encode(array(
          'status' => 1,
          'jwt' => $jwt,
          'message' => 'login successfully'
        ));
      }
      else {
        http_response_code(503);
        echo json_encode(array(
          'status' => 0,
          'message' => 'invalid password'
        ));
      }
    }
    else {
      http_response_code(503);
      echo json_encode(array(
        'status' => 0,
        'message' => 'invalid email address'
      ));
    }
  }
  else {
    http_response_code(404);
    echo json_encode(array(
      'status' => 0,
      'message' => 'fill all details'
    ));
  }
}
else {
  http_response_code(503);
  echo json_encode(array(
    'status' => 0,
    'message' => 'access denied'
  ));
}

?>
