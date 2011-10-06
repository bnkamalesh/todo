<?php

	/* Twitter API controller downloaded from http://github.com/abraham/twitteroauth */
	require(dirname(__FILE__).'/includes/common.php');
	
	if(!TWITTER_KEY || !TWITTER_SECRET) {
		die('Twitter authentication is not enabled');
	}
	
	require("twitteroauth/twitteroauth.php");
	
	
	// The TwitterOAuth instance  
    $twitteroauth = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET);
    // Requesting authentication tokens, the parameter is the URL we will be redirected to  
    $request_token = $twitteroauth->getRequestToken(ROOT_URL.'twitter_oauth.php');
	
	
    // Saving them into the session
    $_SESSION['oauth_token'] = $request_token['oauth_token'];  
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  
      
    // If everything goes well..  
    if($twitteroauth->http_code==200){
        // Let's generate the URL and redirect  
        $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
        header('Location: '.$url);
    } else {
        // It's a bad idea to kill the script, but we've got to know when there's an error.  
        die('Something wrong happened.');
	}
?>