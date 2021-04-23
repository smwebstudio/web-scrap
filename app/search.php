<?php
require 'db_config.php';

$search_query = $_POST['query'];

// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$results = "";

	if (isset($search_query)) {
		$search = mysqli_real_escape_string($conn, $search_query);
		$sql = "SELECT * FROM posts WHERE excerpt LIKE '%$search%'";
	}else{
		$sql = "SELECT * FROM posts ORDER BY publish_date DESC";
	}
	$query = mysqli_query($conn, $sql);
	if (mysqli_num_rows($query) > 0) {
		
		while ($row = mysqli_fetch_assoc($query)) {
		$results .= "<div class='col-md-6 col-xs-12'>
             <div class='post'>
                 <img src='{$row['image_url']}' />
                 <h2>{$row['title']}</h2>
                 <p>Author: {$row['author']}</p>
                 <p>Post published date: {$row['publish_date']}</p>
                 <p>Post scraped date: {$row['scraped_date']}</p>
                 <p>{$row['excerpt']}</p>
             </div>
            </div>";
		}
		echo $results;
	}else{
		echo "<p class='noresult'>No record found</p>";
	}
