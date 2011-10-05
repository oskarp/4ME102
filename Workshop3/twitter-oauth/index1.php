<?php

# Arvin Castro, arvin@sudocode.net
# http://sudocode.net/article/340/authenticating-with-twitter-using-oauth-in-php
# January 12, 2011

include 'class-xhttp-php/class.xhttp.php';

$consumer_token  = '';
$consumer_secret = '';
$callbackURL     = 'http://'; # Change this to the URL of this script

session_name('twitteroauth');
session_start();


#require 'class-xhttp-php/plugin.xhttp.oauth.php'
#require 'class-xhttp-php/plugin.xhttp.profile.php'

xhttp::load('profile,oauth');
$twitter = new xhttp_profile();
$twitter->oauth($consumer_token, $consumer_secret);

if(isset($_GET['logout'])) {
	$_SESSION = array();
	session_destroy();
	echo 'You were logged out.<br><br>';
}

if(isset($_GET['signin']) and !$_SESSION['loggedin']) {

	# STEP 1: Request a Token
	$data = array();
	$data['post']['oauth_callback'] = $callbackURL;
	$response = $twitter->fetch('https://api.twitter.com/oauth/request_token', $data);

	if($response['successful']) {
		$var = xhttp::toQueryArray($response['body']);
		$_SESSION['oauth_token']        = $var['oauth_token'];
		$_SESSION['oauth_token_secret'] = $var['oauth_token_secret'];

		# STEP 2: Redirect user to Twitter, to grant our app access
		header('Location: https://api.twitter.com/oauth/authenticate?oauth_token='.$_SESSION['oauth_token'], true, 303);
		die();

	} else {
		echo 'Could not get token.<br><br>';
	}
}

# After Step 2, user is redirected back, GET variables are set by Twitter
if($_GET['oauth_token'] == $_SESSION['oauth_token'] and $_GET['oauth_verifier'] and !$_SESSION['loggedin']) {

	# STEP 3: Exchange the token we have for an Access Token
	$data = array();
	$data['post']['oauth_verifier'] = $_GET['oauth_verifier'];

	$twitter->set_token($_GET['oauth_token']);
	$response = $twitter->fetch('https://api.twitter.com/oauth/access_token', $data);

	if($response['successful']) {

		$var = xhttp::toQueryArray($response['body']);

		$_SESSION['user_id'] = $var['user_id'];
		$_SESSION['screen_name'] = $var['screen_name'];
		$_SESSION['oauth_token'] = $var['oauth_token'];
		$_SESSION['oauth_token_secret'] = $var['oauth_token_secret'];
		$_SESSION['loggedin'] = true;

	} else {
		echo 'Unable to sign you in with Twitter. Please try again later.<br><br>';
		echo $response['body'];
	}
}

if(isset($_POST['tweet']) and $_SESSION['loggedin']) {

    # Set access token
	$twitter->set_token($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

	$data = array();
	$data['post']['status'] = $_POST['status'];

	$response = $twitter->fetch('http://api.twitter.com/1/statuses/update.json', $data);

	if($response['successful']) {
	    echo "Update successful!<br><br>";
	} else {
	    echo "Update failed. {$response[body]}<br><br>";
	}
}

if($_SESSION['loggedin']) { ?>

<strong>user_id</strong>: <?php echo $_SESSION['user_id']; ?><br />
<strong>screen_name</strong>: <?php echo $_SESSION['screen_name']; ?><br />
<strong>oauth_token</strong>: <?php echo $_SESSION['oauth_token']; ?><br />
<strong>oauth_token_secret</strong>: <?php echo $_SESSION['oauth_token_secret']; ?><br /><br />
<a href="?logout">Log out</a>

<form method="POST">
	<textarea name="status" rows="4" cols="50"></textarea><br />
	<input type="submit" name="tweet" value="Update Status" />
</form>

<?php } else { /* User is not logged in */ ?>
<a href="?signin">Sign in with Twitter</a>
<?php } ?>