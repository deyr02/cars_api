<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/DatabaseConnection.php';
  include_once '../../model/Attempt.php';


//update the attemptlinet
try{

     // Instantiate DB & connect
     $database = new DatabaseConnection();
     $db = $database->connect();
 
     // Instantiate blog post object
     $attempt = new Attempt($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $result = $attempt->Update($data->id, $data->isSubmitted, $data->totalCorrectAnswer, $data->finishedAt, $data->userId);

    if ($result){
     echo json_encode(array("success" => true ));
    }
    else{
      throw new  Exception("Update is not successful");
    }
  

}
catch(Exception $e){
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}


