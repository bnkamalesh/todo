<?php
require_once dirname(__FILE__).'/includes/common.php';

/* Automatically redirects to index.php if not logged in. */

if(LOGGED_IN == false){
	header("Location: index.php");
}

$display_name = str_replace("twitter.", "[twitter] ",$_SESSION['user_id']);

loadHeader("Hello, ".$display_name);

?>

<script type="text/javascript">

	$(document).ready(function(){

		$('#new_e_title').val('').focus();
		
		$.post('ajax.php',function(response){
					$('.event_container').html(response);
		});


		$('.event_drop').live('click',function(){
			var eventId = $(this).attr('rel');
			//alert(eventId);
			/* AJAX to remove the event from db*/
			$(this).parent().fadeOut(500,function(){
				$.post('ajax.php',{remove_event_id: eventId},function(response){
					$('.event_container').html(response);
				});
			});
			return false;
		});



		$('.event_change_status').live('click',function(){

			var eventId = $(this).attr('rel');
			//alert(eventId);
			/* AJAX to remove the event from db*/
			$.post('ajax.php',{update_event_id: eventId},function(response){
				$('.event_container').html(response);
			});
			return false;

		});


		$('#event_add').submit(function(){
			var event_title = $('#new_e_title').val();
			var event_desc = $('#new_e_desc').val();

			if((event_title.length < 3 || event_desc.length < 3) || (event_title.length > 50 || event_desc.length > 100)){
				$.jqDialog.notify("<p align='left'>Only [3 to 50] characters allowed for Task Title.<br/>"
				+"Only [3 to 100] characters allowed for Task Description.</p>", 3);
				return false;
			}
			
			$.jqDialog.notify("Please wait");
			/* AJAX to add event to db*/
			$.post('ajax.php',{ e_title: event_title, e_desc: event_desc },function(response){
				//alert("add event"+response);
				$('.event_container').html(response);
				$.jqDialog.close();
				$('#new_e_title').val('').focus();
				$('#new_e_desc').val('');
			});
			
			return false;
		});

	});
</script>

<div id="header">
	<p class="user_info"><?php echo $display_name; ?> <a href="login.php?logout=1" class="logout button">Log out</a></p>
	<h3 class="today"><?php echo date('l, d M Y'); ?></h3>
	<form id="event_add" method="post" action="">
		<label>New Task Title </label><input type="text" id="new_e_title" maxlength="50" />
		<label> Task Description </label><input type="text" id="new_e_desc" maxlength="100" />
		<input type="submit" value="Add" class="button" />
		<div class="clear"></div>
	</form>
</div>

<div class="clear"></div>

<div class="event_container">

</div> <!-- event container -->
<div class="clear"> </div>
<p class="credit"><a href="">Simple ToDo List,</a> By Kamaleshwar</p>
<?php
loadFooter();
?>