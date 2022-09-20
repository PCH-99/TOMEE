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
				$pp = $result['profile_picture'];
			}
		}
		$connect->close();
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
	
	<title>Ustawienia</title>
	
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
					<div class="col-10 col-md-9 col-lg-7 formularz_log mx-auto mt-3 p-3 text-center">
					
						<div class="mx-auto text-center">Zmień dane do logowania</div>
						
						<form action="ustawienie" method="post">
						
							<label>
							Nazwa użytkownika: 
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" name="username" placeholder="<?= $username; ?>"/>
							</label>
							
							<label>
								Powtórz stare hasło:
								<div class="mx-auto div_pass col-11 col-sm-8 col-md-6 col-xl-5 px-0 mb-3">
								
									<div class="float-left ml-2">
											<input id="show_password" class="input_pass my-0" type="password" placeholder="Tutaj je wprowadź" name="old_password" maxlength="20"/>
									</div>
									
									<div class="float-right show_password mr-1 mb-1">
										<span class="input_pass px-2 py-1" id="show_password_icon">
											<i class="icofont-eye-alt"></i>
										</span>
									</div>	
									
									<div style="clear:both;"></div>
									
								</div>
							</label>
							
							<label>
								Nowe hasło:
								<div class="mx-auto div_pass col-11 col-sm-8 col-md-6 col-xl-5 px-0 mb-3">
								
									<div class="float-left ml-2">
											<input id="show_password_r" class="input_pass my-0" type="password" placeholder="Wpisz w tym miejscu" name="password" maxlength="20"/>
									</div>
									
									<div class="float-right show_password_r mr-1 mb-1">
										<span class="input_pass px-2 py-1" id="show_password_r_icon">
											<i class="icofont-eye-alt"></i>
										</span>
									</div>	
									
									<div style="clear:both;"></div>
									
								</div>
							</label>
							
							<input class="col-10 col-sm-7 col-md-6 col-xl-5 mb-4" type="submit" value="Zapisz zmiany"/>

						</form>
					
					</div>
					
					<div class="col-10 col-md-9 col-lg-7 formularz_log mx-auto mt-3 p-3 text-center">
					
						<div class="mx-auto text-center">Zmień Ustawienie</div>
						
						<form action="zdjecie-profilowe" method="post" enctype="multipart/form-data">
						
							<label>
							Zdjęcie profilowe:
							<input class="col-11 col-sm-8 col-md-6 col-lg-5 mb-4" type="file" name="pp"/>
							</label>
							
							<input type="hidden" name="change" value="true"/>
							
							<input class="col-10 col-sm-7 col-md-6 col-xl-5 mb-4" type="submit" value="Zapisz zmiany"/>

						</form>
					
					</div>
					
					<div class="col-10 col-md-9 col-lg-7 formularz_log mx-auto mt-3 p-3 text-center">
					
						<div class="mx-auto text-center">Zmień Ustawienie</div>
						
						<form action="tlo-profilowe" method="post" enctype="multipart/form-data">
						
							<label>
							Tło profilowe:
							<input class="col-11 col-sm-8 col-md-6 col-lg-5 mb-4" type="file" name="pb"/>
							</label>
							
							<input type="hidden" name="change" value="true"/>
							
							<input class="col-10 col-sm-7 col-md-6 col-xl-5 mb-4" type="submit" value="Zapisz zmiany"/>

						</form>
					
					</div>
					
					<div class="col-10 col-md-9 col-lg-7 formularz_log mx-auto mt-3 p-3 text-center">
					
						<div class="mx-auto text-center">Zmień opcjonalne <br /> informacje o sobie</div>
						
						<form action="twoje-bio" method="post">
						
							<label>
							Imie:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $name; ?>" name="name"/>
							</label>
							
							<label>
							Nazwisko:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $surname; ?>" name="surname"/>
							</label>
							
							<label>
							Płeć:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $gender; ?>" name="gender"/>
							</label>
							
							<label>
							Wiek:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="number" placeholder="<?= $age; ?>" name="age"/>
							</label>
							
							<label>
							Zawód:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $job; ?>" name="job"/>
							</label>
							
							<label>
							Kraj pochodzenia:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $country; ?> " name="country"/>
							</label>
							
							<label>
							Miejsce zamieszkania:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $live_place; ?>" name="l_p"/>
							</label>
							
							<label>
							Status cywilny:
							<input class="col-10 col-sm-8 col-md-6 col-xl-5 mb-4" type="text" placeholder="<?= $marital_status; ?>" name="m_s"/>
							</label>
							
							<input class="col-10 col-sm-7 col-md-6 col-xl-5 mb-4" type="submit" value="Zapisz zmiany"/>

						</form>
					
					</div>
					
					<div class="col-7 mx-auto mt-3 p-1 pomoc"><a href="support">Sekcja pomocy</a></div>
					
					<div class="col-7 mx-auto mt-3 p-1 usuwanie">Usuń konto</div>
					
					<div class="delete">
					
						<div>Czy na pewno chcesz usunąć swoje konto? </div>
						<div>Stracisz bezpowrotnie swoje dane i ustawienia.</div>
						
						<form id="delete_user" action="remove_user.php" method="post">
							<input type="hidden" value="delete_true" name="soulkiller"/>
						</form>
						
						<div class="my-3 p-2 mx-auto" id="potwierdz"><button type="submit" form="delete_user" class="delete_user_button">Potwierdź usunięcie konta</button></div>
						<div class="my-3 p-2 mx-auto" id="rezygnacja">Rezygnuje z usunięcia konta</div>
					
					</div>
					
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
		
		<script src="js/usun.js"></script>
		
		<script src="js/show_password.js"></script>

	</div>

</body>
</html>
