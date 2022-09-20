<?php 
	
	session_start(); 
	
	if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
	{
		unset($_SESSION['count']);
		unset($_SESSION['old_news']);
	}
	
	if(isset($_POST['id']))
	{
		$id_postu = $_POST['id'];
		$id_autora = $_SESSION['logged'];
		
		require_once 'walidacja.php';
		
		$check_id = $id_postu;
		
		if(verify_id($check_id) == true)
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
					$query_user = "SELECT * FROM likes WHERE like_id_author = $id_autora AND like_id_post = $id_postu";
									
					if(!$execute_query = $connect->query($query_user))
					{
						throw new Exception($connect->error);
					}
					else
					{
						if($execute_query->num_rows == 0)
						{
							$query_user = "INSERT INTO likes VALUES (NULL,'$id_autora','$id_postu')";
							$execute_query = $connect->query($query_user);
									
							if(!$execute_query)
							{
								throw new Exception($connect->error);
							}
						}
						else 
						{
							$query_user = "DELETE FROM likes WHERE like_id_author = $id_autora AND like_id_post = $id_postu";
							$execute_query = $connect->query($query_user);
									
							if(!$execute_query)
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
		}
	}
	else header('Location:zaloguj-sie-do-tomee');
	
?>