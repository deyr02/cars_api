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


  // creates new attempt , add attemtlines  and  returen the lizt of questions .

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
    
    //hold the list of  attempt lines
    $attemptLine_arr = array();

    $quiz_arr = array();
    //For loop to get random questions.
    for($i = 0; $i < count($random_arr); $i++){
      
      //get the random quizid,
      $quizid = $quiz_id_arr[$random_arr[$i]];
      //ading attempt lines in attemtline table
      $attemptLine = new AttemptLine($db);
      $attemptLineResult = $attemptLine->create($attempt_id, $quizid, 0, "");
      array_push ($attemptLine_arr, $attemptLineResult);

      //get the question
      $question = $quiz->readSingle($quizid);
      //adding quistion into array
      array_push($quiz_arr, $question);
    }
    echo json_encode($quiz_arr);

}
catch(Exception $e){
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}


function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
  $numbers = range($min, $max);
  shuffle($numbers);
  return array_slice($numbers, 0, $quantity);
}