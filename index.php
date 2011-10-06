<?php

require(dirname(__FILE__).'/includes/common.php');

/*Automatically redirects to home.php if logged in.*/

if(LOGGED_IN == true){
	header("Location: home.php");
	exit;
}

/*Automatically redirects to install.php, if not installed*/
if (INSTALLED_DB == false){
	header("Location: install.php");
	exit;
}

loadHeader("Welcome!");

?>

<script type="text/javascript">

	$(document).ready(function(){

		$('#login').hide();
		$('#register').hide();

		// kn
		// handle login
		$('#login-form').submit(function() {
			$.jqDialog.notify("Please wait..");
			$.post('login.php', { username : $('#login-user').val(), password : $('#login-password').val() }, function(response){
				if(response == '1') { // success
					document.location.href = 'home.php';
				} else {
					$.jqDialog.notify("Invalid username or password", 3);
				}
			});
			return false;
		});
		
		
		// handle signup
		$('#reg-form').submit(function(){

			var reg_user = $('#reg-u').val();
			var reg_pass = $('#reg-p').val();

			if( reg_user.length >= 4 && reg_pass.length >= 6 ){
				$.jqDialog.notify("Please wait..");

				$.post('register.php',{ reg_user : $('#reg-u').val(), reg_password : $('#reg-p').val() }, function(response){
					if(response == '1'){
						document.location.href = 'home.php';
					} else {
						$.jqDialog.notify(response, 5);
					}
				});

			}
			else{
				$.jqDialog.notify("Please choose a valid username (minimum 4 chars) and password (minimum 6 chars)", 5);
			}
			return false;

		}); 
	


		$('#reg-u').keyup(function(){
			var reg_user = $(this).val();

			if(reg_user.length >= 4){
				$.post('register.php',  {reg_user: $('#reg-u').val()}, function(response){
					$('#availability').html(response);
				});
			}
			else{
				$('#availability').html('');
			}
		});




		var clicked=0;

		$('#login_box').click(function(){
			//$('.home_container');
			if( clicked == 0 ){
				clicked=1;
				$('.home_buttons').fadeOut(200);
					$(this).fadeOut(200,
							function(){
								$('#login').fadeIn(function(){ clicked=0;});
							});
			}
		});
	
		$('#reg_box').click(function(){
			//$('.home_container');
			if( clicked == 0 ){
				clicked=1;
				$('.home_buttons').fadeOut(200);
				$(this).fadeOut(200,
							function(){
								$('#register').fadeIn(function(){ clicked=0;});
							});
			}
		});


	});
	
</script>
	<div class="home_container">
		<h1>Simple To-do List</h1>
		<div class="home_buttons">
			<div class="home_box" id="login_box">Login</div>
			<div class="home_box" id="reg_box">Register</div>
			<div class="clear"> </div>
			<?php if(TWITTER_KEY && TWITTER_SECRET) { ?>
				<p><a href="twitter_login.php"><img src="images/twitter_sign.png" alt="Twitter Sign In"/></a></p>
			<?php } ?>
		</div>
		<div id="login">

			<form method="post" action="login.php" id="login-form">

					<p>
						<label>Username</label>
						<input type="text" name="username" id="login-user" />
					</p>

					<p>
						<label>Password</label>
						<input type="password" name="password" id="login-password" />
					</p>
		
					<p>
						<input type="submit" value="Login" class="button" />
					</p>

				</table>
			</form>

		</div>

		<div id="register">

			<form method="post" id="reg-form">
					<p>
						<label>Choose a Username</label>
						<input type="text" name="reg_user" id="reg-u"/> <span id="availability"></span>
					</p>

					<p>
						<label>Choose a Password</label>
						<label><input type="password" name="reg_pass" id="reg-p"/></label>
					</p>
		
					<p>
						<input type="submit" value="Register" class="button" />
					</p>

				</table>
			</form>

		</div>
		<div class="clear"> </div>
		<p class="credit"><a href="">Simple ToDo List</a> By, Kamaleshwar </p>
	</div>
<?php
loadFooter();
?>