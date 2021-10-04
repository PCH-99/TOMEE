		
$(document).ready(function() {
var navY = $('.belka').offset().top;

function stickynav()
	{
		
	var scrollY = $('.container').scrollTop();

		if (scrollY > navY)
			$('.belka').addClass('sticky');
		else 
			$('.belka').removeClass('sticky');
	};
	

$('.container').scroll(function() {
stickynav(); });

$('#settings').click(function() {
	if($('#sett').hasClass('show_set'))
	{
		$('.hidden_set').removeClass('show_set');
	}	
	else
	{
		$('.hidden_set').addClass('show_set');
	}
});

$('.container').scroll(function() {
$('.hidden_set').removeClass('show_set'); });

});
