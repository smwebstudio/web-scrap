<?php
require 'db_config.php';

//Get search options
$search_query = $_POST['query'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$results = "";

if (isset($search_query) && $search_query != 50) {

    $search = mysqli_real_escape_string($conn, $search_query);
    $sql = "SELECT * FROM posts WHERE excerpt LIKE '%$search%'";
} else if (isset($startDate) && isset($endDate)) {
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);

    $sql = "SELECT * FROM posts WHERE publish_date BETWEEN date('$startDate') AND date('$endDate')";
} else {
    $sql = "SELECT * FROM posts ORDER BY publish_date DESC";
}
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {


    if (isset($search_query) && $search_query != 50) {

        $results .= "<div class='col-md-12 col-xs-12'><h2>Search results for <strong>" . $search_query . "</strong> query</h2></div>";
    } else if (isset($startDate) && isset($endDate)) {
        $results .= "<div class='col-md-12 col-xs-12'><h2>Search results from <strong>" . $startDate . "</strong> to <strong>" . $endDate . "</strong></h2></div>";
    }



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
} else {
    

    if (isset($search_query) && $search_query != 50) {

        echo "<p class='noresult'>No record found for " . $search_query . " query</p>";
    } else if (isset($startDate) && isset($endDate)) {
        echo "<p class='noresult'>No record found from " . $startDate . " to  " .$endDate . "</p>";
    }
}
