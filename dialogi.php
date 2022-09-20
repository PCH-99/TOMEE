<?php 

session_start();

if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
}

if(!isset($_SESSION['logged'])) 
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
			$query_user = "SELECT * FROM users WHERE id_user  = '$id_user'";

			if(!$execute_query = $connect->query($query_user))
			{
				throw new Exception($connect->error);
			}
			else
			{
				$result = $execute_query->fetch_assoc();
				$username = $result['username'];
				$pp = $result['profile_picture'];
				$execute_query->free_result();
				
				$query_user = "SELECT * FROM conversations WHERE id_first_user = '$id_user' OR id_second_user = '$id_user' ORDER BY date_last_active DESC";

				if(!$execute_query = $connect->query($query_user))
				{
					throw new Exception($connect->error);
				}
				else
				{
					$ile_convs = $execute_query->num_rows;
					$id_inlocts = Array();
					$id_convs = Array();
					$flag_to_talk = Array();
						
					for($i=1;$i<=$ile_convs;$i++)
					{
						$result = $execute_query->fetch_assoc();
						$id_convs[$i] = $result['id_conv'];
						if($result['id_first_user'] == $id_user)
						{
							$id_inlocts[$i] = $result['id_second_user'];
							$want_to_talk[$i] = '';
						}
						else if($result['id_second_user'] == $id_user)
						{
							$id_inlocts[$i] = $result['id_first_user'];
							$want_to_talk[$i] = ' - chce porozmawiać';
						}
					}
				}
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
	<script src="js/wallpaper.js"></script>
	<script src="/projekty/widget-comeback.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	<link rel="stylesheet" href="icofont/icofont.min.css">
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>Rozmowy</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
	
	<div class="container mt-5 pt-1 pb-1 userpage_container">
		
		<nav>
		
			<div class="row belka">
				
				<div class="col-4 col-sm-3 col-md-3 col-lg-2 px-2 navb">
				
					<header>
					
						<a href="strona-glowna"><img class="img-fluid" src="img/TOMEE_LOGO.png" alt="Tomee"/></a>
					
					</header>
				
				</div>
						
					
				<div class="col-7 col-md-5 col-lg-4 my-auto px-2 offset-sm-1 offset-md-3 offset-lg-5">
					
					<div class="float-right px-auto ml-2">
					
						<label>
								<button type="submit" form="szukaj" value="Submit"><img class="img-search" src="img/search-user.svg"/></button>
						</label>
						
					</div>
					
					<div class="float-right px-auto szukaj">
					
						<form id="szukaj" action="szukaj-znajomych" method="POST">
					
						<label>
								<input type="text" name="search_fr" placeholder="Szukaj znajomych..."/>
						</label>
						
						</form>
						
					</div>
					
				</div>
					
				<div class="col-1 my-auto px-1 text-center header" id="settings"><span class="px-2 py-1">&#9776;</span></div>
			
			</div>
			
			<div id="sett" class="hidden_set"> 
			
				<ul class="px-0 text-center">
				
					<li><a href="twoje-konto">
					
						<div class="poster img mx-auto"></div>
						
						<div id="nick" class="<?php echo $username; ?>"><?php echo $username; ?></div>
					
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
				
				<div class="col-8 m-4 username text-center mx-auto"> Twoje konwersacje </div>
<?php 

if(isset($_SESSION['error'])) 
{
	echo "<div class='navb mb-3 px-4 text-danger'>Wystąpił błąd OMG. ".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}

if($pp != 'Nie podano')
{
	$img = "'img/".$pp."'"; 
	echo '<script> $(document).ready(function(){ $(".img").css("background-image","url('.$img.')"); }); </script>'; 
}

?>				
					
				</div>
				
				<div class="row">
<?php

if($ile_convs != 0)
{	
	for($i=1;$i<=$ile_convs;$i++)
	{
		$id_inloct = $id_inlocts[$i];
		$query_inloct = "SELECT * FROM users WHERE id_user = '$id_inloct'";

		if(!$execute_query_inloct = $connect->query($query_inloct))
		{
			throw new Exception($connect->error);
		}
		else
		{
			$row = mysqli_fetch_assoc($execute_query_inloct);
			$user = $row['username'];
			$pp_user = $row['profile_picture'];
				
			$id_conv = $id_convs[$i];
			$query_conv = "SELECT * FROM messages WHERE id_convers = '$id_conv' ORDER BY date_messg DESC LIMIT 1";

			if(!$execute_query_conv = $connect->query($query_conv))
			{
				throw new Exception($connect->error);
			}
			else
			{
				if($execute_query_conv->num_rows == 0)
				{
					$author_last_msg = 'Nikt';
					$content_msg = 'Tomee: Napisz pierwszy.'; 
					$date_msg = '';
					
					if(isset($want_to_talk)) $user = $user.$want_to_talk[$i];
				}
				else
				{
					$row1 = mysqli_fetch_assoc($execute_query_conv);
					$author_last_msg = $row1['author_messg'];
					$content_msg = $row1['content_messg']; 
					$date_msg = $row1['date_messg'];
					
					$date = date_create($date_msg);
					
					$day = date_format($date,"j");
					$month = date_format($date,"m");
					$year = date_format($date,"Y");
					$hour = date_format($date,"G");
					$min = date_format($date,"i");
					
					switch($month)
					{
						case 1:
						{
							$month = 'stycznia';
						}break;
						
						case 2:
						{
							$month = 'lutego';
						}break;
						
						case 3:
						{
							$month = 'marca';
						}break;
						
						case 4:
						{
							$month = 'kwietnia';
						}break;
						
						case 5:
						{
							$month = 'maja';
						}break;
						
						case 6:
						{
							$month = 'czerwca';
						}break;
						
						case 7:
						{
							$month = 'lipca';
						}break;
						
						case 8:
						{
							$month = 'sierpnia';
						}break;
						
						case 9:
						{
							$month = 'września';
						}break;
						
						case 10:
						{
							$month = 'października';
						}break;
						
						case 11:
						{
							$month = 'listopada';
						}break;
						
						case 12:
						{
							$month = 'grudnia';
						}break;
					}
					$date_msg = $hour.':'.$min.' '.$day.' '.$month.' '.$year;
				}
				
				if($author_last_msg == $id_user)
				{
					$content_msg = 'Ty: '.$content_msg;
				}
				
				if($date_msg != '')
				{
					$date_msg_div = '<div class="conv_data">Data ostatniej wiadomości - '.$date_msg.'</div>';
				}
				else $date_msg_div = '';
				
				if($pp_user != 'Nie podano')
				{
					$img_user = "'img/".$pp_user."'"; 
				}
				else
				{
					$img_user = "img/user.svg"; 
				}
				
				echo 
				
				'<script> $(document).ready(function(){ $(".img'.$id_inlocts[$i].'").css("background-image","url('.$img_user.')"); }); </script>
						
				<form id="'.$id_inlocts[$i].'" action="konwersacja" method="post">
				
					<input type="hidden" name="nick_do_konwers" value="'.$user.'"/>
					
				</form>
					
				<button type="submit" class="p-2 main_conv col-10 col-sm-8 col-md-6 col-xl-4 offset-1 offset-sm-2 offset-md-3 offset-xl-4 my-2" form="'.$id_inlocts[$i].'" value="Submit">

					<div class="float-left">
					
						<div class="look_profile"><div class="poster_users img mx-auto img'.$id_inlocts[$i].'"></div></div>
						
						<div style="clear:both;"></div>
						
					</div>
					
					<div class="float-left ml-2 conv2">
					
						<div class="konwersacje_div"><p class="konwersacje">'.$user.'</p></div>
						
						<div class="konwersacje_div mt-1 text-left"><textarea class="konwersacje" readonly>'.$content_msg.'</textarea></div>
						
					</div>
				
					<div style="clear:both;"></div>
					
					'.$date_msg_div.'
						
				</button>';
			}
		}		
	}	
}
else
{
	echo '<div class="col-8 p-2 m-4 formularz_log pt-3 text-center mx-auto"> Z nikim jeszcze nie rozmawiałeś! <div>(ಥ﹏ಥ) </div></div>';
}
$execute_query->free_result();
$connect->close();	
?>					
				</div>

			</article>
			
		</main>
		
		<footer>
		
			<div class="row">
		
				<div class="col-10 col-sm-8 col-md-6 col-lg-5 footer">&#9400; PCH_99 2020 - 2022 <br /><a href="regulamin-serwisu" target="_blank"> Regulamin portalu</a> - <a href="polityka-prywatnosci" target="_blank">Polityka prywatności</a></div>
				
			</div>
		
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		
		<script src="bootstrap/bootstrap.min.js"></script>
		
		<script src="js/sticky.js"></script>

	</div>

</body>
</html>
