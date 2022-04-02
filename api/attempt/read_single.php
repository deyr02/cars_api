<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/DatabaseConnection.php';
  include_once '../../model/Attempt.php';

try{

     // Instantiate DB & connect
     $database = new DatabaseConnection();
     $db = $database->connect();
 
     // Instantiate blog post object
     $attempt = new Attempt($db);
 
     //get id from praameter
     $attempt->id = isset($_GET['id']) ? $_GET['id'] : die();
     // Blog post query
     $result = $attempt->read_single();
 
     if($result->rowCount() >=1){

        $row = $result->fetch(PDO::FETCH_ASSOC);
        $attempt_item = array(
            'id' => $row['id'],
            'isSubmitted' => $row['isSubmitted'],
            'totalQuestions' => $row['totalQuestions'],
            'totalCorrectAnswer' => $row['totalCorrectAnswer'],
            'startedAt' => $row['startedAt'],
            'finishedAt' => $row['finishedAt'],
            'userId' => $row['userId']
            );

        print_r(json_encode($attempt_item));

     }
     else{
    
         http_response_code(404);
         throw new Exception("Not found", 1);
     }
}
catch(Exception $e){
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}


 