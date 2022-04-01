<?php

class Attempt{

    //Database 
    private $dbConnection;
    private $table = 'tbl_attempt';

    //attempt Properties
    public $id;
    public $isSubmitted;
    public $totalQuestions;
    public $totalCorrectAnswer;
    public $startedAt;
    public $finishedAt;
    public $userId;
   

      // Constructor with DB
      public function __construct($db) {
        $this->dbConnection = $db;
      }

      // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT * FROM ' . $this->table ;       
        // Prepare statement
        $stmt = $this->dbConnection->prepare($query);
  
        // Execute query
        $stmt->execute();
  
        return $stmt;
      }

      public function read_single() {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = '.$this->id ;      

        // Prepare statement
        $stmt = $this->dbConnection->prepare($query);
  
        // Execute query
        $stmt->execute();
        
        return $stmt; 
        
      }
}