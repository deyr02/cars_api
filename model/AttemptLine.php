<?php
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


}