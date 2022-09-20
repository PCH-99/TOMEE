	
 $(function() {  
        $(".classkom").click(function() {  
			var id_postu = $(this).attr('id');
			var show_komm = 'kom' + id_postu;
			 $('#'+show_komm).addClass("comments");
			 $('.close_comm').css("opacity",'1');
				 
        });  
    }); 
	
	 $(function() {  
        $(".close_comm").click(function() {  
			 $('.nocomments').removeClass("comments");
			 $('.close_comm').css("opacity",'0');
        });  
    }); 
	
		
 $(function() {  
	$(".sub").click(function() {  
		var val_subm = $(this).attr('id');
		var komentarz = $("#komentarz"+val_subm).val();
		var komm = $("#komentarz"+val_subm).val("");
		
		if(komentarz != '')
		{
			var nick = $('#nick').attr('class');
		
			var today = new Date();
		
			var day = today.getDate();
			var month = today.getMonth()+1;
			switch(month)
			{
				case 1:
				{
					month = 'stycznia';
				}break;
				
				case 2:
				{
					month = 'lutego';
				}break;
				
				case 3:
				{
					month = 'marca';
				}break;
				
				case 4:
				{
					month = 'kwietnia';
				}break;
				
				case 5:
				{
					month = 'maja';
				}break;
				
				case 6:
				{
					month = 'czerwca';
				}break;
				
				case 7:
				{
					month = 'lipca';
				}break;
				
				case 8:
				{
					month = 'sierpnia';
				}break;
				
				case 9:
				{
					month = 'września';
				}break;
				
				case 10:
				{
					month = 'października';
				}break;
				
				case 11:
				{
					month = 'listopada';
				}break;
				
				case 12:
				{
					month = 'grudnia';
				}break;
			}
			var year = today.getFullYear();
			var second = today.getSeconds();
			if(second < 10) { second = "0" + second; }
			var minute = today.getMinutes();
			if(minute < 10) { minute = "0" + minute; }
			var hour = today.getHours();
			if(hour < 10) { hour = "0" + hour; }
		
		 
			var data = day+" "+month+" "+year+" "+hour+":"+minute+":"+second;
			
			var ile_kom = Number($(".ile_kom"+val_subm).attr('id')) + 1;
			$(".ile_kom"+val_subm).attr('id',ile_kom);
			$(".ile_kom"+val_subm).html(ile_kom);
			
			$('.pusty_komm'+val_subm).html(nick+" - skomentował/a "+data+" <div class='col-11 my-1 mx-auto p-2 tresc_komm'>"+komentarz+"</div>"); 
			
			$('.pusty_komm'+val_subm).addClass('comment mb-1 p-2 mx-auto');

			$(".comment").removeClass("pusty_komm"+val_subm);
			$("<div class='pusty_komm"+val_subm+" dodawanie_komm'></div>").insertAfter( "#add_comm_"+val_subm);
			
			if($("#brak_kom"+val_subm)) $("#brak_kom"+val_subm).css("display","none");
				
			$.ajax({  
				type: 'POST',  
				url: 'comments.php',
				data: {id_postu: val_subm, tresc: komentarz},     
			});
		}
	});  
});