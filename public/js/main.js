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
	
	
	$('#loadingDiv')
    .hide()  // Hide it initially
    .ajaxStart(function() {
        $(this).show();
	})
    .ajaxStop(function() {
        $(this).hide();
	})
	;
	
	
	
	$("#Scraper").submit(function (event) {
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
		
		event.preventDefault();
	});
	
	
	
	
});