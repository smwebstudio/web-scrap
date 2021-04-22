<?php
	
	require_once('scrape.class.php');
	
	// define('Base_URL', $_POST["base_url"]);
	define('Base_URL', 'https://10web.io/blog/');
	
	$articles_count = (isset($_POST["count"])) ? intval($_POST["count"]) : 12;
	$startDate = strtotime($_POST["startDate"]);
	$endDate = strtotime($_POST["endDate"]);
	
	
	
	
	$scrapedContent = new Scrape(Base_URL);  
	
	
	//Getting pagination last item value
	
	$last_page = $scrapedContent->xPathObj->query('//a[@class="next page-numbers"]/preceding-sibling::a[1]');
	$last_page_value = intval($last_page->item(0)->nodeValue);
	
	//Getting all blog pages URLs
	
	$url_list = [];
	
	for ($i = 0; $i <= 2; $i++) {
		$next_url = Base_URL . 'page/' . $i . '/?sort_by=recent';
		array_push($url_list, $next_url);
	}
	
	$posts_data = [];
	$finish = false;
	
	
	// For each unique results page URL
	
	foreach ($url_list as $url) {
		
		
		
		
		$page_for_scrappig = new Scrape($url);		
		
		
		//Setting each post elements
		
		$posts = $page_for_scrappig->xPathObj->query('//div[contains(@class, "blog-post post")]');
		
		$posts_count = $posts->length; 
		
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
			
			
			
			
			if (count($posts_data) === $articles_count) {$finish = true; break;} 
			
			
			
			else if ($postDate >= $startDate && $postDate <= $endDate) {
				
				// strtotime($post_date->item($i)->nodeValue) . "<br/>";
				
				
				
				$post_data = array_merge($post_data, array(
				"title"=>$post_names->item($i)->nodeValue,
				"author"=>$post_author->item($i)->nodeValue,
				"date"=>$post_date->item($i)->nodeValue,
				"excerpt"=>$post_excerpt->item($i)->nodeValue,
				"post_image"=>$post_image->item($i)->getAttribute('data-src'),
				"date_scraped"=>date("M d, Y"),
				
				));
				
				
			}
			
			else {break;}
			
			array_push($posts_data, $post_data);
			
			
			
		}
		
		if ($finish) {break;  }
		
		
		
		sleep(0.5);  // Maybe DDoS protection? Sending 1 request per second
		
		// $page_for_scrappig = NULL;
		
		
		
	}
	
	
	
	
	echo json_encode($posts_data);
	
	
	
	
	
?>