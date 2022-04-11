<?php

include_once 'Quiz.php';
class AttemptLine{
   
    //Database 
    private $dbConnection;
    private $table = 'tbl_attempt_line';

    //attempt Properties
    public $attemptId;
    public $quizId;
    public $isAnswered;
    public $userSelection;
    

      // Constructor with DB
      public function __construct($db) {
        $this->dbConnection = $db;
      }

      //create AttemptLine
      public function create($_attemptId, $_quizId, $_isAnswered, $_userSelection ) {
      
        try{
              // Create query
            $query = 'INSERT INTO ' . $this->table . 
            ' SET attemptId = :attemptId,
                quizId = :quizId, 
                isAnswered = :isAnswered, 
                userSelection = :userSelection';

            // Prepare statement
            $stmt = $this->dbConnection->prepare($query);

            // Clean data
            $this->attemptId = $_attemptId;
            $this->quizId = $_quizId;
            $this->isAnswered = $_isAnswered;
            $this->userSelection = $_userSelection;
        
            // Bind data
            $stmt->bindParam(':attemptId', $this->attemptId);
            $stmt->bindParam(':quizId', $this->quizId);
            $stmt->bindParam(':isAnswered', $this->isAnswered);
            $stmt->bindParam(':userSelection', $this->userSelection);

            // Execute query
            
            $result = $stmt->execute();
            if($result){
                $attemptLine_arr = array(
                    'attemptId' => $this->attemptId,
                    'quizId' => $this->quizId,
                    'isAnswered' => $this->isAnswered,
                    'userSelection' => $this->userSelection
                );
                return $attemptLine_arr;
            }
            return null;
        }
        catch (Excetption $e){
            echo json_encode(array("success" => false, "message" => $e->getMessage()));
        }
     
  }

   //create AttemptLine
   public function readAllByAttempt($_attemptId) {
    try{
          //  query
          $query = 'SELECT * FROM ' . $this->table . ' WHERE attemptId = '. $_attemptId;      

        // Prepare statement
        $stmt = $this->dbConnection->prepare($query);
        // Execute query
        $result = $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0){
          $attempt_line_arr = array();

          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
              extract($row);
              $quiz = new Quiz($this->dbConnection);
              $quiz_result = $quiz->readSingle($row['quizId']);
             
              $attempt_line_item = array(
                'attemptId' => $row['attemptId'],
                'quizId' => $row['quizId'],
                'isAnswered' => $row['isAnswered'],
                'userSelection' => $row['userSelection'],
                'quiz' => $quiz_result
                ); 
              array_push($attempt_line_arr, $attempt_line_item);   
          }
          return $attempt_line_arr;
      }
      else{
      
          http_response_code(404);
          throw new Exception("Not found", 1);
      }
      
        return null;
    }
    catch (Excetption $e){
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }
 
}

public function update($_attemptId, $_quizId, $_isAnswered, $_userSelection){
  
  try{
    // Create query
  $query = 'UPDATE ' . $this->table . 
  ' SET attemptId = :attemptId,
      quizId = :quizId, 
      isAnswered = :isAnswered, 
      userSelection = :userSelection 
      WHERE attemptId = '. $_attemptId . ' AND quizId = ' . $_quizId ; 

    

  // Prepare statement
  $stmt = $this->dbConnection->prepare($query);

  // Clean data
  $this->attemptId = $_attemptId;
  $this->quizId = $_quizId;
  $this->isAnswered = $_isAnswered;
  $this->userSelection = $_userSelection;

  // Bind data
  $stmt->bindParam(':attemptId', $this->attemptId);
  $stmt->bindParam(':quizId', $this->quizId);
  $stmt->bindParam(':isAnswered', $this->isAnswered);
  $stmt->bindParam(':userSelection', $this->userSelection);

  // Execute query
  

  $result = $stmt->execute();   
  if($result){
    return true;
  }
  return false;

 
}
catch (Excetption $e){
  echo json_encode(array("success" => false, "message" => $e->getMessage()));
}


}


}