<?php
//include headers
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");

ini_set('display_errors',1);
//include requered files
include_once("../config/database.php");
include_once("../classes/verify_details.php");

$db = new Database();
$mysql = $db->connect();

$in_usr = new VerifiedDetail($mysql);

if($_SERVER['REQUEST_METHOD'] === "GET") {

  $data = $in_usr->get_all_data();

  if($data->num_rows > 0){
    $res['records'] = array();
    while($row = $data->fetch_assoc()){
      array_push($res['records'],array(
        'verification_id' => $row['verification_id'],
        'message_id' => $row['message_id'],
        'is_verified' => $row['is_verified'],
        'verified_by' => $row['verified_by']
      ));
    }
    http_response_code(200);
    echo json_encode(array(
      'status' => 1,
      'message' => 'success',
      'data' => $res['records']
    ));
  }
  else {
    http_response_code(200);
    echo json_encode(array(
      'status' => 1,
      'message' => 'no records found',
      'data' => []
    ));
  }
}
else {
  http_response_code(503);
  echo json_encode(array(
    'status' => 0,
    'message' => 'access denied',
    'data' => []
  ));
}

?>
