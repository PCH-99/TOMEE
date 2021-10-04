<?php 
	
session_start();

if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
}
	
if(isset($_POST['zaobserwuj']))
{
	$kogo_obs = $_POST['zaobserwuj'];
	$id_autora = $_SESSION['logged'];
	
	require_once 'walidacja.php';
	
	$kogo_obsw = $kogo_obs;
	
	if(check_input($kogo_obsw) == true)
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
				$query_user = "SELECT id_user FROM users WHERE username = '$kogo_obs'";
								
				if(!$execute_query = $connect->query($query_user))
				{
					throw new Exception($connect->error);
				}
				else
				{
					$row = mysqli_fetch_assoc($execute_query);
					$id_watched = $row['id_user'];
					
					$query_user = "SELECT * FROM observations WHERE id_observer = $id_autora AND id_watched = $id_watched";
									
					if(!$execute_query1 = $connect->query($query_user))
					{
						throw new Exception($connect->error);
					}
					else
					{
						if($execute_query1->num_rows == 0)
						{
							$query_user = "INSERT INTO observations VALUES (NULL,'$id_autora','$id_watched')";
							$execute_query = $connect->query($query_user);
									
							if(!$execute_query)
							{
								throw new Exception($connect->error);
							}
							else
							{
								//function update followers users table
								update_followers($id_autora,$id_watched,$connect);
							}
						}
						else 
						{
							$row = mysqli_fetch_assoc($execute_query1);
							$id_observations = $row['id_obs'];
							
							$query_user = "DELETE FROM observations WHERE id_obs = $id_observations";
							$execute_query = $connect->query($query_user);
									
							if(!$execute_query)
							{
								throw new Exception($connect->error);
							}
							else
							{
								//function update followers users table
								update_followers($id_autora,$id_watched,$connect);
							}
						}
					}
				}
			}
			$execute_query->free_result();
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