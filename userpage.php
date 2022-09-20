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
	require_once 'walidacja.php';
			
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
				$id_user = $result['id_user'];
				$username = $result['username'];
				$name = $result['name'];
				$surname = $result['surname'];
				$job = $result['job'];
				$country = $result['country'];
				$gender = $result['gender'];
				$age = $result['age'];
				$live_place = $result['live_place'];
				$marital_status = $result['marital_status'];
				$watching = $result['watching'];
				$followers = $result['followers'];
				$date = date_create($result['date_join']);
				
				$day = date_format($date,"j");
				$month = date_format($date,"m");
				$year = date_format($date,"Y");
				
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
				$date_join = $day.' '.$month.' '.$year.'r.';

				$popularity = $result['popularity'];
				$reported = $result['reported'];
				$pp = $result['profile_picture'];
				$pb = $result['profile_background'];
				
				$results = stats_user($id_user,$connect);
				
				$execute_query->free_result();
				
				$query_user = "SELECT * FROM users,posts WHERE users.id_user = posts.author_post AND author_post  = '$id_user' ORDER BY posts.date_added DESC LIMIT 40";

				if(!$execute_query = $connect->query($query_user))
				{
					throw new Exception($connect->error);
				}
				else
				{
					$ile_post = $execute_query->num_rows;
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
	<script src="js/wallpaper.js"></script> <script src="/projekty/widget-comeback.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	<link rel="stylesheet" href="icofont/icofont.min.css">
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>Tomee - Twój blog</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
	
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

if($pb != 'Nie podano')
{
	$img1 = "'img/".$pb."'"; 
	echo '<script> $(document).ready(function(){ $(".tlo_profilowe").css("background-image","url('.$img1.')"); }); </script>'; 
}
?>			
			<div id="sett" class="hidden_set"> 
			
				<ul class="px-0 text-center">
				
					<li><a href="twoje-konto">
					
						<div class="poster img mx-auto"></div>
						
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
					
					<div class="col-11 col-md-9 formularz_log tlo_profilowe mx-auto mt-3 px-3 text-center">
						
						<div class="poster img mx-auto main-img"></div>	
						
						<div class="username"><?= $username; ?></div>
					
					</div>
					
					<div id="bio" class="col-10 col-md-8 info_user mx-auto mt-3 text-center p-2 p-md-3">
						
						<div class="d-inline-block mr-2">
						
							<form id="obserwacja" action="obserwowani" method="post">
									
							<input type="hidden" name="watching" value="<?= $username; ?>"/>
							
							<button class="py-1 px-2 watches" type="submit" form="obserwacja" value="Submit">Obserwuje: <?= $watching; ?></button>
						
							</form>
							
						</div>
						
						<div class="d-inline-block">
						
							<form id="obserwacja1" action="obserwujacy" method="post">
									
							<input type="hidden" name="followers" value="<?= $username; ?>"/>
							
							<button class="py-1 px-2 watches" type="submit" form="obserwacja1" value="Submit">Obserwujących: <?= $followers; ?></button>
						
							</form>
							
						</div>	
					
						<div class="bio">
						
							<div class="row">
							
								<div class="col-6 col-xl-3 mt-1 mx-0">
								
									<div> Imie:<br /> <?= $name; ?></div>
									<div> Nazwisko:<br /> <?= $surname; ?></div>
									<div> Płeć:<br /> <?= $gender; ?></div>
									<div> Wiek:<br /> <?= $age; ?></div>
								
								</div>
								
								<div class="col-6 col-xl-3 mt-1 mx-0">
								
									<div> Zawód:<br /> <?= $job; ?></div>
									<div> Kraj pochodzenia:<br /> <?= $country; ?></div>
									<div> Miejsce zamieszkania:<br /> <?= $live_place; ?></div>
									<div> Stan cywilny:<br /> <?= $marital_status; ?></div>
								
								</div>
								
								<div class="col-6 col-xl-3 mt-1 mx-0">
								
									<div> Obserwuje:<br /> <?= $watching; ?></div>
									<div> Obserwujących:<br /> <div id="followers1"><?= $followers; ?></div></div>
									<div> Data dołączenia:<br /> <?= $date_join; ?></div>
									<div> Ilość postów:<br /> <?= $results[0]; ?></div>
								
								</div>
								
								<div class="col-6 col-xl-3 mt-1 mx-0">
								
									<div> Ilość komentarzy:<br /> <?= $results[1]; ?></div>
									<div> Ilość polubień:<br /> <?= $results[2]; ?></div>
									<div> Popularność:<br /> <?= $popularity; ?></div>
									<div> Czy zgłaszany:<br /> <?= $reported; ?></div>
								
								</div>
							
							</div>
						
						</div>
						
					</div>
					
					<div class="col-8 col-sm-6 col-md-5 mx-auto my-3 text-center">
						
						<div class="watches d-block" id="wrap_bio">Rozwiń swoje informacje <i class="icofont-simple-down"></i></div>
					
					</div>
					
				</div>
				
				<div class="row">
					
					<div class="col-6 col-sm-5 col-md-4 col-lg-3 watches mx-auto add_post"> 
							
						<a href="dodaj-nowy-post">Utwórz nowy post</a>

					</div>
					
				</div>
				
				<div class="row">
<?php

if($ile_post == 0)
{
	echo '<div class="col-10 col-md-8 brak_postow mx-auto mt-3 text-center p-2 p-md-3">
	<div class="watches d-block m-2">Napisz coś, podziel się swoją opinią, poglądem bo trochę tu pusto (͠≖ ͜ʖ͠≖)👌</div></div>';
}
else
{
	$id_post;
	
	for($i=1;$i<=$ile_post;$i++)
	{
		$row = mysqli_fetch_assoc($execute_query);
		$author_post = $row['username'];
		$content_post = $row['content_post'];
		$id_post = $row['id_post'];

		$date = date_create($row['date_added']);
					
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
		$date_post = $day.' '.$month.' '.$year.' '.$hour.':'.$min;
		
		try
		{
			$your_id = $_SESSION['logged'];
			$query_like = "SELECT * FROM likes WHERE like_id_post = '$id_post'";
			$query_like_me = "SELECT * FROM likes WHERE like_id_post = '$id_post' AND like_id_author = '$your_id'";
			$query_comm = "SELECT * FROM comments,users WHERE users.id_user = comments.id_author_comm AND id_post_comm = '$id_post' ORDER BY comments.date_comm DESC LIMIT 40";
							
			// klucze zdefiniuj
			
			$execute_query1 = $connect->query($query_like);
			$execute_query_me = $connect->query($query_like_me);
			$execute_comm = $connect->query($query_comm);
			
			if(!$execute_query1 || !$execute_query_me || !$execute_comm)
			{
				throw new Exception($connect->error);
			}
			else
			{
				if($execute_query_me->num_rows == 1)
				{
					$like = 'liked';
					$tresc_like = 'Lubisz to';
				}
				else
				{
					$like = 'noliked';
					$tresc_like = 'Polub to';
				}
				
				$ile_like = $execute_query1->num_rows;
				$ile_kom = $execute_comm->num_rows;
				
				echo					
				'<div class="col-10 col-sm-9 col-md-8 mx-auto mt-4 text-center post" id="post'.$id_post.'">
				
				<div class="row main_post">
				
					<div class="col-9 col-sm-7 col-md-6 text-left"><div class="poster img" ></div><div class="d-inline-block autor_posta">  
					
					<form id="alienpage'.$i.'" action="twoje-konto" method="post">
											
						<button type="submit" form="alienpage'.$i.'" value="Submit">

							<div>'.$author_post.'</div>
							
						</button>
							
					</form>

					- opublikował/a post</div></div>
					
					<div class="col-10 mx-auto p-2 px-3 m-2 tresc_posta">'.$content_post.'</div>
					
					<div class="col-12 text-right mb-1"> dodano: '.$date_post.'</div>
				
				</div>
				
				<div class="row interactive_post">
				
					<div class="watches mx-2 my-3 polubxd '.$like.'" id="'.$id_post.'"><i class="icofont-heart"></i> <div class="d-inline-block" id="like'.$id_post.'" value="'.$ile_like.'">'.$tresc_like.' '.$ile_like.' </div></div>
					
					<div class="mx-2 watches my-3 classkom" id="'.$id_post.'">Komentarze
					
						<span class="ile_kom'.$id_post.'" id="'.$ile_kom.'">'.$ile_kom.'</span>
					
					</div>
				
					
				</div>
				
				<div class="nocomments" id="kom'.$id_post.'">
				
					<div id="add_comm_'.$id_post.'" class="row mx-auto" style="width: 90%;"><div class="col-10 col-sm-8 col-md-6 col-lg-4 mx-auto mb-3 pr-0 add_comm">
					
								<div class="float-left col-10 px-0">
										<input class="my-0 add_comm" id="komentarz'.$id_post.'" type="text" placeholder="Dodaj komentarz..."/>
								</div>
								
								<div class="float-right col-2">
									<button class="add_comm font-plus sub" id="'.$id_post.'">
										<i class="icofont-plus"></i>
									</button>
								</div>
							
					</div></div>
					
					<div class="pusty_komm'.$id_post.' dodawanie_komm"></div>';			
				
				if($ile_kom == 0)
				{
					echo '<div id="brak_kom'.$id_post.'" class="col-10 col-md-8 brak_postow mx-auto mt-3 text-center p-2 p-md-3">
					<div class="watches d-block m-2">Napisz coś, podziel się swoją opinią, poglądem bo trochę tu pusto (͠≖ ͜ʖ͠≖)👌</div></div>';
				}
				else
				{
					for($j=1;$j<=$ile_kom;$j++)
					{
						$row_comm = mysqli_fetch_assoc($execute_comm);
						$who_comm = $row_comm['username'];
						$content_comm = $row_comm['content_comm'];
						
						$date = date_create($row_comm['date_comm']);
					
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
						$date_comm = $day.' '.$month.' '.$year.' '.$hour.':'.$min;
						
						if($username == $who_comm) $dokad = 'twoje-konto';
						else $dokad = 'profil-uzytkownika';
						
						echo 
				
						'<div class="comment mb-1 p-2 mx-auto"> 
							
								<form class="d-inline-block" id="'.$who_comm.$j.$id_post.'" action="'.$dokad.'" method="post">
											
									<input type="hidden" name="nick_do_alienpage" value="'.$who_comm.'"/>
									
									<button type="submit" form="'.$who_comm.$j.$id_post.'" value="Submit">

										<div>'.$who_comm.'</div>
										
									</button>
										
								</form>

								- skomentował/a '.$date_comm.'
								
								<div class="col-11 my-1 mx-auto p-2 tresc_komm">
										
										'.$content_comm.'

								</div>
						
						</div>';
					}
				}
				echo'</div></div>';
			}
		}
		catch(Exception $error)
		{
			$_SESSION['error'] = $error;
		}
	}
	$execute_query->free_result();
	$connect->close();
}

?>
				</div>
				
				<div class="close_comm p-1 px-3"> <i class="icofont-close"></i> Zamknij - komentarze</div>
			
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
		
		<script src="js/wrapper_bio.js"></script>
		
		<script src="js/like.js"></script>
		
		<script src="js/comment.js"></script>

	</div>

</body>
</html>
