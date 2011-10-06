<?php
	session_start();

	define('DIR_ROOT',dirname(__FILE__).'/../');

	/* Loading config.php if exists*/
	if(file_exists(DIR_ROOT.'/db/config.php')){
		include(DIR_ROOT."/db/config.php");
		define("INSTALLED_DB",true);
	}
	else{
		//echo "config.php not found ! You need to run install.php";
		define("INSTALLED_DB",false);
		session_destroy();
	}
	
	if( isset($_SESSION['user_id']) ){
		define('LOGGED_IN', true);
	}
	else {
		define('LOGGED_IN', false);
	}

/* End of constant definitions*/

	


	function customError($errno,$errstr){
		die( "Error [".$errno."] : ".$errstr.".<br/>");
	}


	function loadHeader($title){
		include(DIR_ROOT.'template/header.php');
	}


	function loadFooter(){
		require(DIR_ROOT.'template/footer.php');
	}


	function validateUsername($username) {
		return !preg_match("/[^0-9a-z_]/i", $username);
	}

	
	function initDB(){

			$connect = mysql_connect(DB_HOST,DB_USER,DB_PASS);
			if( !$connect || !mysql_select_db(DB_NAME)){
				die(mysql_error());
			}
		return true;
	}
	
	function getUserId($username){
		
		$query = "SELECT id FROM todo_login WHERE user_name ='".$username."'";
		$exec = mysql_query($query);
		if( !$exec ){
			die (mysql_error());
		}
		else{
			while($row = mysql_fetch_array($exec)){
				return $row['id'];
				break;
			}
		}
		
	}
?>