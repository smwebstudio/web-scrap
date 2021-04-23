<?php
	require 'scrape.class.php';
    require 'db_config.php';

    //Get scrapping options from CLI

    $shortopts  = "";

    $scraper_options  = array(
        "count:",     
        "startDate:",   
        "endDate:",  
    );
    
    $options = getopt(  $shortopts , $scraper_options);

    var_dump($options["count"]);
    var_dump($options["startDate"]);
    var_dump($options["endDate"]);
	
	$base_url = 'https://10web.io/blog/';
	$articles_count = (isset($options["count"])) ? intval($options["count"]) : 10;
	$startDate = (isset($options["startDate"])) ? strtotime($options["startDate"]) : strtotime('01/01/2000');
	$endDate = (isset($options["endDate"])) ? strtotime($options["endDate"]) : strtotime(date("m/d/Y"));


    var_dump($articles_count);
    var_dump($startDate);
    var_dump($endDate);
	//Getting pagination last item value for url list construction

	$scrapedContent = new Scrape($base_url); 
	$last_page = $scrapedContent->xPathObj->query('//a[@class="next page-numbers"]/preceding-sibling::a[1]');
	$last_page_value = intval($last_page->item(0)->nodeValue);
	
	//Getting all blog pages URLs
	
	$url_list = [];
	
	for ($i = 0; $i <= $last_page_value; $i++) {
		$next_url = $base_url . 'page/' . $i . '/?sort_by=recent'; //10web blog URL structure
		array_push($url_list, $next_url);
	}

	//Creating scraped data 
	
	$posts_data = [];
	$finish = false; // Checking if scrapping must finish
	
	
	// For each unique results page URL
	
	foreach ($url_list as $url) {
		
		$page_for_scrappig = new Scrape($url);
		
		//Setting each post elements
		
		$posts = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]'); //Getting all posts DomeNodeList
		
		$posts_count = $posts->length; //Post count for each page

        
		
		// $posts_count = (isset($articles_count)) ? $articles_count : $posts->length;
		
		$post_names = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]/div[@class="blog-post-content"]/h2[@class="blog-post-title entry-title section-title"]/a');
		$post_author = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]/div[@class="blog-post-content"]/div[@class="blog-post-footer clear"]/div[@class="post_info_contnet clear"]/div[@class="post-author-date"]/a');
		$post_date = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]/div[@class="blog-post-content"]/div[@class="blog-post-footer clear"]/div[@class="post_info_contnet clear"]/div[@class="post-author-date"]/time');
		$post_excerpt = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]/div[@class="blog-post-content"]/div[@class="entry-summary"]');
		$post_image = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]/div[@class="blog-img-container img_container"]/a/img');
		
		// echo "Post count - ".count($posts_data)."<br/>";
		// echo "Post must count - ".$articles_count."<br/>";
		
		for ($i = 0; $i < $posts_count; $i++) {	
			$post_data = []; 
			
			$postDate = strtotime($post_date->item($i)->nodeValue);

            
			
			if (count($posts_data) === $articles_count) {
				$finish = true; 
				break;
			}  else if ($postDate >= $startDate && $postDate <= $endDate) {
				
				
				$post_data = array_merge($post_data, array(
				"title"=>$post_names->item($i)->nodeValue,
				"author"=>$post_author->item($i)->nodeValue,
				"date"=>$post_date->item($i)->nodeValue,
				"excerpt"=>$post_excerpt->item($i)->nodeValue,
				"post_image"=>$post_image->item($i)->getAttribute('data-src'),
				"date_scraped"=>date("M d, Y"),
				"post_hash"=>sha1($post_excerpt->item($i)->nodeValue) //For further comparing stored posts
				)
            
            );
				
			}
			
			else {break;}
			
			array_push($posts_data, $post_data);
			
		}
		
		if ($finish) {break;  }
		
		sleep(0.5);  // Maybe DDoS protection? Sending 1 request per second
		
		// $page_for_scrappig = NULL;
		
	}
	
  
echo json_encode($posts_data, JSON_PRETTY_PRINT);
echo "\r\n ----------- \r\n ";
echo "Posts scraped: ".count($posts_data);
echo "\r\n ----------- \r\n ";


// Create connection
$conn = new mysqli(DB_Server, DB_User, DB_Pass, DB_Name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Creating mysqli query to save scraped posts 

$posts = [];

foreach ($posts_data as $post) {
    $title = $conn -> real_escape_string($post['title']);
    $author = $conn -> real_escape_string($post['author']);
    $excerpt = $conn -> real_escape_string($post['excerpt']);
    $image_url = $conn -> real_escape_string($post['post_image']); // TODO: save imgs to own server 
    $publish_date = date("Y-m-d", strtotime($post['date']));
    $publish_date = $conn -> real_escape_string($publish_date);
    $scraped_date = date("Y-m-d", strtotime($post['date_scraped']));
    $scraped_date = $conn -> real_escape_string($scraped_date);
	$post_hash = $conn -> real_escape_string($post['post_hash']); // TODO: compare whole hash instead of only post_excerpt

    $values[] = "('$author', '$title', '$excerpt', '$image_url', '$publish_date', '$scraped_date', '$post_hash' )"; // quoted value, to escape sql injection 
}

$query_values = implode(',', $values);

$sql = "INSERT IGNORE INTO posts (author, title, excerpt, image_url, publish_date, scraped_date, post_hash) VALUES $query_values"; //Unique hash values ignored 

if ($conn->multi_query($sql) === TRUE) {
	echo "\r\n ----------- \r\n ";
    echo "Posts saved to DB";
	echo "\r\n ----------- \r\n ";
  } else {
	echo "\r\n ----------- \r\n ";
    echo "Error: " . $sql . "<br>" . $conn->error;
	echo "\r\n ----------- \r\n ";
  }
  
  $conn->close();
	
?>