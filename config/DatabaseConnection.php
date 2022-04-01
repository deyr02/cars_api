<?php

class DatabaseConnection{

    //database config
    //MySql is using the port 3307 
    private $host = 'localhost:3307';
    private $db_name = 'cars_db';
    private $username = 'root';
    private $password = '';
    private $conn;

      // Database Connect
      public function connect() {
        $this->conn = null;
  
        try { 
          $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }
  
        return $this->conn;
      }

}