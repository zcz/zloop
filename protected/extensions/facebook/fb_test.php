<?php

require 'php-sdk/src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '202321366523553',
  'secret' => '554aadd5d5f6d82a55986df1706f1548',
  'fileUpload' => false,
  'domain'=>'zloop.net',
  'cookie' => true
));

$user_id = $facebook->getUser();

echo "user_id = ";
print_r($user_id);
echo "<br>";

$login_url = $facebook->getLoginUrl(
  array(
	scope => 'email,user_birthday,status_update,publish_stream',
	display => 'page', 
  ) );

    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name'] . '<br>';
	echo "Email: " . $user_profile['email'] . '<br>';
	//print_r($user_profile);
	echo "<br>";
	$token = $facebook->getAccessToken();
	echo "access token: " . $token . "<br>";

$api_call = array(  
    'method' => 'users.getinfo',  
    'uids' => $user_id,  
    'fields' => 'pic_big'  
);  
$info = $facebook->api($api_call);
$info = $info[0];
//print_r($info);
	echo "pic: " . $info['pic_big'] . '<br>';
	

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }

