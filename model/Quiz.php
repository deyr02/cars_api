<?php
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

}