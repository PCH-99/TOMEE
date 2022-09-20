
function old_news()
{
	var activity = true;
		
	$.ajax({  
	type: 'POST',  
	url: 'old_news.php',
	data: {working: activity},     
	});

}
		
	
