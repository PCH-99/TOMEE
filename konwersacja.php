<?php 

session_start();

if(!isset($_POST['nick_do_konwers']) && !isset($_SESSION['logged'])) 
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
			require_once 'walidacja.php';
			
			$interlocutor = $_POST['nick_do_konwers'];
			$check_interlocutor = $interlocutor;
			
			if(check_input($check_interlocutor) == true)
			{
				$id_user = $_SESSION['logged'];
				$query_user = "SELECT * FROM users WHERE id_user  = '$id_user' OR username = '$interlocutor'";

				if(!$execute_query = $connect->query($query_user))
				{
					throw new Exception($connect->error);
				}
				else
				{
					$rows = $execute_query->num_rows;
					
					if($rows != 2)
					{
						$execute_query->free_result();				
						$connect->close();
						header('Location:zaloguj-sie-do-tomee');
						exit();
					}
					
					for($i=1;$i<=$rows;$i++)
					{
						$result = $execute_query->fetch_assoc();
						if($result['id_user'] == $id_user)
						{
							$id_your = $result['id_user'];
							$username = $result['username'];
							$pp = $result['profile_picture'];
						}
						else if($result['username'] == $interlocutor)
						{
							$id_inloct = $result['id_user'];
							$username_inloct = $result['username'];
							$pp_inloct = $result['profile_picture'];
						}
					}
					
					$query_user = "SELECT * FROM conversations WHERE id_first_user = '$id_your' AND id_second_user = '$id_inloct' OR id_first_user = '$id_inloct' AND id_second_user = '$id_your'";

					if(!$execute_query = $connect->query($query_user))
					{
						throw new Exception($connect->error);
					}
					else
					{
						$conv = $execute_query->num_rows;

						if($conv == 0)
						{
							$query_add_conv = "INSERT INTO conversations VALUES(NULL,'$id_your','$id_inloct',DATE_ADD(NOW(), INTERVAL 2 HOUR))";

							if(!$execute_query_conv = $connect->query($query_add_conv))
							{
								throw new Exception($connect->error);
							}
							else
							{
								if(!$execute_query = $connect->query($query_user))
								{
									throw new Exception($connect->error);
								}
								else
								{
									$row = $execute_query->fetch_assoc();
									$id_convers = $row['id_conv'];
								}
							}
						}
						else
						{
							$row = $execute_query->fetch_assoc();
							$id_convers = $row['id_conv'];
						}
						
						$_SESSION['conv'] = $id_convers;
						$query_messg = "SELECT * FROM (SELECT * FROM messages WHERE id_convers = $id_convers ORDER BY date_messg DESC LIMIT 100) sort ORDER BY date_messg ASC";

						if(!$execute_query_messg = $connect->query($query_messg))
						{
							throw new Exception($connect->error);
						}
						$ile_messg = $execute_query_messg->num_rows;
					}
					
					$execute_query->free_result();				
					$connect->close();
				}
			}
			else
			{				
				$connect->close();
				header('Location:zaloguj-sie-do-tomee');
				exit();
			}
		}
	}
	catch(Exception $error)
	{
		$_SESSION['error'] = $error;
	}
}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<meta name="description" content="Serwis społecznościowy Tomee - Dołącz do nas!" />
	
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="jquery/jquery.min.js"></script>
	<script type="text/javascript" src="js/wallpaper.js"></script> <script src="/projekty/widget-comeback.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	<link rel="stylesheet" href="icofont/icofont.min.css">
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>Konwersacja</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
<?php

if($pp != 'Nie podano')
{
	$img = "'img/".$pp."'"; 
	echo '<script> $(document).ready(function(){ $(".img'.$id_user.'").css("background-image","url('.$img.')"); }); </script>'; 
}

if($pp_inloct != 'Nie podano')
{
	$img1 = "'img/".$pp_inloct."'"; 
	echo '<script> $(document).ready(function(){ $(".img'.$id_inloct.'").css("background-image","url('.$img1.')"); }); </script>'; 
}
?>
	<div class="container mt-5 pt-1 pb-1 userpage_container">
		
		<nav>
		
			<div class="row belka">
				
				<div class="col-5 col-sm-4 col-md-3 col-lg-2 px-2 navb">
				
					<header>
					
						<a href="strona-glowna"><img class="img-fluid" src="img/TOMEE_LOGO.png" alt="Tomee"/></a>
					
					</header>
				
				</div>
						
					
				<div class="col-6 col-md-5 col-lg-4 my-auto px-2 offset-sm-1 offset-md-3 offset-lg-5">
					
					<div class="float-right px-auto ml-2">
					
						<label>
								<button type="submit" form="szukaj" value="Submit"><img class="img-search" src="img/search-user.svg"/></button>
						</label>
						
					</div>
					
					<div class="float-right px-auto szukaj">
					
						<form id="szukaj" action="szukaj-znajomych" method="POST">
					
						<label>
								<input class="" name="search_fr" type="text" placeholder="Szukaj znajomych..."/>
						</label>
						
						</form>
						
					</div>
					
				</div>
					
				<div class="col-1 my-auto px-1 text-center header" id="settings"><span class="px-2 py-1">&#9776;</span></div>
			
			</div>
			
			<div id="sett" class="hidden_set"> 
			
				<ul class="px-0 text-center">
				
					<li><a href="twoje-konto">
					
						<div class="poster img mx-auto img<?= $id_your; ?>"></div>
						
						<div id="nick" class="<?= $username; ?>"><?= $username; ?></div>
					
					</a></li>
					
					<li><a href="konwersacje">Rozmowy</a></li>
					
					<li><a href="zmien-ustawienia">Ustawienia</a></li>
					
					<li><a href="dodaj-nowy-post">Utwórz post</a></li>
					
					<li><a href="wyloguj-sie">Wyloguj się</a></li>
				
				</ul>
			
			</div>
		
		</nav>
		
		<main>
			
			<article>
			
				<div class="row">
<?php				
if(isset($_SESSION['error'])) 
{
	echo "<div class='navb mb-3 px-4 text-danger'>Wystąpił błąd OMG. ".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}
?>					
					<div class="conversation col-10 col-sm-9 col-md-8 col-lg-7 mt-4 mx-auto p-0 mb-1">
						
						<div class="top_conver">
						
							<div class="poster_inloct img mx-auto img<?= $id_inloct; ?>"></div>
							
							<div id="nick" class="nick_inloct <?= $username_inloct; ?> d-inline-block"><?= $username_inloct; ?> - Rozmowa</div>
							
						</div>
						
						<div class="content_conver" id="content_conver">						
<?php
	if($ile_messg == 0)
	{
		echo '
		<div class="col-10 col-md-8 null_conver mx-auto text-center p-2 p-md-3">
		Trochę tu pusto jak na ulicach Night City...</div>
		';
	}
	else
	{
		if($ile_messg >= 50) echo '<div class="text-center old_news" id="old_news">Zobacz starsze wiadomości</div>';
		
		for($i=1;$i<=$ile_messg;$i++)
		{					
			$result = $execute_query_messg->fetch_assoc();
			
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
?>					
						</div><div style="clear:both"></div>
						
						<div class="send_conver">
						
							<div class="input_messg">							
								<p class="p_conv">
									<input id="content_messg" class="input_area" type="text" placeholder="Napisz coś..."/>
								</p>						
							</div>
							
							<div class="send_messg">
								<p class="p_conv float-left">								
									<button id="send_messg">
										<i class="icofont-paper-plane"></i>
									</button>							
								</p>
							</div>
							
							<div style="clear:both"></div>
							
						</div>
						
					</div>
					
				</div>
			
			</article>
			
		</main>
		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		
		<script src="bootstrap/bootstrap.min.js"></script>
		
		<script src="js/sticky.js"></script>
		
		<script src="js/messages.js"></script>
		
		<script src="js/ajax.js"></script>
		
		<script src="js/old_news.js"></script>
		
	</div>

</body>
</html>
