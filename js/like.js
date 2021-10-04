	
 $(function() {  
        $(".polubxd").click(function() {  
			
			if($(this).hasClass('noliked'))
			{
				var id_postu = $(this).attr('id');
				var ile_like_przed_click = Number($("#like"+id_postu).attr('value'));
				var activity = true;
				
				 $("#like"+id_postu).html("Lubisz to " + (ile_like_przed_click + 1));
				 $("#like"+id_postu).attr("value",ile_like_przed_click + 1);
				 $(this).addClass("liked");
				 $("#"+id_postu).removeClass("noliked");
					 
				$.ajax({  
					type: 'POST',  
					url: 'like.php',
					data: {id: id_postu, working: activity},     
				});
			}
			else if($(this).hasClass('liked'))
			{
				var id_postu = $(this).attr('id');
				var ile_like_przed_click = Number($("#like"+id_postu).attr('value'));
				var activity = true;
				
				 $("#like"+id_postu).html("Nie lubię " + (ile_like_przed_click - 1));
				 $("#like"+id_postu).attr("value",ile_like_przed_click - 1);
				 $(this).addClass("noliked");
				 $("#"+id_postu).removeClass("liked");
					 
				$.ajax({  
					type: 'POST',  
					url: 'like.php',
					data: {id: id_postu, working: activity},     
				});
			}
			
        }); 
    }); 