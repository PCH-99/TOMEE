<?php 

session_start();

if(isset($_SESSION['count']) || isset($_SESSION['old_news']) || isset($_SESSION['conv']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
	unset($_SESSION['old_news']);
}

if(!isset($_SESSION['logged']) || !isset($_POST['post'])) 
{
	header('Location:zaloguj-sie-do-tomee');
	exit();
}
else
{			
	require_once 'db_connect.php';
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connect = new mysqli($host,$db_user,$db_password,$db_name);
		
		if($connect->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$post = $_POST['post'];
			
			if(strlen($post) > 250)
			{
				$_SESSION['error_post'] = 'post może liczyć maksymalnie 250 znaków.';
				$connect->close();
				header('Location:dodaj-nowy-post');
				exit();
			}
			else if(strlen($post) == 0 || $post == ' ')
			{
				$_SESSION['error_post'] = 'nic nie wpisałeś XD.';
				$connect->close();
				header('Location:dodaj-nowy-post');
				exit();
			}
			else
			{
				$id_user = $_SESSION['logged'];
				$post = trim(stripslashes(htmlspecialchars($post, ENT_QUOTES)));
				$post = mysqli_real_escape_string($connect,$post);
				
				$query_post = "INSERT INTO posts VALUES (NULL,'$id_user','$post',DATE_ADD(NOW(), INTERVAL 2 HOUR))";

				if(!$execute_query = $connect->query($query_post))
				{
					throw new Exception($connect->error);
					$connect->close();
				}
				else
				{
					$connect->close();
					header('Location:twoje-konto');
					exit();
				}
				
			}
			
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error'] = $error;
	}
	
	if(isset($_SESSION['error']))
	{
		echo 'Coś poszło nie tak - '.$_SESSION['error'];
	}
}

?>