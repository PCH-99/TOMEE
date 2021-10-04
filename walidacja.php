<?php
	
	function check_input($username)
	{
		$strlen = strlen($username);
		$allowed_char = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$allowed_number = array(1,2,3,4,5,6,7,8,9,'0','_','-');
		$next_check = 0;
		$count = 0;
		
		for($i=1; $i<=$strlen; $i++)
		{
			for($j=0; $j<=25; $j++)
			{
				if($username[$next_check] == $allowed_char[$j]) $count++;
				if($username[$next_check] == strtoupper($allowed_char[$j])) $count++;	
			}
			
			for($k=0; $k<=11; $k++)
			{
				if($username[$next_check] == $allowed_number[$k]) $count++;					
			}
			$next_check++;
		}
		if($count < $strlen) return false;
		else if($count == $strlen) return true;	
	}
	
	function verify_pass($pass)
	{
		$strlen = strlen($pass);
		$allowed_letter = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		
		$allowed_number = array(1,2,3,4,5,6,7,8,9,'0');
		
		$next_check = 0;
		$count = 0;
		$let = false;
		$ulet = false;
		$numb = false;
		
		for($i=1; $i<=$strlen; $i++)
		{
			for($j=0; $j<=25; $j++)
			{
				if($pass[$next_check] == $allowed_letter[$j])
				{
					$let = true;
					$count++;
				}
				if($pass[$next_check] == strtoupper($allowed_letter[$j]))
				{
					$ulet = true;
					$count++;
				}
			}
			
			for($k=0; $k<=9; $k++)
			{
				if($pass[$next_check] == $allowed_number[$k])
				{
					$numb = true;
					$count++;
				}
			}
			$next_check++;
		}
		
		if($let == true && $ulet == true && $numb == true && $count == $strlen) return true;
		else return false;
	}
	
	function verify_id($id)
	{
		$int_len = strlen($id) - 1;
		$allowed_number = array(1,2,3,4,5,6,7,8,9,0);
		$next_check = 0;
		$x = 0;
		
		for($i=0; $i<=$int_len; $i++)
		{
			for($k=0; $k<=9; $k++)
			{
				if($id[$next_check] == $allowed_number[$k])
				{
					$x++;
				}
			}
			$next_check++;
		}
		
		if($x < $int_len+1) return false;
		else return true;
	}
	
	function update_followers($id_observer,$id_watched,$connect)
	{
		$what = 'id_observer';
		$who = $id_observer;
		$which = 'watching';
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		for($i=0;$i<2;$i++)
		{
			try
			{
				$query = "SELECT COUNT(*) AS ilosc FROM observations WHERE $what = $who";
				$execute_query = $connect->query($query);
		
				if(!$execute_query)
				{
					throw new Exception($connect->error);
				}
				else
				{
					$row = mysqli_fetch_assoc($execute_query);
					$result = $row['ilosc'];
					
					$query_update = "UPDATE users SET $which = $result WHERE id_user = $who ";
					$execute_query = $connect->query($query_update);
		
					if(!$execute_query)
					{
						throw new Exception($connect->error);
					}
				}
			}
			catch(Exception $error)
			{
				$_SESSION['error'] = $error;
			}
			$what = 'id_watched';
			$who = $id_watched;
			$which = 'followers';
		}
	}
	
	function stats_user($id_user,$connect)
	{
		$where = array('posts','comments','likes');
		$column = array('author_post','id_author_comm','like_id_author');
		$results = array(0,0,0);
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		for($i=0; $i<3; $i++)
		{
			try
			{
				$table = $where[$i];
				$column_ = $column[$i];
				
				$query = "SELECT COUNT(*) AS ilosc FROM $table WHERE $column_ = '$id_user'";
				$execute_query = $connect->query($query);
		
				if(!$execute_query)
				{
					throw new Exception($connect->error);
				}
				else
				{
					$row = mysqli_fetch_assoc($execute_query);
					$results[$i] = $row['ilosc'];
				}
			}
			catch(Exception $error)
			{
				$_SESSION['error'] = $error;
			}
		}
		return $results;
	}

	function upload($file,$connect)
	{
		if($_FILES[$file]['error'] == 0)
		{
			$temp = explode(".",$_FILES[$file]["name"]);
			$name_file = $_FILES[$file]["name"];
			
			if(check_input($temp[0]) == true)
			{
				$size_file = ($_FILES[$file]["size"]);				
				$read = pathinfo($name_file);
				$ext = $read['extension'];
				
				if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'jpeg')
				{		
					if ($size_file < 3145728) 
					{	
						$new_name = $file.$_SESSION['logged'].'.'.end($temp);
						$path_upload = "./img/" .$new_name;
						move_uploaded_file($_FILES[$file]['tmp_name'], $path_upload);
						
						$id_user = $_SESSION['logged'];
						
						$column = '';
						if($file == 'pp') $column = 'profile_picture';
						else if($file == 'pb') $column = 'profile_background';
						
						$query_user = "UPDATE users SET $column = '$new_name' WHERE id_user = $id_user";

						if(!$execute_query = $connect->query($query_user))
						{
							throw new Exception($connect->error);
						}
					}
					else $_SESSION['no_settings'] = 'plik '.$name_file.' przekroczył maksymalny rozmiar (3MB) - wybierz zdjęcie w mniejszej rozdzielczości.';
				}
				else $_SESSION['no_settings'] = 'podany plik '.$name_file.' jest nie dozwolonego formatu. Wybierz inną fotografię.';
			}
			else $_SESSION['no_settings'] = 'nazwa pliku '.$name_file.' jest niepożądana. Spróbuj z innym plikiem albo zmień jego nazwe.';
		}
		else $_SESSION['no_settings'] = 'nie podano żadnego pliku lub wystąpił błąd.';
	}
?>