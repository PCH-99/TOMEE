	
 $(function() {  
        $(".obserwuj").click(function() {  
			var flag = $(this).attr('id');
			var kogo_obs = document.getElementById("zaobserwuj").textContent;
			var followers = parseInt(document.getElementById("followers").textContent);
			var followers1 = parseInt(document.getElementById("followers1").textContent);
			
			if(flag == 'false')
			{
				$(".obserwuj").html("Obserwujesz <i class='icofont-ui-check'></i>");
				$(".obserwuj").attr("id","true");
				document.getElementById("followers").innerHTML = followers + 1;
				document.getElementById("followers1").innerHTML = followers1 + 1;
			}
			else
			{
				$(".obserwuj").html("Obserwuj <i class='icofont-plus'></i>");
				$(".obserwuj").attr("id","false");
				document.getElementById("followers").innerHTML = followers - 1;
				document.getElementById("followers1").innerHTML = followers1 - 1;
			}
			
			$.ajax({  
			    type: 'POST',  
			    url: 'zaobserwuj.php',
			    data: {zaobserwuj: kogo_obs},     
			});
        });  
    }); 