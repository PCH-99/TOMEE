
$(function() {  
    $(".show_password").click(function() 
		{  
		
		var x = document.getElementById("show_password");
		
		if (x.type === "password")
		{
			$("#show_password_icon").css('background-color','#e0d5db');
			x.type = "text";
		} 
		else 
		{
			$("#show_password_icon").css('background-color','white');
			x.type = "password";
		}
	});
			
});


$(function() {  
    $(".show_password1").click(function() 
		{  
		
		var x = document.getElementById("show_password1");
		
		if (x.type === "password")
		{
			$("#show_password_icon1").css('background-color','#e0d5db');
			x.type = "text";
		} 
		else 
		{
			$("#show_password_icon1").css('background-color','white');
			x.type = "password";
		}
	});
			
});  
	
$(function() {  
    $(".show_password_r").click(function() 
		{  
		var x = document.getElementById("show_password_r");
		if (x.type === "password")
		{
			$("#show_password_r_icon").css('background-color','#e0d5db');
			x.type = "text";
		} 
		else 
		{
			$("#show_password_r_icon").css('background-color','white');
			x.type = "password";
		}
	});
			
}); 	
		