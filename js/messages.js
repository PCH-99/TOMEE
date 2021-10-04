$(document).ready(function(){ 
		var height = $('.content_conver').prop('scrollHeight');
		$('.content_conver').scrollTop(height); 
		
		setTimeout(function() {
		var height = $('.content_conver').prop('scrollHeight');
		$('.content_conver').scrollTop(height); 
		},1200);
	}); 
	
 $(function() {  
	$("#send_messg").click(function() {  
		
		$('#send_messg').css('transform','scale(1.2)');
		$('#send_messg').css('color','#f054af');
		
		setTimeout(function() { 
		$('#send_messg').css('transform','scale(1)');
		$('#send_messg').css('color','black');
		},560);
		
		var messages = $("#content_messg").val();
		$("#content_messg").val("");
		
		if(messages != '')
		{
			$.ajax({  
				type: 'POST',  
				url: 'new_messg.php',
				data: {content_messg: messages},     
			});
		}
	});  
}); 		
			