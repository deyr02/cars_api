<?php
class User{
     //Database 
     private $dbConnection;
     private $table = 'tbl_user';
 
     //attempt Properties
     public $id;
     public $firstName;
     public $lastname;
     public $dob;
     public $email;
     public $phoneNumber;
     public $password;
     public $profileImage;

     
      // Constructor with DB
      public function __construct($db) {
        $this->dbConnection = $db;
      }


            // Get Posts
    public function login($_email, $_password) {
        try{
          // Create query
          $query = 'SELECT * FROM ' . $this->table. ' WHERE email= "'.$_email.'" AND password= "'.$_password.'"'; 
          // Prepare statement
          $stmt = $this->dbConnection->prepare($query);
          // Execute query
            $stmt->execute();
          return $stmt;
        }
        catch(Exception $e){
          echo json_encode(array("success" => false, "data"=>null, "message" => $e->getMessage()));
        }
        
      }

      public function register(){
        try{

            //Checking eamil
                $query = 'SELECT * FROM ' . $this->table. ' WHERE email= "'.$this->email.'"'; 
                // Prepare statement
                $stmt = $this->dbConnection->prepare($query);
                // Execute query
                 $stmt->execute();

                 if($stmt->rowCount()>=1){
                  echo json_encode(array("success" => false, "data"=>null, "message" => "Email is already registered."));
                  return; 
                 }




               // Create query
               $query1 = 'INSERT INTO ' . $this->table . 
               ' SET firstName = :firstName,
                   lastName = :lastName, 
                   dob = :dob, 
                   phoneNumber = :phoneNumber,
                   email = :email,
                   password = :password';

                // Prepare statement
                $stmt1 = $this->dbConnection->prepare($query1);

                // Bind data
                $stmt1->bindParam(':firstName', $this->firstName);
                $stmt1->bindParam(':lastName', $this->lastName);
                $stmt1->bindParam(':dob', $this->dob);
                $stmt1->bindParam(':phoneNumber', $this->phoneNumber);
                $stmt1->bindParam(':email', $this->email);
                $stmt1->bindParam(':password', $this->password);
           
            // Execute query
             $stmt1->execute();
             $newUserId = $this->dbConnection->lastInsertId();

             if($newUserId){
            echo json_encode(array("success" => true, "data"=>null, "message" => "register Successful"));
             }
            
          }
          catch(Exception $e){
            echo json_encode(array("success" => false, "data"=>null, "message" => $e->getMessage()));
          }
          
        }
      

}