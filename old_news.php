<?php 
	
	session_start(); 
	
	if(isset($_POST['working']))
	{
		$_SESSION['old_news'] = true;
	}
	else header('Location:zaloguj-sie-do-tomee');
	
?>