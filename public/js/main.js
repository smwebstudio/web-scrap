$(document).ready(function () {
	
	let startDate;
	let endDate;
	
	
	$('#date_range').daterangepicker({
		opens: 'center',
		drops: 'up',
	},
	function(start, end, label) {		
		startDate = start.format('YYYY-MM-DD');
		endDate = end.format('YYYY-MM-DD');
	});
	
	let posts_data;
	
	$("#Scraper").submit(function (event) {
		event.preventDefault();

		let formData = {
			base_url: $("#base_url").val(),
			count: $("#articles_count").val(),
			startDate: startDate,
			endDate: endDate,
		};
		
		$.ajax({
			type: "POST",
			url: "/app/scraper.php",
			data: formData,
			dataType: "json",
			encode: true,
			beforeSend: function() {
				$("#loading").show();
				console.log("test");
			},
			success: function(data) {
				console.log(data);
				console.log(data.length);

				posts_data = data;
				
				$("#ScrapedData").show();
				$("#ScrapedData table tbody").html('');
				$("#ScrapedData .scrap-info").html('');
				$("#ScrapedData .scrap-info").append('Articles scraped - ' + data.length);
				
				$.each(data, function(i) {
					$("#ScrapedData table tbody" ).append(
						"<tr><td>"+data[i].title+
						"</td><td>"+data[i].author+
						"</td><td>"+data[i].post_image+
						"</td><td>"+data[i].excerpt+
						"</td><td>"+data[i].date+
						"</td><td>"+data[i].date_scraped+
						"</td></tr>"
					);
				});
				
				$("#loading").hide();

				
			}
		});
		
		
	});


	$("#SaveData").click(function (event) {
		event.preventDefault();
		
		
		console.log(posts_data);

		let postsData = {
			data: posts_data
		};
		
		$.ajax({
			type: "POST",
			url: "/app/save_data.php",
			data: postsData,
			dataType: "json",
			encode: true,
			beforeSend: function() {
				$("#loading").show();
				
			},
			success: function(data) {
				console.log(data);
				console.log(data.length);

				
				$("#loading").hide();

				
			}
		});
		
	});


	function SearchData(query){
		$.ajax({
		  url : "app/search.php",
		  type: "POST",
		  chache :false,
		  data:{query:query},
		  success:function(data){
			$("#search_result").html(data).css("display", "flex");
		  }
		});  
	  };

	  $("#search").keyup(function(){
		var search = $(this).val();

		console.log(search);
		console.log(search.length);
		if (search.length >=3) { // Min 3 symbols to search proper queries, and not to load server too much
			SearchData(search);
		}else{
			$("#search_result").hide();
		}
	  });
	
	
	
	
});