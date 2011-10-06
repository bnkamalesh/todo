<?php
require_once dirname(__FILE__).'/includes/common.php';

if(LOGGED_IN == true){

	if( isset($_SESSION['user_id']) ){
		$username = $_SESSION['user_id'];
	}
}
else{
	/*header("Location:".."home.php");
	exit; */
	die ("You are not logged in.");
}

if( initDB() == true ){

	if(isset($_POST['remove_event_id'])){
		$event_id = $_POST['remove_event_id'];
		/*REMOVE the respective event here*/
		$query = "DELETE from todo_event where id='".$event_id."'";
		$exec = mysql_query($query);
		if( !$exec ){
			die(mysql_error());
		}
	}

	if( isset($_POST['update_event_id']) ){

		$event_id = $_POST['update_event_id'];
		/*REMOVE the respective event here*/
		$query = "UPDATE todo_event SET status='done' where id='".$event_id."'";
		$exec = mysql_query($query);

		if( !$exec ){
			die(mysql_error());
		}

	}

	if( isset($_POST['e_title']) && isset($_POST['e_desc']) ){
		$e_title = $_POST['e_title'];
		$e_desc = $_POST['e_desc'];
		
		$user_id = getUserId($_SESSION['user_id']);
		
		$query = sprintf("INSERT INTO todo_event(user_id,title,description,status) VALUES('%d','%s','%s','pending')",
            mysql_real_escape_string($user_id),
            mysql_real_escape_string($e_title),
			mysql_real_escape_string($e_desc));
			
		
		//$query = "INSERT INTO todo_event(user_name,title,description,status) VALUES('".$_SESSION['user_id']."','".$e_title."','".$e_desc."','pending')";
		
		//die($query);
		$exec = mysql_query($query);
		if( !$exec ){
			die(mysql_error());
		}
	}
	
	$user_id = getUserId($_SESSION['user_id']);
	
	$query = "SELECT * FROM todo_event WHERE user_id ='".$user_id."' ORDER BY status DESC";
	$exec = mysql_query($query);
	if( !$exec ){
		die (mysql_error());
	}	
	else{
		$empty_flag=0;
		while($row = mysql_fetch_array($exec)){
			$empty_flag=1;
			echo "<div class='event ".$row['status']."' id='".$row['id']."' >\n";
			echo "<a href='#' class='event_drop' rel='".$row['id']."'>x</a>";
			echo "<div class='clear'></div>";
			echo "<h2 class='event_title'>".htmlspecialchars($row['title'])."</h2>\n";
			echo "<p class='event_description'>".htmlspecialchars($row['description'])."</p>\n";

			echo '<p class="options">';
			if($row['status'] == "pending"){
				echo "<span class='event_status'>Pending</span>\n";
				echo "<a href='#' class='event_change_status' rel='".$row['id']."'>Mark as done &#x2713;</a>";
			} 
			else {
				echo "<span class='event_status'>Done &#x2713;</span>\n";
			}
			echo '</p>';

			echo "</div>\n";
			
		}
		if($empty_flag == 0){
			echo "<h2>You don't have any tasks yet.</h2>";
		}
	}
}
else{
	echo "Unknown error occured.<br/>";
}
?>