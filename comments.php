<?php 
	
	session_start(); 
	
	if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
	{
		unset($_SESSION['count']);
		unset($_SESSION['old_news']);
	}
	
	if(isset($_POST['id_postu']))
	{
		$id_postu = $_POST['id_postu'];
		require_once 'walidacja.php';
		
		if(verify_id($id_postu) == true)
		{
			if(isset($_POST['tresc']))
			{
				$content = $_POST['tresc'];
				
				$content = trim(stripslashes(htmlspecialchars($content, ENT_QUOTES)));
				
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
						$content = mysqli_real_escape_string($connect,$content);
						
						$id_autora = $_SESSION['logged'];
						$query_user = "INSERT INTO comments VALUES (NULL,'$id_autora','$id_postu','$content',DATE_ADD(NOW(), INTERVAL 2 HOUR))";
						$execute_query = $connect->query($query_user);
								
						if(!$execute_query)
						{
							throw new Exception($connect->error);
						}
					}
					$connect->close();
				}
				catch(Exception $error)
				{
					$_SESSION['error'] = $error;
				}
				
			}
			else header('Location:zaloguj-sie-do-tomee');
		}
	}
	else header('Location:zaloguj-sie-do-tomee');
