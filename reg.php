<?php
session_start();

if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
}

if(isset($_SESSION['logged']) || isset($_SESSION['first_logged'])) 
	{
		header('Location:twoje-konto');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="jquery/jquery.min.js"></script>
	<script src="js/wallpaper.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	<link rel="Stylesheet" href="style/switch.css"/>
	<link rel="stylesheet" href="icofont/icofont.min.css">
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>Załóż konto na Tomee</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
	
	<div class="container">
		
		<header><div class="row">
			
			<div class="col-12 mx-auto mb-3 p-1">
				
				<div class="float-right px-2 navb"><a href="pomoc" target="_blank">Support</a></div>
				
				<div class="float-right px-1 navb"><a href="o-projekcie-tomee" target="_blank">O projekcie Tomee</a></div>
				
			</div>
			
			<div class="col-10 col-sm-7 col-md-5 mt-1 mx-auto text-center">
				<a href="zaloguj-sie-do-tomee"><img class="img-fluid" src="img/TOMEE_LOGO.png"/></a>
				<p class="mt-2 header"><cite><q>Podziel się myślą z całym światem.</q></cite>
			</div>
			
		</div>
		
		<div class="row">
			
			<div class="col-10 col-sm-7 col-md-6 mt-1 mx-auto text-center">
			
				<div class="watches"> Zaloguj się / Zarejestruj się </div>
				
				<div class="switch">
					
					<div class="toggle">
					
						<input type="checkbox" id="switch">
						<label for="switch"></label>
						
					</div>
					
				</div>
					
				<input id="flag" type="hidden" value="1"/>
				
			</div>
			
		</div>
		
		</header>
		
		<main>
			
			<article><div class="row">
				
				<div class="col-9 col-lg-7 formularz_log mx-auto text-center log log1">
					
						<div class="mb-3 h1">Panel logowania</div>
						
						<form action="log_in.php" method="POST">
							
							<?php
							if(isset($_SESSION['error'])) 
							{
								echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['error']."</div>";
								unset($_SESSION['error']);
							}
							?>
						
							<label>
							Nazwa użytkownika:
							<input class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mb-3" type="text" placeholder="Tutaj wpisz nazwę..." name="username" maxlength="16" <?php if(isset($_SESSION['username_log'])) echo 'value="'.$_SESSION['username_log'].'"'; ?>/>
							</label>
							<?php
								if(isset($_SESSION['err_username_log'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_username_log']."</div>";
									unset($_SESSION['err_username_log']);
								}
							?>							
							
							<label>
							Hasło:
							<div class="mx-auto div_pass col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 px-0 mb-3">
							
								<div class="float-left ml-2">
										<input id="show_password" class="input_pass my-0" type="password" placeholder="Tutaj wstaw hasło..." name="password" maxlength="20" <?php if(isset($_SESSION['password_log'])) echo 'value="'.$_SESSION['password_log'].'"'; ?>/>
								</div>
								
								<div class="float-right show_password mr-1 mb-1">
									<span class="input_pass px-2 py-1" id="show_password_icon">
										<i class="icofont-eye-alt"></i>
									</span>
								</div>
								
								<div style="clear:both;"></div>
								
							</div>
							</label>
							<?php
								if(isset($_SESSION['err_password_log'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_password_log']."</div>";
									unset($_SESSION['err_password_log']);
								}
							?>
							
							<input class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mb-4 px-1" type="submit" value="Zaloguj się"/>
							
						</form>
						
						<div class="col-11 p-2 mx-auto">
						
						<section><p>Nie pamiętam hasła - <a href="pomoc">Pomoc znajdziesz tutaj :)</a></p></section>
						
						</div>
						
						<div class="formularz_log mx-auto text-center reg reg1">
					
							<div class="mb-3 h1">Załóż konto na Tomee</div>
							
							<form action="zarejestruj.php" method="POST" class="p-0 pt-2 mb-4">

							<?php
								if(isset($_SESSION['error'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['error']."</div>";
									unset($_SESSION['error']);
								}
							?>
							
							<label>
							Nazwa użytkownika:
							<input class="col-11 col-sm-8 col-md-6 col-lg-5 mb-3" type="text" placeholder="Tutaj wpisz nazwę..." name="username" maxlength="16" <?php if(isset($_SESSION['username'])) echo 'value="'.$_SESSION['username'].'"'; ?>/>
							</label>
							<?php
								if(isset($_SESSION['err_username'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_username']."</div>";
									unset($_SESSION['err_username']);
								}
							?>							
							<label>
							Adres e-mail:
							<input class="col-11 col-sm-8 col-md-6 col-lg-5 mb-3" type="text" placeholder="Tutaj podaj e-mail..." name="email" maxlength="20"
							<?php if(isset($_SESSION['email'])) echo 'value="'.$_SESSION['email'].'"'; ?>/>
							</label>
							<?php
								if(isset($_SESSION['err_email'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_email']."</div>";
									unset($_SESSION['err_email']);
								}
							?>	
							
							<label>
							Hasło:
								<div class="mx-auto div_pass col-11 col-sm-8 col-md-6 col-lg-5 px-0">
								
									<div class="float-left ml-2">
											<input id="show_password1" class="input_pass my-0" type="password" placeholder="Tutaj wstaw hasło..." name="password" maxlength="20" <?php if(isset($_SESSION['password'])) echo 'value="'.$_SESSION['password'].'"'; ?>/>
									</div>
									
									<div class="float-right show_password1 mr-1 mb-1">
										<span class="input_pass px-2 py-1" id="show_password_icon1">
											<i class="icofont-eye-alt"></i>
										</span>
									</div>	
									
									<div style="clear:both;"></div>
									
								</div>
							</label>
							<?php
								if(isset($_SESSION['err_password'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_password']."</div>";
									unset($_SESSION['err_password']);
								}
							?>	
							
							
							<label class="mt-3">
							Powtórz hasło:
								<div class="mx-auto div_pass col-11 col-sm-8 col-md-6 col-lg-5 px-0">
								
									<div class="float-left ml-2">
											<input id="show_password_r" class="input_pass my-0" type="password" placeholder="Tutaj powtórz hasło..." name="password_repeat" maxlength="20" <?php if(isset($_SESSION['password_repeat'])) echo 'value="'.$_SESSION['password_repeat'].'"'; ?>/>
									</div>
									
									<div class="float-right show_password_r mr-1 mb-1">
										<span class="input_pass px-2 py-1" id="show_password_r_icon">
											<i class="icofont-eye-alt"></i>
										</span>
									</div>
									
									<div style="clear:both;"></div>
									
								</div>
							</label>
							<?php
								if(isset($_SESSION['err_password_repeat'])) 
								{
									echo "<div class='navb mb-3 px-4 text-danger'>".$_SESSION['err_password_repeat']."</div>";
									unset($_SESSION['err_password_repeat']);
								}
							?>
							
							<p class="col-11 mt-3 mx-auto px-1 text-center">! Akceptujesz regulamin zakładając nowe konto na Tomee.</p>
							
							<input class="col-10 col-sm-7 col-md-6 col-lg-5 mb-3 mt-2" type="submit" value="Załóż konto"/>
							
						</form>
						
						</div>
						
				</div>
				
			</div></article>
			
		</main>
		
		<footer>
		
			<div class="row">
		
				<div class="col-10 col-sm-8 col-md-6 col-lg-5 footer footer1">&#9400; PCH_99 2020 - 2021 <br /><a href="regulamin-serwisu" target="_blank"> Regulamin portalu</a> - <a href="polityka-prywatnosci" target="_blank">Polityka prywatności</a></div>
				
			</div>
		
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		
		<script src="bootstrap/bootstrap.min.js"></script>
		
		<script src="js/show_password.js"></script>
		
		<script src="js/switch_log_reg.js"></script>

		</div>
		
</body>
</html>
