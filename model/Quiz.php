<?php

include_once 'quizOptions.php';

class Quiz{
   
    //Database 
    private $dbConnection;
    private $table = 'tbl_quiz';

    //attempt Properties
    public $id;
    public $isAnswerMultiple;
    public $answers;
    public $containImage;
    public $image;
    public $question;
   

      // Constructor with DB
      public function __construct($db) {
        $this->dbConnection = $db;
      }



      public function readAllQuizID(){        
        try{
          $query = 'SELECT id FROM ' . $this->table ;

          // Prepare statement
          $stmt = $this->dbConnection->prepare($query);

          // Execute query
          $result = $stmt->execute();

          $num = $stmt->rowCount();

          if($num > 0){
              $quiz_arr = array();

              while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  extract($row);
                  array_push($quiz_arr, $row['id']);
              }
              return $quiz_arr;
          }
          return null;
        }
        catch(Exception $e){
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
        }

      }

      public function read(){
        try{
            $query = 'SELECT * FROM ' . $this->table ;
       
            // Prepare statement
            $stmt = $this->dbConnection->prepare($query);
            // Execute query
            $result = $stmt->execute();
            //checking quiz is exist
            if($stmt->rowCount() >=1){
            
              //quiz arrry to store all quiz
             $quiz_arr = array(); 
             //creating Quiz option object
             $quiz_options = new QuizOptions($this->dbConnection);
              while($quiz_row = $stmt->fetch(PDO::FETCH_ASSOC))
              {
                 //extract($quiz_row);
                //get the question's  options            
                $quiz_options_result = $quiz_options->readAllQuizOptions($quiz_row['id']);
                $quiz_item = array(
                    'id' => $quiz_row['id'],
                    'isAnswerMultiple' => $quiz_row['isAnswerMultiple'],
                    'answers' => $quiz_row['answers'],
                    'containsImage' => $quiz_row['containsImage'],
                    'image' => $quiz_row['image'],
                    'question' => $quiz_row['question'],
                    'quizOptions' => $quiz_options_result
                    );  
                   
                    array_push ($quiz_arr, $quiz_item);
              }
             
                  return $quiz_arr;
          }
          else{
          
              http_response_code(404);
              throw new Exception("Not found", 1);
          }
        }
          catch(Exception $e){
          echo json_encode(array("success" => false, "message" => $e->getMessage()));
        }
      }

      public function readSingle($_quizId){
        try{
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = '. $_quizId;
            // Prepare statement
            $stmt = $this->dbConnection->prepare($query);
            // Execute query
            $result = $stmt->execute();
            //checking quiz is exist
            if($stmt->rowCount() >=1){
              //get the question's  options  
              $quiz_options = new QuizOptions($this->dbConnection);
              $quiz_options_result = $quiz_options->readAllQuizOptions($_quizId);
    
              $quiz_row = $stmt->fetch(PDO::FETCH_ASSOC);
              $quiz_item = array(
                  'id' => $quiz_row['id'],
                  'isAnswerMultiple' => $quiz_row['isAnswerMultiple'],
                  'answers' => $quiz_row['answers'],
                  'containsImage' => $quiz_row['containsImage'],
                  'image' => $quiz_row['image'],
                  'question' => $quiz_row['question'],
                  'quizOptions' => $quiz_options_result
                  );  
                  return $quiz_item;
          }
          else{
          
              http_response_code(404);
              throw new Exception("Not found", 1);
          }
        }
          catch(Exception $e){
          echo json_encode(array("success" => false, "message" => $e->getMessage()));
        }

      }




}