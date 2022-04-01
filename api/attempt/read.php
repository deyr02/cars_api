<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/DatabaseConnection.php';
  include_once '../../model/Attempt.php';

  // Instantiate DB & connect
  $database = new DatabaseConnection();
  $db = $database->connect();

  // Instantiate blog post object
  $attempt = new Attempt($db);

  // Blog post query
  $result = $attempt->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $attempts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $attempt_item = array(
        'id' => $id,
        'isSubmitted' => $isSubmitted,
        'totalQuestions' => $totalQuestions,
        'totalCorrectAnswer' => $totalCorrectAnswer,
        'startedAt' => $startedAt,
        'finishedAt' => $finishedAt,
        'userId' => $userId
      );

      // Push to "data"
      array_push($attempts_arr, $attempt_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($attempts_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }