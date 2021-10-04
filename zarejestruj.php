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
		header('Location:zarejestruj-nowe-konto');
		exit();
	}
	
	function enter_db($connect,$username,$email,$password)
	{
		try
		{
			$query = "SELECT id_user FROM users WHERE username = '$username'";
			
			if(!$execute_query = $connect->query($query))
			{
				throw new Exception($connect->error);
				return false;
			}
			else
			{	
				$rows_username = $execute_query->num_rows;
				
				if($rows_username == 1)
				{
					$_SESSION['err_username'] = "Ta nazwa użytkownika już jest używana";
					 come_back();
				}
				else if($rows_username > 1)
				{
					$_SESSION['err_username'] = "Hmm coś tu nie gra";
					 come_back();
				}
				else
				{
					$query = "SELECT id_user FROM users WHERE email  = '$email'";
			
					if(!$execute_query = $connect->query($query))
					{
						throw new Exception($connect->error);
						return false;
					}
					else
					{
						$rows_email = $execute_query->num_rows;
				
						if($rows_email == 1)
						{
							$_SESSION['err_email'] = "Ten adres email już jest używany";
							 come_back();
						}
						else if($rows_email > 1)
						{
							$_SESSION['err_email'] = "Hmm coś tu nie gra";
							 come_back();
						}
						else
						{
							$password_hash = password_hash($password,PASSWORD_DEFAULT);
							$default = "Nie podano";
							
							$insert = "INSERT INTO users VALUES (NULL,'$username','$email','$password_hash','$default','$default','$default','$default','$default','$default','$default','$default',0,0,DATE_ADD(NOW(), INTERVAL 2 HOUR),'Niska','Nie','$default','$default')";
				
							if($execute_query = $connect->query($insert))
							{
								return true;
							}
							else
							{
								throw new Exception($connect->error);
								return false;
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
	
	if(isset($_POST['username']))
	{
		//username------------------------------------------------------------------------------------------------------------
		$username = $_POST['username'];
		$username = htmlspecialchars(stripslashes(trim($username, ENT_QUOTES)));
		$_SESSION['username'] = $username;
		
		if(strlen($username)<1)
		{
			$_SESSION['err_username'] = "No trochę za krótka ta nazwa xd";
			come_back();
		}
		else if(strlen($username)>10)
		{
			$_SESSION['err_username'] = "Oj za dużo znaków, max to 10";
			come_back();
		}
		else if(check_input($username) == false)
		{
			$_SESSION['err_username'] = "Nazwa użytkownika może składać się z tylko cyfr, podkreślników (podłoga), myślników i liter (bez polskich znaków).";
			come_back();
		}
		else 
		{
			//email----------------------------------------------------------------------------------------------
			if(isset($_POST['email']))
			{
				$email = $_POST['email'];
				$_SESSION['email'] = $email;
				
				$email_sant = filter_var($email,FILTER_SANITIZE_EMAIL);
				
				if($email_sant == '')
				{
					$_SESSION['err_email'] = "Nie podałeś żadnego adresu!";
					come_back();
				}
				else if((filter_var($email_sant,FILTER_VALIDATE_EMAIL) == false) || ($email != $email_sant))
				{
					$_SESSION['err_email'] = "Nie poprawny adres mailowy";
					come_back();
				}
				else
				{
					//hasła-----------------------------------------------------------------------------------------------
					if(isset($_POST['password']) && isset($_POST['password_repeat']))
					{
						$password = $_POST['password'];
						$password_repeat = $_POST['password_repeat'];
						
						$pass_length = strlen($password);
						
						$_SESSION['password'] = $password;
						$_SESSION['password_repeat'] = $password_repeat;
						
						if($password == '')
						{
							$_SESSION['err_password'] = "Nie podałeś żadnego hasła";
							come_back();
						}
						else if($pass_length <= 3)
						{
							$_SESSION['err_password'] = "Może te hasło jest łatwe do zapamiętania, ale nie jest bezpieczne!";
							come_back();
						}
						else if($pass_length >= 20)
						{
							$_SESSION['err_password'] = "Raczej nie zapamiętasz tak długiego hasła :)";
							come_back();
						}
						else if(verify_pass($password) == false)
						{
							$_SESSION['err_password'] = "Hasło powinno tylko się składać z co najmniej jednej dużej litery, małej litery i cyfry";
							come_back();
						}
						else if($password != $password_repeat)
						{
							$_SESSION['err_password_repeat'] = "Niepoprawnie powtórzone hasło!";
							come_back();
						}
						else //wprowadzenie danych do bazy
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
									$username = mysqli_real_escape_string($connect,$username);
									$password = mysqli_real_escape_string($connect,$password);
									
									if(enter_db($connect,$username,$email,$password) == true)
									{										
										$query_user = "SELECT id_user FROM users WHERE username  = '$username'";
								
										if(!$execute_query1 = $connect->query($query_user))
										{
											throw new Exception($connect->error);
										}
										else 
										{
											$result = $execute_query1->fetch_assoc();
											$execute_query1->free_result();
											$connect->close();
											unset($_SESSION['email']);
											unset($_SESSION['password']);
											unset($_SESSION['password_repeat']);
											$_SESSION['first_logged'] = true;
											$_SESSION['logged'] = $result['id_user'];
											header('Location:witam-na-tomee');
										}
									}
									else if(enter_db($connect,$username,$email,$password) == false)
									{
										$execute_query1->free_result();
										$connect->close();
										come_back();
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
		}
	}
	else header('Location:zaloguj-sie-do-tomee');
	
?>