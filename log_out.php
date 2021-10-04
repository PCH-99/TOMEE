<?php
session_start(); 

if(isset($_SESSION['logged']) || isset($_SESSION['first_logged']) || isset($_SESSION['conv']) || isset($_SESSION['count']) || isset($_SESSION['old_news'])) 
	{
		unset($_SESSION['first_logged']);
		unset($_SESSION['logged']);
		unset($_SESSION['conv']);
		unset($_SESSION['count']);
		unset($_SESSION['old_news']);
		header('Location:zaloguj-sie-do-tomee');
		exit();
	}
	else
	{
		header('Location:zaloguj-sie-do-tomee');
		exit();
	}
?>