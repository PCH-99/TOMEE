		
 $(function() {  
	$("#switch").click(function() 
	{  
		if($('#flag').val() == 1)
		{
			$('.reg').css("width",'0%');
			$('.reg').css("height",'0px');
			$('.reg').css("opacity",'0');
			$('.log').css("border","5px solid #cef5f5");
			$('.footer').css("margin-top",'20px');
			
			$("#flag").val(2);
		}
		else if($('#flag').val() == 2)
		{
			$('.reg').css("width",'100%');
			$('.reg').css("height",'615px');
			$('.reg').css("opacity",'1');
			$('.log').css("border","1px");
			$('.footer').css("margin-top",'270px');
			
			$("#flag").val(1);
		}		
	});  
});	