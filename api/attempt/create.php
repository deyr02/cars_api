<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/DatabaseConnection.php';
  include_once '../../model/Attempt.php';
  include_once '../../model/Quiz.php';
  include_once '../../model/AttemptLine.php';



try{

     // Instantiate DB & connect
     $database = new DatabaseConnection();
     $db = $database->connect();
 
     // Instantiate blog post object
     $attempt = new Attempt($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $attempt->isSubmitted = $data->isSubmitted;
    $attempt->totalQuestions = $data->totalQuestions;
    $attempt->totalCorrectAnswer = $data->totalCorrectAnswer;
    $attempt->startedAt = $data->startedAt;
    $attempt->finishedAt = $data->finishedAt;
    $attempt->userId = $data->userId;

  //create the attempt row
    $result = $attempt->create();
    //saving the attempt row id
    $attempt_id =  $db->lastInsertId();


    //creating quiz object
    $quiz = new Quiz($db);
    //get all the quiz ids 
    $quiz_id_arr = $quiz->readAllQuizID();

   // echo json_encode($result);

   //total number of questin for the quiz
    $numberOfQuestion = $data->totalQuestions;
   
    //get the random number of array between 0 and length ofr results
    $random_arr = UniqueRandomNumbersWithinRange(0, count($quiz_id_arr)-1, $numberOfQuestion);
    
    
    $attemptLine_arr = array();

    //For loop to get random questions.
    for($i = 0; $i < count($random_arr); $i++){
     
      $quizid = $quiz_id_arr[$random_arr[$i]];
       $attemptLine = new AttemptLine($db);
      $attemptLineResult = $attemptLine->create($attempt_id, $quizid, 0, "");
      array_push ($attemptLine_arr, $attemptLineResult);
    }

    echo json_encode($attemptLine_arr);


    // if($attempt->create()){

    // }else{
    //     echo json_encode(
    //         array('message' => 'Post Not Created')
    //       );
    // }




    //  // Blog post query
    //  $result = $attempt->read_single();
 
    //  if($result->rowCount() >=1){

    //     $row = $result->fetch(PDO::FETCH_ASSOC);
    //     $attempt_item = array(
    //         'id' => $row['id'],
    //         'isSubmitted' => $row['isSubmitted'],
    //         'totalQuestions' => $row['totalQuestions'],
    //         'totalCorrectAnswer' => $row['totalCorrectAnswer'],
    //         'startedAt' => $row['startedAt'],
    //         'finishedAt' => $row['finishedAt'],
    //         'userId' => $row['userId']
    //         );

    //     print_r(json_encode($attempt_item));

    //  }
    //  else{
    
    //      http_response_code(404);
    //      throw new Exception("Not found", 1);
    //  }
}
catch(Exception $e){
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}


function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
  $numbers = range($min, $max);
  shuffle($numbers);
  return array_slice($numbers, 0, $quantity);
}