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
			$id_your = $_SESSION['logged'];
				
			$query_user = "SELECT * FROM users WHERE id_user = '$id_your'";
			
			if(!$execute_query = $connect->query($query_user))
			{
				throw new Exception($connect->error);
			}
			else
			{
				$result = $execute_query->fetch_assoc();
				$your_username = $result['username'];
				$pp_your = $result['profile_picture'];
				$execute_query->free_result();
				
				$query_user = "SELECT * FROM observations WHERE id_observer = '$id_your'";
			
				if(!$execute_query = $connect->query($query_user))
				{
					throw new Exception($connect->error);
				}
				else
				{
					$ile_obsv = $execute_query->num_rows;
					if($ile_obsv != 0)
					{
						$obsv = array();
						for($i=0;$i<$ile_obsv;$i++)
						{
							$result = $execute_query->fetch_assoc();
							$obsv[$i] = $result['id_watched'];
						}
						
						$query = "SELECT * FROM posts WHERE";
						
						for($i=0;$i<$ile_obsv + 1;$i++)
						{
							if($i == 0)
							{
								$query = $query." author_post = ".$obsv[$i];
							}
							else if($i == $ile_obsv)
							{
								$query = $query." ORDER BY date_added DESC LIMIT 100";
							}
							else
							{
								$query = $query." OR author_post = ".$obsv[$i];
							}					
						}
						
						if(!$execute_query = $connect->query($query))
						{
							throw new Exception($connect->error);
						}
						else
						{
							$ile_post = $execute_query->num_rows;
						}
					}
					else $ile_post = 0;
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
	<meta name="keywords" content="posty,komentarze,Tomee,dyskusje,wyszukaj,znajomi,polubienia,popularność,łączność,konwersacja,znajomości,linki,hejt"/>
	
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="jquery/jquery.min.js"></script>
	<script src="js/wallpaper.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	<link rel="stylesheet" href="icofont/icofont.min.css">
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>TOMEE - Strona główna</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
<?php 



if($pp_your != 'Nie podano')
{
	$img_your = "'img/".$pp_your."'"; 
	echo '<script> $(document).ready(function(){ $(".img'.$id_your.'").css("background-image","url('.$img_your.')"); }); </script>'; 
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
					
					<div class="float-right px-auto">
					
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
						
						<div id="nick" class="<?= $your_username; ?>"><?= $your_username; ?></div>
					
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
						
				<div class="col-11 mx-auto mt-4 p-2 pl-4 m-1 h5"> Najpopularniejsze konta: </div>
				
					
<?php	
				try
				{				
					$query_popular_user = "SELECT id_user,username,profile_picture FROM users ORDER BY followers DESC LIMIT 4";
					$execute_query_popular = $connect->query($query_popular_user);
					
					if(!$execute_query_popular)
					{
						throw new Exception($connect->error);
					}
					else
					{
						for($i=1;$i<=4;$i++)
						{
							$wiersz = $execute_query_popular->fetch_assoc();
							$id_star = $wiersz['id_user'];
							$star = $wiersz['username'];
							$pp_star = $wiersz['profile_picture'];
							
							if($pp_star != 'Nie podano')
							{
								$img_star = "'img/".$pp_star."'"; 
								echo '<script> $(document).ready(function(){ $(".img'.$id_star.'").css("background-image","url('.$img_star.')"); }); </script>'; 
							}
							
							echo '

									<form class="mx-auto p-0" id="alienpage'.$i.'" action="profil-uzytkownika" method="post">
											
										<input type="hidden" name="nick_do_alienpage" value="'.$star.'"/>
										
										<button class="form_propos" type="submit" form="alienpage'.$i.'" value="Submit">
										
											<div class="poster img mx-auto img'.$id_star.'"></div>
										
											<div>'.$star.'</div>
											
										</button>
											
									</form>
									
								';
						}
					}
				}
				catch(Exception $error)
				{
					$_SESSION['error'] = $error;
				}				
					
?>
					
					
				
						
<?php
if(isset($_SESSION['error'])) 
{
	echo "<div class='navb mb-3 px-4 text-danger'>Wystąpił błąd OMG. ".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}

if($ile_post == 0)
{
	echo '<div class="col-10 col-md-8 brak_postow mx-auto mt-3 text-center p-2 p-md-3">
	<div class="watches d-block m-2">Zaobserwuj innych użytkowników aby widzieć tu ich najnowsze posty (ʘᗩʘ)</div></div>';
}
else
{
	$id_post;
	
	for($i=1;$i<=$ile_post;$i++)
	{
		$row = mysqli_fetch_assoc($execute_query);
		$author_post = $row['author_post'];
		$id_user = $author_post;
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
			$query_post_user = "SELECT username,profile_picture FROM users WHERE id_user = '$author_post'";
			$query_like = "SELECT * FROM likes WHERE like_id_post = '$id_post'";
			$query_like_me = "SELECT * FROM likes WHERE like_id_post = '$id_post' AND like_id_author = '$your_id'";
			$query_comm = "SELECT * FROM comments,users WHERE users.id_user = comments.id_author_comm AND id_post_comm = '$id_post' ORDER BY comments.date_comm DESC LIMIT 40";
							
			// klucze zdefiniuj
			
			$execute_query0 = $connect->query($query_post_user);
			$execute_query1 = $connect->query($query_like);
			$execute_query_me = $connect->query($query_like_me);
			$execute_comm = $connect->query($query_comm);
			
			if(!$execute_query1 || !$execute_query_me || !$execute_comm || !$execute_query0)
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
				
				$wiersz = $execute_query0->fetch_assoc();
				$author = $wiersz['username'];
				$pp = $wiersz['profile_picture'];
				
				if($pp != 'Nie podano')
				{
					$img = "'img/".$pp."'"; 
					echo '<script> $(document).ready(function(){ $(".img'.$id_user.'").css("background-image","url('.$img.')"); }); </script>'; 
				}
				
				$ile_kom = $execute_comm->num_rows;
				
				echo					
				'<div class="col-10 col-sm-9 col-md-8 mx-auto mt-4 text-center post" id="post'.$id_post.'">
				
				<div class="row main_post">
				
					<div class="col-9 col-sm-7 col-md-6 text-left"><div class="poster img img'.$id_user.'" ></div><div class="d-inline-block autor_posta">  
					
					<form id="alienpage'.$author.$i.'" action="profil-uzytkownika" method="post">
											
						<input type="hidden" name="nick_do_alienpage" value="'.$author.'"/>
						
						<button type="submit" form="alienpage'.$author.$i.'" value="Submit">

							<div>'.$author.'</div>
							
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
					
					<div class="mx-2 watches my-3"><a class="zglos" href="support"> Zgłoś </a></div>
					
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
						
						if($your_username == $who_comm) $dokad = 'twoje-konto';
						else $dokad = 'profil-uzytkownika';
						
						echo 
				
						'<div class="comment mb-1 p-2 mx-auto"> 
							
								<form class="d-inline-block" id="'.$who_comm.$j.'" action="'.$dokad.'" method="post">
											
									<input type="hidden" name="nick_do_alienpage" value="'.$who_comm.'"/>
									
									<button type="submit" form="'.$who_comm.$j.'" value="Submit">

										<div>'.$who_comm.'</div>
										
									</button>
										
								</form>
								
								<div class="d-inline-block"> - skomentował/a '.$date_comm.'</div>
								
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
				<div class="close_comm p-1 px-3"> <i class="icofont-close"></i> Zamknij - komentarze</div>
			
			</article>
			
		</main>
		
		<footer>
		
			<div class="row">
		
				<div class="col-10 col-sm-8 col-md-6 col-lg-5 footer">&#9400; PCH_99 2020 - 2021 <br /><a href="regulamin-serwisu" target="_blank"> Regulamin portalu</a> - <a href="polityka-prywatnosci" target="_blank">Polityka prywatności</a></div>
				
			</div>
		
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		
		<script src="bootstrap/bootstrap.min.js"></script>
		
		<script src="js/sticky.js"></script>
		
		<script src="js/like.js"></script>
		
		<script src="js/comment.js"></script>

	</div>

</body>
</html>
