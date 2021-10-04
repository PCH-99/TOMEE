<?php 
	
	session_start(); 
	
	if(isset($_POST['content_messg']))
	{
		$content_messg = $_POST['content_messg'];
		$content_messg = trim(stripslashes(htmlspecialchars($content_messg, ENT_QUOTES)));
			
		require_once 'db_connect.php';
		
		if($content_messg != '')
		{
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
					$content_messg = mysqli_real_escape_string($connect,$content_messg);
					
					$id_autora = $_SESSION['logged'];
					$id_conver = $_SESSION['conv'];
					$query_messg = "INSERT INTO messages VALUES (NULL,'$id_conver','$id_autora','$content_messg',DATE_ADD(NOW(), INTERVAL 2 HOUR))";
					
					$id_conv = $_SESSION['conv'];
					$query_update_conv = "UPDATE conversations SET date_last_active = DATE_ADD(NOW(), INTERVAL 2 HOUR) WHERE id_conv = '$id_conv'";
					
					$execute_query_messg = $connect->query($query_messg);
					$execute_query_update = $connect->query($query_update_conv);
							
					if(!$execute_query_messg || !$execute_query_update)
					{
						throw new Exception($connect->error);
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