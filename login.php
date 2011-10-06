<?php

require(dirname(__FILE__).'/includes/common.php');


if(LOGGED_IN == 1){
	$username = $_SESSION['user_id'];
	if(strlen($username) <= 8){
		session_destroy();
		header("Location: index.php");
	}
	if ( substr($username,0,8) == 'twitter.'){
	
		if(initDB() == true){
			$exec = mysql_query("SELECT user_name from todo_login where user_name='".$username."'");
			
			if( !$exec ){
				die(mysql_error());
			}
			
			$check_empty =0;
			
			while($row = mysql_fetch_array($exec)){
				if( $_SESSION['user_id'] == $row['user_name']){
					$check_empty =1;
					break;
				}
			}
			
			if( $check_empty == 0 ){
			
				$exec = mysql_query("INSERT INTO todo_login (user_name) VALUES ('".$_SESSION['user_id']."')");
				if( !$exec ){
					die(mysql_error());
				}
			}
			mysql_close();
		}
		else{
			die(mysql_error());
		}
	}
	header('Location: index.php');
}

/* Destroys current session when logged out.*/
if(isset($_GET['logout'])){

	if( $_GET['logout'] == 1){
		session_destroy();
		header("Location: index.php");
	}
	exit;
}


/* No username or password supplied */
if( !isset($_POST['username']) || !isset($_POST['password'])){
	die('');
}

	$username = $_POST['username'];
	$password = $_POST['password'];

	if( validateUsername($username) == false){
		die('0');
	}
	else{
		
		if (initDB() == true){

			$password = md5(MD5_SALT.$password);


			$exec = mysql_query("SELECT * from todo_login where user_name='".$username."'");
			if( !$exec ){
				die(mysql_error());
			}

			while($row = mysql_fetch_array($exec)){

				if($row['user_name'] == $username){
					if($row['password'] == $password){
						$_SESSION['user_id'] = $row['user_name'];
						die('1');
					}
					break;
				}

			}
		}
	}

?>