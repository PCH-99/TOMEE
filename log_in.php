<?php

session_start(); 

if(isset($_SESSION['count']) || isset($_SESSION['old_news']))
{
	unset($_SESSION['count']);
	unset($_SESSION['old_news']);
}

if(isset($_SESSION['logged'])) 
{
	header('Location:twoje-konto');
	exit();
}

require_once 'walidacja.php';

function come_back()
{
	if(isset($connect))  $connect->close();
	header('Location:zaloguj-sie-do-tomee');
	exit();
}
		
if(isset($_POST['username']))
{
	//username------------------------------------------------------------------------------------------------------------
	$username = $_POST['username'];
	$_SESSION['username_log'] = $username;
	
	if($username == '')
	{
		$_SESSION['err_username_log'] = "No trochę za krótka ta nazwa xd";
		come_back();
	}
	else if(check_input($username) == false)
	{
		$_SESSION['err_username_log'] = "Nazwa użytkownika może składać się z tylko cyfr, podkreślników (podłoga) i liter (bez polskich znaków).";	
		come_back();
	}
	else
	{
		if(isset($_POST['password']))
		{
			$password = $_POST['password'];
			$_SESSION['password_log'] = $password;
			
			if($password == '')
			{
				$_SESSION['err_password_log'] = "Nie podałeś żadnego hasła";
				come_back();
			}
			else if(verify_pass($password) == false)
			{
				$_SESSION['err_password_log'] = "Hasło powinno tylko się składać z co najmniej jednej dużej litery, małej litery i cyfry.";
				come_back();
			}
			else //spr w db
			{
				require_once 'db_connect.php';

				mysqli_report(MYSQLI_REPORT_STRICT);
				try
				{
					$connect = new mysqli($host,$db_user,$db_password,$db_name);
					
					if($connect->connect_errno != 0)
					{
						throw new Exception($connect->connect_errno);
					}
					else
					{
						$username = htmlspecialchars(stripslashes(trim($username, ENT_QUOTES)));
						$username = mysqli_real_escape_string($connect,$username);
						
						$query_user = "SELECT id_user,username,password FROM users WHERE username  = '$username'";
								
						if(!$execute_query = $connect->query($query_user))
						{
							throw new Exception($connect->error);
						}
						else 
						{
							$result = $execute_query->num_rows;
							if($result == 0)
							{
								$_SESSION['err_username_log'] = "Nie ma takiego użytkownika!";
								come_back();
							}
							else if($result < 1)
							{
								$_SESSION['err_username_log'] = "Hmm coś tu nie gra!";
								come_back();
							}
							else
							{
								$result = $execute_query->fetch_assoc();
								
								if(password_verify($password,$result['password']) == false)
								{
									$_SESSION['err_password_log'] = "Błędne hasło, spróbuj ponownie.";
									come_back();
								}
								else
								{
									$_SESSION['logged'] = $result['id_user'];
									$execute_query->free_result();
									$connect->close();
									unset($_SESSION['username_log']);
									unset($_SESSION['password_log']);
									if(isset($_SESSION['username'])) unset($_SESSION['username']);
									if(isset($_SESSION['email'])) unset($_SESSION['email']);
									if(isset($_SESSION['password'])) unset($_SESSION['password']);
									if(isset($_SESSION['password_repeat'])) unset($_SESSION['password_repeat']);
									header('Location:strona-glowna');
								}
							}
						}
					}
				}
				catch(Exception $error)
				{
					$_SESSION['error'] = $error;
					come_back();
				}					
			}
		}
		else header('Location:zaloguj-sie-do-tomee');
	}
}
else header('Location:zaloguj-sie-do-tomee');
?>