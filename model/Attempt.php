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

      // Create Attempt
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . 
            ' SET isSubmitted = :isSubmitted,
                totalQuestions = :totalQuestions, 
                totalCorrectAnswer = :totalCorrectAnswer, 
                startedAt = :startedAt,
                finishedAt = :finishedAt,
                userId = :userId';


        // Prepare statement
        $stmt = $this->dbConnection->prepare($query);

        // Clean data
        $this->isSubmitted = htmlspecialchars(strip_tags($this->isSubmitted));
        $this->totalQuestions = htmlspecialchars(strip_tags($this->totalQuestions));
        $this->totalCorrectAnswer = htmlspecialchars(strip_tags($this->totalCorrectAnswer));
        $this->startedAt = htmlspecialchars(strip_tags($this->startedAt));
        $this->finishedAt = htmlspecialchars(strip_tags($this->finishedAt));
        $this->userId = htmlspecialchars(strip_tags($this->userId));



        // Bind data
        $stmt->bindParam(':isSubmitted', $this->isSubmitted);
        $stmt->bindParam(':totalQuestions', $this->totalQuestions);
        $stmt->bindParam(':totalCorrectAnswer', $this->totalCorrectAnswer);
        $stmt->bindParam(':startedAt', $this->startedAt);
        $stmt->bindParam(':finishedAt', $this->finishedAt);
        $stmt->bindParam(':userId', $this->userId);


        // Execute query
        $stmt->execute();
        return $stmt;
     
  }




}