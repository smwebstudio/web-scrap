<?php

require 'db_config.php';

// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts ORDER BY publish_date DESC";
$data = [];
if ($result = $conn -> query($sql)) {
    while($row = $result->fetch_assoc())
        {
            $data[] = $row;
        }
    
  }

$conn -> close();
?>