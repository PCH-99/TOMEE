
var object = false;
 
if (window.XMLHttpRequest) object = new XMLHttpRequest();
else if (window.ActiveXObject) object = new ActiveXObject("Microsoft.XMLHTTP");
     
function getData(dataSource,divID)
{
    if (object.readyState==4 || object.readyState==0) 
    {
        var obj = document.getElementById(divID);

        object.open("POST", dataSource);
 
        object.onreadystatechange = function()
        {
            if (object.readyState == 4 && object.status == 200) 
            obj.innerHTML = object.responseText;
        }
         object.send(null);
	}
}

function set_scroll()
{
	var height = $('.content_conver').prop('scrollHeight');
	
	var look_scroll = height - $('.content_conver').height() - 100;
	
	if($('.content_conver').scrollTop() >= look_scroll)
	{
		$('.content_conver').scrollTop(height); 
	}
}

window.addEventListener("load",function () {
setTimeout( function() { xd(); },1000);
	} );

function odswiezaj()
{
	set_scroll();

	$('.last').css("opacity","1");
	
	setTimeout( function() { getData('ajax.php','content_conver'); }, 600);
		
	set_scroll();
}

function odswiezaj1()
{
	setTimeout( function() { getData('ajax.php','content_conver'); }, 500);
}


var zmiana = true;

function xd1()
{
	var licznik = $('.licznik').css("opacity");
	
	if(licznik != 1) 
	{
		zmiana = false;
	}	
	else 
	{
		zmiana = true;
	}
}

function xd()
{
	xd1();
	
	if(zmiana == true)
	{
		odswiezaj();
		setTimeout("xd()", 1200);
	}
	else if(zmiana == false)
	{
		odswiezaj1();
		setTimeout("xd()", 1000);
	}
	
}