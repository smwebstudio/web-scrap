<?php

require '../db_config.php';

//Get data from POST

$posts_data = $_POST["data"];



// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// query to save scraped posts 



$posts = [];

foreach ($posts_data as $post) {
    $title = $conn -> real_escape_string($post['title']);
    $author = $conn -> real_escape_string($post['author']);
    $excerpt = $conn -> real_escape_string($post['excerpt']);
    $image_url = $conn -> real_escape_string($post['post_image']);

    $publish_date = date("Y-m-d", strtotime($post['date']));
    $publish_date = $conn -> real_escape_string($publish_date);

    $scraped_date = date("Y-m-d", strtotime($post['date_scraped']));
    $scraped_date = $conn -> real_escape_string($scraped_date);



    $values[] = "('$author', '$title', '$excerpt', '$image_url', '$publish_date', '$scraped_date' )"; // quoted value, to escape sql injection 
}

$query_values = implode(',', $values);


$sql = "INSERT INTO posts (author, title, excerpt, image_url, publish_date, scraped_date) VALUES $query_values";

if ($conn->multi_query($sql) === TRUE) {
    echo "Posts saved";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
?>