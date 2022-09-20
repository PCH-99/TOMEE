var colors = new Array();
var rand = 0;

window.addEventListener("load",function () { setWall(); } );

function randColr()
{
	for(i=0; i<=6; i++)
	{
		rand = Math.floor(Math.random()*16);
		switch(rand)
		{
		case 10:
		rand = "A"; break;
		
		case 11:
		rand = "B"; break;
		
		case 12:
		rand = "C"; break;
		
		case 13:
		rand = "D"; break;
		
		case 14:
		rand = "E"; break;
		
		case 15:
		rand = "F"; break;
		}
		colors[i] = rand;
	}
	var color = "#"+colors[0]+colors[1]+colors[2]+colors[3]+colors[4]+colors[5];
	return color;
}

function wallp()
{
	document.getElementById("wp1").style.background = "linear-gradient(to top,"+randColr()+", black)";
	
	$('#wp2').css('opacity','0');

	setTimeout(function() { document.getElementById("wp2").style.background = "linear-gradient(to top, "+randColr()+", black)"; },3100);
	
	setTimeout(function() { $('#wp2').css('opacity','1'); },3100);
	
	setTimeout("wallp()",7100);

}

function setWall()
{
	for(i=1;i<=2;i++)
	{
		$('#wp'+i).css('transition','all 3s ease-in-out');
		$('#wp'+i).css('opacity','1');
		$('#wp'+i).css('position','fixed');
		$('#wp'+i).css('top','1%');
		
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
		{
			$('.hidden_set').css('top','8%');
			if($('.conversation'))
			{
				$('.conversation').css('height','75vh');
				$('.conversation').removeClass('mt-4');
				$('.content_conver').css('height','55vh');
				$('.input_messg').css('padding-top','4px');
				$('.top_conver').css('height','8vh'); //75 = 69
			}
		}
	}
	wallp();
	set_border();
}

function set_border()
{
	var width = window.innerWidth;
	var height = window.innerHeight;
	var per_height = height/100;
	var per_width = width/100;$('#nick');
	
	for(i=1;i<=2;i++)
	{
		if(height > width)
		{
			$('#wp'+i).css('left','2%');
			$('#wp'+i).css('min-height',(height - 3*per_height) + "px");
			$('#wp'+i).css('width',(width - 4*per_width) + "px");
			
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
			{
				if($('.conversation'))
				{
					$('.conversation').css('height','78vh');
					$('.input_messg').css('padding-top','2px');
					$('.send_messg').css('padding-top','1px');
					$('.send_messg').css('padding-bottom','1px');
					$('.top_conver').css('height','8vh');
					$('.conversation').css('margin-top','20px');
					$('.content_conver').css('height','59vh');
					$('.send_conver').css('font-size','3.5vh');
					$('.send_conver').css('height','7vh');
					$('.send_messg').css('font-size','4vh'); //75 = 69
				}
			}
		}
		else
		{
			$('#wp'+i).css('left','1%');
			$('#wp'+i).css('min-height',(height - 3*per_height) + "px");
			$('#wp'+i).css('width',(width - 2*per_width) + "px");
			
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
			{
				if($('.conversation'))
				{
					$('.conversation').css('height','70vh');
					$('.conversation').css('margin-top','0');
					$('.send_conver').css('height','8vh');
					$('.send_messg').css('padding-top','1px');
					$('.top_conver').css('height','8vh');
					$('.content_conver').css('height','45vh');
					$('.send_messg').css('font-size','5vh'); //70 = 63
				}
			}
		}
	}
	setTimeout("set_border()",10);
}