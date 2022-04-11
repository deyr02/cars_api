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

    $_eamil = $data->email;
    $_password = $data->password;
 

  //create the attempt row
    $result = $user->login($_eamil, $_password);

    if($result->rowCount() ==1){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $account_item = array(
            'id' => $row['id'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'dob' => $row['dob'],
            'email' => $row['email'],
            'phoneNumber' => $row['phoneNumber'],
            'password' => $row['password'],
            'profileImage' => $row['profileImage']
            );
            echo json_encode(array("success" => true, "data"=>$account_item ,  "message" => ""));

     }
     else{
    
        echo json_encode(array("success" => false, "data"=> null ,  "message" => "Invlaid email or password"));

     }

}
catch(Exception $e){
    echo json_encode(array("success" => false, "data"=> null, "message" => $e->getMessage()));
}


