<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/DatabaseConnection.php';
  include_once '../../model/Quiz.php';

  // Instantiate DB & connect
  $database = new DatabaseConnection();
  $db = $database->connect();

  // Instantiate blog post object
  $quiz = new Quiz($db);

  // Blog post query
  $result = $quiz->read();
  // Get row count
  $num = count($result);

  // Check if any posts
  if($num > 0) {
   
 // Turn to JSON & output
    echo json_encode($result);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No quiz Found')
    );
  }