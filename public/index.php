<?php
require 'app/show_data.php';
?>

<!doctype html>

<html lang="en">

<head>
	<meta charset="utf-8">

	<title>Web Scraper</title>
	<meta name="description" content="Web Scraper">
	<meta name="author" content="Web Scraper">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="public/css/style.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

	<div class="container">


		<?php if (!isset($data)) : ?>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<p>No posts scraped. Please see instructions
						<a href="https://github.com/smwebstudio/web-scrap#how-to-quickly-setup">here</a>
					</p>
				</div>
			</div>
		<?php else : ?>
			<div class="row">
				
				<div class="col-md-12 form-group">
					<input type="text" id="search" class="form-control" autocomplete="off" placeholder="Search in excerpt (min 3 symbols).."><br>
				</div>
				
			</div>

			<div id="search_result" class="row">

			</div>

			<div class="row">
				<?php foreach ($data as $post) : ?>

					<div class="col-md-6 col-xs-12">
						<div class="post">
							<img src="<?php echo $post['image_url'] ?>" />
							<h2><?php echo $post['title'] ?></h2>
							<p>Author: <?php echo $post['author'] ?></p>
							<p>Post published date: <?php echo $post['publish_date'] ?></p>
							<p>Post scraped date: <?php echo $post['scraped_date'] ?></p>
							<p><?php echo $post['excerpt'] ?></p>
						</div>
					</div>

				<?php endforeach; ?>
			<?php endif; ?>
			</div>
	</div>
	<script src="public/js/main.js"></script>
</body>

</html>