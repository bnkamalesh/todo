<?php
require(dirname(__FILE__).'/includes/common.php');

loadHeader("INSTALLATION");

?>

<div class="install">
<?php
if( INSTALLED_DB == false ){
?>
	<h1>Simple ToDo List - Installation</h1>
	<form method="post" action="db/setup.php">
		<p>
			<label>Database server</label>
			<input type="text" name="host" value="localhost"/>
		</p>
		
		<p>
			<label>Database Name</label>
			<input type="text" name="name"/>
		</p>

		<p>
			<label>Username</label>
			<input type="text" name="username" value="root"/>
		</p>

		<p>
			<label>Password</label>
			<input type="password" name="password"/>
		</p>

		<p>
			<label>Port number</label>
			<input type="text" name="port" value="3306"/>
		</p>
		
		<p>
			<label>
				Site URL [ Eg: http://www.yoursite.com/todo/ ]
			</label>
			<input type="text" name="site_url" value="http://" id="site_url"/>
		</p>
		<p>
			<label>
				Twitter consumer key (optional, for Twitter authentication)
			</label>
			<input type="text" name="twitter_key"/>
		</p>
		<p>
			<label>
				Twitter consumer secret (optional, for Twitter authentication)
			</label>
			<input type="text" name="twitter_secret"/>
		</p>
		<p>
			<input type="submit" value="Install" class="button" />
		</p>
		
	</form>
<?php
}// if( INSTALLED_DB == false )
else {
?>

<h3>Installation finished. Go back to <a href="index.php">Main Page</a></h3>

<?php
}//else
?>
</div>

<script type="text/javascript">
<!--
	$(document).ready(function() {
		var href = document.location.href.split('/');
		delete(href[href.length-1]);
		$('#site_url').val( href.join('/') );
	});
//-->
</script>

<?php
loadFooter();
?>