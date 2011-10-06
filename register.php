<?php

require(dirname(__FILE__).'/includes/common.php');

if(INSTALLED_DB == false){
	die("You need to run intall.php before registering.");
}

if(LOGGED_IN == true){
	header("Location: home.php");
	exit;
}
	if( isset($_POST['reg_user']) && !isset($_POST['reg_password'])){

		/*FILTER DATA*/
		$user_name = $_POST['reg_user'];
		if( validateUsername($user_name) == false){
			die("Invalid username");
		}

		initDB();

		$chk = '';

		$exec = mysql_query("SELECT user_name from todo_login where user_name='".$user_name."'");
		if( !$exec ){
			die(mysql_error());
		}

		while($row = mysql_fetch_array($exec)){

			if($row['user_name'] == $user_name){

				$chk = $user_name;
				break;
			}
		}

		if( $chk == ''){
			echo "*Available";
		}
		else if( $chk == $user_name){
			echo "*Not Available";
		}

	}
	else if(isset($_POST['reg_user']) && isset($_POST['reg_password'])){

		/*FILTER DATA*/
		$user_name = $_POST['reg_user'];
		$password = $_POST['reg_password'];

		if( validateUsername($user_name) == false){
			die("Invalid username");
		}
		else{
			
			//initiating database connection.
			initDB();

			//Checking if username already exists.
			$chk = '';

			$exec = mysql_query("SELECT user_name from todo_login where user_name='".$user_name."'");
			if( !$exec ){
				die(mysql_error());
			}

			while($row = mysql_fetch_array($exec)){
	
				if($row['user_name'] == $user_name){

					$chk = $user_name;
					break;
				}
			}

			if( $chk == $user_name){
				die("The username is taken. Please try something else.");
			}


			//Encrypting password
			$password = md5(MD5_SALT.$password);

			$exec = "INSERT INTO todo_login(user_name,password) VALUES('".$user_name."','".$password."')";
			if( !mysql_query($exec) ){
				die('0');
			}
			else{
				// log the user in automatically
				$_SESSION['user_id'] = $user_name;
				die('1');
			}
		}
		
	}
	else{
		echo "Status Unknown";
	}

?>

