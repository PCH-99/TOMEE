	
 $(function() {  
        $(".usuwanie").click(function() {  
			 $('.delete').addClass("showdelete"); 
        });  
    }); 

 $(function() {  
        $("#rezygnacja").click(function() {  
			 $('.delete').removeClass("showdelete"); 
        });  
    });