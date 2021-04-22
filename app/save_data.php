<?php

require '../config.php';

// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// query to save scraped posts 

$sql = "INSERT INTO posts (author, excerpt, image_url, publish_date, scraped_date)
VALUES ('test', 'test', 'test', '2021-7-04', '2021-8-08');";


if ($conn->multi_query($sql) === TRUE) {
    echo "Posts saved";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
?>