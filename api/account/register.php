<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/DatabaseConnection.php';
include_once '../../model/User.php';

// creates new attempt , add attemtlines  and  returen the lizt of questions .

try{

   // Instantiate DB & connect
   $database = new DatabaseConnection();
   $db = $database->connect();

   // Instantiate blog post object
   $user = new User($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $user->firstName = $data->firstName;
  $user->lastName = $data->lastName;
  $user->dob = $data->dob;
  $user->phoneNumber = $data->phoneNumber;
  $user->email = $data->email;
  $user->password = $data->password;
 
//create the attempt row
  $result = $user->register();

}
catch(Exception $e){
  echo json_encode(array("success" => false, "data"=> null, "message" => $e->getMessage()));
}


