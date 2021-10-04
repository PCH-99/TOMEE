		
$(document).ready(function() {
	$('#wrap_bio').click(function() {
		if($('#bio').hasClass('open_bio'))
			{
				$('.info_user').removeClass('open_bio');
				setTimeout(function() {
					document.getElementById('wrap_bio').innerHTML = 'Rozwiń ponownie informacje <i class="icofont-simple-down"></i>';
				}, 500);
				
			}	
			else
			{
				$('.info_user').addClass('open_bio');
				setTimeout(function() {
					document.getElementById('wrap_bio').innerHTML = 'Zwiń informacje <i class="icofont-simple-up"></i>';
				}, 500);
			}
	});
})
