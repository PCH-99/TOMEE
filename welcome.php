<?php
session_start(); 

if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
}

if(!(isset($_SESSION['first_logged'])))
	{
		header('Location:zaloguj-sie-do-tomee');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="jquery/jquery.min.js"></script>
	<script src="js/wallpaper.js"></script> <script src="/projekty/widget-comeback.js"></script>
	
	<link rel="stylesheet" href="bootstrap/Bootstrap.css">
	<link rel="Stylesheet" href="style/style.css"/>
	
	<link rel="icon" href="img/TOMEE_ICON.png" type="image/x-icon">
	
	<title>Witam na Tomee :)</title>
	
</head>
<body><div id="wp1"><div id="wp2"></div></div>
	
	<div class="container">
		
		<header>
		
			<div class="row">
			
				<div class="col-10 col-sm-7 col-md-6 mt-1 mx-auto text-center">
					<a href="zaloguj-sie-do-tomee"><img class="img-fluid" src="img/TOMEE_LOGO.png"/></a>
					<p class="mt-2 header"><cite><q>Podziel się myślą z całym światem.</q></cite>
				</div>
			
			</div>
		
		</header>
		
		<main>
			
			<article>
			
				<div class="row">
					
					<div class="col-8 col-md-7 formularz_log mx-auto mt-3 py-2 text-center">
						
						<?php
							if(isset($_SESSION['username'])) 
							{
								echo "<div class='h3 mb-3 px-1'>Witaj ".$_SESSION['username']."  ಠ‿↼</div>
								<div class='h4 mb-4 px-1'> Dziękuję, że do nas dołączyłeś/aś.</div>";
								unset($_SESSION['username']);
								unset($_SESSION['first_logged']);
							}
						?>
						
						<form id="welcome" class="text-center" action="twoje-konto" method="post">
							
							<button type="submit" class="p-2 px-3 mx-auto" form="welcome" value="Submit">Przejdź do TOMEE</button>
						
						</form>
				
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

	</div>

</body>
</html>
