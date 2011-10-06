<?php

	require(dirname(__FILE__).'/includes/common.php');

	if(!TWITTER_KEY || !TWITTER_SECRET) {
		die('Twitter authentication is not enabled');
	}

	require("twitteroauth/twitteroauth.php");
	
	if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
	
        // We've got everything we need  
		    // TwitterOAuth instance, with two new parameters we got in twitter_login.php  
		$twitteroauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		// Let's request the access token  
		$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
		// Save it in a session var 
		$_SESSION['access_token'] = $access_token; 
		// Let's get the user's info 
		$user_info = $twitteroauth->get('account/verify_credentials'); 
		// Print user's info	
		
		if( isset($user_info) ){
		
			$_SESSION['user_id'] = "twitter.".$user_info->screen_name;
			header('Location: login.php');
		}
		
    } 
	else {
        // Something's missing, go back to square 1  
		die("Unable to connect to twitter<br/>");
    }
?>