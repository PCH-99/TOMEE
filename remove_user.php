<?php 

session_start();

if(isset($_SESSION['count']) || isset($_SESSION['old_news']) || isset($_SESSION['conv']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
	unset($_SESSION['old_news']);
}

if(!isset($_SESSION['logged']) || !isset($_POST['soulkiller'])) 
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
			$id_user = $_SESSION['logged'];
			
			$query_select = "SELECT * FROM posts WHERE author_post  = '$id_user'";
			$query_delete = "DELETE FROM post WHERE author_post = '$id_user'";

			if(!$execute_query = $connect->query($query_select))
			{
				throw new Exception($connect->error);
			}
			else
			{
				if($execute_query->num_rows != 0)	
				{
					if(!$execute_query = $connect->query($query_delete))
					{
						throw new Exception($connect->error);
					}
				}
			}
			
			//------------------------------------------------------------------------------
			
			$defalut_deleted_username = 'Konto_nieaktywne#'.$id_user;
			$defalut_deleted_value = 'deleted';
			$ddv = $defalut_deleted_value;
			$default_deleted_pass = password_hash(rand(),PASSWORD_DEFAULT);
			
			$query_update = "UPDATE users SET username = '$defalut_deleted_username', email = '$ddv', password = '$default_deleted_pass', name = '$ddv', surname = '$ddv', job = '$ddv', country = '$ddv', gender = '$ddv', age = '$ddv', live_place = '$ddv', marital_status = '$ddv', profile_picture = 'Nie podano', profile_background = 'Nie podano' WHERE id_user = '$id_user'";

			if(!$execute_query = $connect->query($query_update))
			{
				throw new Exception($connect->error);
			}
			else
			{
				if($execute_query->num_rows != 0)	
				{
					if(!$execute_query = $connect->query($query_delete))
					{
						throw new Exception($connect->error);
					}
				}
			}
			
		}
		$connect->close();
	}
	catch(Exception $error)
	{
		$_SESSION['error'] = $error;
	}
	
	unset($_SESSION['logged']);
	header('Location:zaloguj-sie-do-tomee');
	exit();
	
	if(isset($_SESSION['error']))
	{
		echo 'Coś poszło nie tak podczas usuwania konta - '.$_SESSION['error'];
	}
}

?>