<?php 
	
	session_start();
	
	if(!isset($_SESSION['conv']))
	{
		header('Location:zaloguj-sie-do-tomee');
		exit();
	}
	
	if(!isset($_SESSION['count'])) $_SESSION['count'] = 0;
	
	$last_value = $_SESSION['count'];
	
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
			$id_conv = $_SESSION['conv'];
			
			if(isset($_SESSION['old_news']))
			{
				$query_messg = "SELECT * FROM (SELECT * FROM messages WHERE id_convers = '$id_conv' ORDER BY date_messg DESC LIMIT 150) sort ORDER BY date_messg ASC";
			}
			else
			{
				$query_messg = "SELECT * FROM (SELECT * FROM messages WHERE id_convers = '$id_conv' ORDER BY date_messg DESC LIMIT 50) sort ORDER BY date_messg ASC";
			}
			
			$execute_query_messg = $connect->query($query_messg);
			
			$query_conv = "SELECT * FROM conversations WHERE id_conv = '$id_conv'";
			$execute_query_conv = $connect->query($query_conv);
			
			$query_rows = "SELECT * FROM messages WHERE id_convers = '$id_conv'";
			$execute_query_rows = $connect->query($query_rows);
					
			if(!$execute_query_messg || !$execute_query_conv || !$execute_query_rows)
			{
				throw new Exception($connect->error);
			}
			else
			{
				$users_id = $execute_query_conv->fetch_assoc();
				$your_id = $_SESSION['logged'];
				
				if($users_id['id_first_user'] == $your_id)
				{
					$id_user = $users_id['id_first_user'];
					$id_inloct = $users_id['id_second_user'];
				}
				else
				{
					$id_user =  $users_id['id_second_user'];
					$id_inloct = $users_id['id_first_user'];
				}
				
				
				$ile_messg = $execute_query_messg->num_rows;
				$ile_rows = $execute_query_rows->num_rows;
				$_SESSION['count'] = $ile_rows;
				
				if($last_value != $ile_rows) $is_change = 1;
				else $is_change = 0;
				
				if($ile_messg == 0)
				{
					echo '
					<div class="col-10 col-md-8 null_conver mx-auto text-center p-2 p-md-3">
					Trochę tu pusto jak na ulicach Night City...</div>
					';
				}
				else
				{
					if(!isset($_SESSION['old_news']) && $ile_rows > 50) echo '<div class="text-center old_news" id="old_news" onclick="old_news()">Zobacz starsze wiadomości</div>';
					
					for($i=1;$i<=$ile_messg;$i++)
					{					
						$result = $execute_query_messg->fetch_assoc();
					
						if($is_change == 1)
						{
							if($i < $ile_messg)
							{
								if($result['author_messg'] == $id_user)
								{
									echo '<div class="user"><div class="messages float-right my-1 mr-3">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
								}
								else if($result['author_messg'] == $id_inloct)
								{
									echo '<div class="interlocutor"><div class="messages float-left my-1 ml-3">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
								}
								
							}									
							else if($i == $ile_messg && $is_change == true)
							{
								if($result['author_messg'] == $id_user)
								{
									echo '<div class="user"><div class="messages float-right my-1 mr-3 last">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
								}
								else if($result['author_messg'] == $id_inloct)
								{
									echo '<div class="interlocutor"><div class="messages float-left my-1 ml-3 last">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
								}
							}
							
						}
						else if($is_change == 0)
						{
							if($result['author_messg'] == $id_user)
							{
								echo '<div class="user"><div class="messages float-right my-1 mr-3">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
							}
							else if($result['author_messg'] == $id_inloct)
							{
								echo '<div class="interlocutor"><div class="messages float-left my-1 ml-3">'.$result['content_messg'].'</div><div style="clear:both"></div></div>';
							}
						}
											
					}
					echo "<div class='licznik' style='opacity:".$is_change.";'></div>";
				}
			}
			$execute_query_messg->free_result();				
			$execute_query_conv->free_result();				
			$execute_query_rows->free_result();				
			$connect->close();
		}
		
	}
	catch(Exception $error)
	{
		$_SESSION['error'] = $error;
	}
	
	
	
?>