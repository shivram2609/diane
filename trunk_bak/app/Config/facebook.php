<?php
/**
  * Get an api_key and secret from facebook and fill in this content.
  * save the file to app/Config/facebook.php
  */
  $config = array(
  	'Facebook' => array(
  		'appId' => FACEBOOK_API_KEY,
  		'apiKey' => FACEBOOK_API_KEY,
  		'secret' => FACEBOOK_SECRET_KEY,
  		'cookie' => true,
  		'locale' => 'en_US',
  		)
  	);
?>
