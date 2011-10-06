<?php
require(dirname(__FILE__).'/../includes/common.php');


if( INSTALLED_DB == true ){
	header("Location:".DIR_ROOT."/index.php");
}

if(!isset($_POST) ){
	header("Location:".DIR_ROOT."/install.php");
}

set_error_handler("customError");

$connect = mysql_connect($_POST['host'],$_POST['username'],$_POST['password']);

if( ! $connect ){
	die("Unable to connect to database server. <br/> \n".mysql_error()."\n<br/>");
}
else{

	$chk_db = mysql_select_db($_POST['name'], $connect);
	if (!$chk_db) {
		die("Unable to connect to the database ".htmlentities($_POST['name']). "\n <br/>" . mysql_error());
	}
	else{
		if( !file_exists('config.php') ){

			if($connect && $chk_db){
				// read the schema
				$sql = file_get_contents('mysql.sql') or die ('Could not open mysql.sql, unable to complete installation');
				$sql = explode('$',$sql);
				foreach($sql as $query){
					mysql_query($query) or die(mysql_error());
				}
			}

			$configFile = fopen("config.php",'w') or die ("Unable to create data to config.php");
			fwrite($configFile,"<?php \n\n");

			$definition = "define('DB_HOST',"."'".$_POST['host']."'); \n";
			fwrite($configFile,$definition);
			
			$definition = "define('DB_NAME',"."'".$_POST['name']."'); \n";
			fwrite($configFile,$definition);

			$definition = "define('DB_USER',"."'".$_POST['username']."'); \n";
			fwrite($configFile,$definition);

			$definition = "define('DB_PASS',"."'".$_POST['password']."'); \n";
			fwrite($configFile,$definition);

			$definition = "define('DB_PORT',"."'".$_POST['port']."'); \n";
			fwrite($configFile,$definition);
			
			$url = trim($_POST['site_url']);
			if(substr($url, -1) != '/'){
				$url = $url.'/';
			}
			
			$definition = "define('ROOT_URL',"."'".$url."'); \n";			
			fwrite($configFile,$definition);
			
			$definition = "define('TWITTER_KEY',"."'".( !empty($_POST['twitter_key']) ? $_POST['twitter_key'] : '')."'); \n";			
			fwrite($configFile,$definition);
			
			$definition = "define('TWITTER_SECRET',"."'".( !empty($_POST['twitter_secret']) ? $_POST['twitter_secret'] : '')."'); \n";			
			fwrite($configFile,$definition);

			$definition = "define('TABLE_LOGIN','todo_login'); \n";
			fwrite($configFile,$definition);

			$definition = "define('TABLE_EVENT','todo_event'); \n";
			fwrite($configFile,$definition);

			$definition = "define('MD5_SALT','".md5(time()."#FF15924OLQWTY")."'); \n";
			fwrite($configFile,$definition);

			fwrite($configFile,"\n ?>");
			fclose($configFile);
			

			header('Location: ../install.php');

		}
		else{
			$_SESSION['setupStatus']='Already installed.';
		}
	
	}
}
?>