<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		
		<title>Web Scraper</title>
		<meta name="description" content="Web Scraper">
		<meta name="author" content="Web Scraper">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<link rel="stylesheet" href="public/css/style.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	</head>
	
	<body>
		
		
		
		
		<div class="container">
			<h1>Web Scraper</h1>
			<p>Web application that scrapes<br/> and aggregates 10Web’s latest blog<br/> posts and shows them<br/> on the front page along with the top<br/> most used word per day</p>
			<form id="Scraper" action="">
				<div class="row">
					<div class="col-25">
						<label for="base_url">URL</label>
					</div>
					<div class="col-75">
						<input type="text" id="base_url" name="base_url" disabled placeholder="https://10web.io/blog/" value="https://10web.io/blog/">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="articles_count">Articles count</label>
					</div>
					<div class="col-75">
						<input type="text" id="articles_count" name="articles_count" placeholder="0">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="date_range">Date range</label>
					</div>
					<div class="col-75">						
						<input type="text" id="date_range" name="date_range" value="04/01/2021 - 04/30/2021" />
					</div>
				</div>
				<div class="row">
					<input type="submit" value="Submit">
				</div>
			</form>
			
			<div id="ScrapedData" class="scraped-data">
				<span class="scrap-info"></span>
				<table>
					<thead>
						<tr>
							<th>Title</th>
							<th>Author</th>
							<th>Image</th>
							<th>Excerpt</th>
							<th>Date</th>
							<th>Scraped date</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		
		<div id="loading" class="loading"><img src="public/img/preloader.gif" /></div>
		
		
		<script src="public/js/main.js"></script>
	</body>
</html>