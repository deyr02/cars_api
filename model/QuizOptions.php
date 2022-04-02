<?php
class QuizOptions{
   
    //Database 
    private $dbConnection;
    private $table = 'tbl_quiz_options';

    //attempt Properties
    public $id;
    public $description;
    public $quizId;
   

      // Constructor with DB
      public function __construct($db) {
        $this->dbConnection = $db;
      }



      public function readAllQuizOptions($_quizId){

        $query = 'SELECT * FROM ' . $this->table . ' WHERE quizId = '. $_quizId;
        // Prepare statement
        $stmt = $this->dbConnection->prepare($query);

        // Execute query
        $result = $stmt->execute();

        $num = $stmt->rowCount();

        if($num > 0){
            $quiz_options_arr = array();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $quiz_option_item = array(
                  'id' => $row['id'],
                  'description' => $row['description'],
                  'quizId' => $row['quizId']
                );
                array_push($quiz_options_arr, $quiz_option_item);   
            }
            return $quiz_options_arr;
        }

        return null;

      }

}