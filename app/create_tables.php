<?php

require 'db_config.php';

// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// query to create posts table
$sql = "CREATE TABLE posts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
author VARCHAR(100) NOT NULL,
title VARCHAR(300) NOT NULL,
excerpt VARCHAR(1500) NOT NULL,
image_url VARCHAR(1500),
publish_date DATE,
scraped_date DATE,
post_hash VARCHAR(150) NOT NULL UNIQUE
);";

// query to create most used words table

$sql .= "CREATE TABLE most_used_words (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(30) NOT NULL,
    date_used DATE,
    word_count INT(6)
    )";


if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
?>