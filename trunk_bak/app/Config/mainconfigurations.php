<?php
/* configuration for authorize.net */
if (!defined('AUTHLOGIN')) {
	define("AUTHLOGIN","55RNJkq29G6n");
}
if (!defined('AUTHAPIKEY')) {
define("AUTHAPIKEY","2YNb4t248Zejmj8d");
}
if (!defined('AUTHMODE')) {
define("AUTHMODE","testMode");
}
if (!defined('AUTHURL')) {
define("AUTHURL","apitest.authorize.net");
}
if (!defined('MODE')) {
define("MODE","testMode");
}
/* end here */
/*
if(!defined('API_USERNAME')){
	define('API_USERNAME','silkysethi_api1.zapbuild.com' );
}
if(!defined('API_PASSWORD')){
	define('API_PASSWORD','1378989667');
}
if(!defined('API_SIGNATURE')){
	define('API_SIGNATURE','Ab32-xHeRj.bzhPPrZacl683SHC2AclVEVh49teyHxBb1XIBVarAluvv');
}
if(!defined('API_APPLICATIONID')){
	define('API_APPLICATIONID','APP-80W284485P519543T');
}
*/
	
if(!defined('X_PAYPAL_RESPONSE_DATA_FORMAT')){
	define('X_PAYPAL_RESPONSE_DATA_FORMAT','JSON');
}
//--------------FOR PAYPAL
if(!defined('PAYPAL_REDIRECT_URL')) {
	define('PAYPAL_REDIRECT_URL', 'https://www.sandbox.paypal.com/webscr&cmd=');
}
if(!defined('DEVELOPER_PORTAL')){
	define('DEVELOPER_PORTAL', 'https://developer.paypal.com');
}
if(!defined('DEVICE_ID')) {
	define('DEVICE_ID', 'PayPal_Platform_PHP_SDK');	
}

if(defined('API_MODE') && API_MODE == 'sandbox') {
	/**
	# Endpoint: this is the server URL which you have to connect for submitting your API request.
	Chanege to https://svcs.paypal.com/  to go live */
	if(!defined('API_BASE_ENDPOINT')){
		define('API_BASE_ENDPOINT', 'https://svcs.sandbox.paypal.com/');
	}

	/***** 3token API credentials *****************/
	if(!defined('API_AUTHENTICATION_MODE')){
		define('API_AUTHENTICATION_MODE','3token');
	}
	if(!defined('LOGFILENAME')){
		define('LOGFILENAME','logs/paypal_platform.log');
	}
	/**
	 * Use the following setting (false) if you are testing or using SDK against live PayPal's production server 
	 */
	if(!defined('TRUST_ALL_CONNECTION')){
		define('TRUST_ALL_CONNECTION',false);
	}
	/**
	 * Defines the SDK Version, Request and Response message formats.
	 */
	if(!defined('SDK_VERSION')){
		define('SDK_VERSION','PHP_SOAP_SDK_V1.4');
	}
	if(!defined('X_PAYPAL_APPLICATION_ID')){
		define('X_PAYPAL_APPLICATION_ID','APP-80W284485P519543T');
	}
	//Binding options -> SOAP11,XML,JSON
	if(!defined('X_PAYPAL_REQUEST_DATA_FORMAT')){
		define('X_PAYPAL_REQUEST_DATA_FORMAT','JSON');
	}
	if(!defined('X_PAYPAL_RESPONSE_DATA_FORMAT')){
		define('X_PAYPAL_RESPONSE_DATA_FORMAT','JSON');
	}
	/*
	 * IP Address of the device
	 */
	if(!defined('X_PAYPAL_DEVICE_IPADDRESS')){
		define('X_PAYPAL_DEVICE_IPADDRESS','127.0.0.1');
	}

	//define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
	if(!defined('API_ENDPOINT')){
		define('API_ENDPOINT', 'https://api-3t.sandbox.paypal.com/nvp');
	}
	/**
	USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
	like define('USE_PROXY',TRUE);
	*/
	if(!defined('USE_PROXY')){
		define('USE_PROXY',FALSE);
	}
	/**
	PROXY_HOST: Set the host name or the IP address of proxy server.
	PROXY_PORT: Set proxy port.

	PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
	*/
	if(!defined('PROXY_HOST')){
		define('PROXY_HOST', '127.0.0.1');
	}
	/*if(!defined('API_USERNAME')){
	define('API_USERNAME', '808');
	}*/
	/* Define the PayPal URL. This is the URL that the buyer is
	first sent to to authorize payment with their paypal account
	change the URL depending if you are testing on the sandbox
	or going to the live PayPal site
	For the sandbox, the URL is
	https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	For the live site, the URL is
	https://www.paypal.com/webscr&cmd=_express-checkout&token=
	*/
	if(!defined('PAYPAL_URL')){
		define('PAYPAL_URL', 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=');
	}
} else {
	/**
	# Endpoint: this is the server URL which you have to connect for submitting your API request.
	Chanege to https://svcs.paypal.com/  to go live */
	if(!defined('API_BASE_ENDPOINT')){
		define('API_BASE_ENDPOINT', 'https://svcs.paypal.com/');
	}

	/***** 3token API credentials *****************/
	if(!defined('API_AUTHENTICATION_MODE')){
		define('API_AUTHENTICATION_MODE','3token');
	}
	if(!defined('LOGFILENAME')){
		define('LOGFILENAME','logs/paypal_platform.log');
	}
	/**
	 * Use the following setting (false) if you are testing or using SDK against live PayPal's production server 
	 */
	if(!defined('TRUST_ALL_CONNECTION')){
		define('TRUST_ALL_CONNECTION',false);
	}
	/**
	 * Defines the SDK Version, Request and Response message formats.
	 */
	if(!defined('SDK_VERSION')){
		define('SDK_VERSION','PHP_SOAP_SDK_V1.4');
	}
	if(!defined('X_PAYPAL_APPLICATION_ID')){
		define('X_PAYPAL_APPLICATION_ID',API_APPLICATIONID);
	}
	//Binding options -> SOAP11,XML,JSON
	if(!defined('X_PAYPAL_REQUEST_DATA_FORMAT')){
		define('X_PAYPAL_REQUEST_DATA_FORMAT','JSON');
	}
	if(!defined('X_PAYPAL_RESPONSE_DATA_FORMAT')){
		define('X_PAYPAL_RESPONSE_DATA_FORMAT','JSON');
	}
	/*
	 * IP Address of the device
	 */
	if(!defined('X_PAYPAL_DEVICE_IPADDRESS')){
		define('X_PAYPAL_DEVICE_IPADDRESS','127.0.0.1');
	}

	//define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
	if(!defined('API_ENDPOINT')){
		define('API_ENDPOINT', 'https://api-3t.paypal.com/nvp');
	}
	/**
	USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
	like define('USE_PROXY',TRUE);
	*/
	if(!defined('USE_PROXY')){
		define('USE_PROXY',FALSE);
	}
	/**
	PROXY_HOST: Set the host name or the IP address of proxy server.
	PROXY_PORT: Set proxy port.

	PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
	*/
	if(!defined('PROXY_HOST')){
		define('PROXY_HOST', '127.0.0.1');
	}
	/*if(!defined('API_USERNAME')){
	define('API_USERNAME', '808');
	}*/
	/* Define the PayPal URL. This is the URL that the buyer is
	first sent to to authorize payment with their paypal account
	change the URL depending if you are testing on the sandbox
	or going to the live PayPal site
	For the sandbox, the URL is
	https://www.paypal.com/webscr&cmd=_express-checkout&token=
	For the live site, the URL is
	https://www.paypal.com/webscr&cmd=_express-checkout&token=
	*/
	if(!defined('PAYPAL_URL')){
		define('PAYPAL_URL', 'https://www.paypal.com/webscr&cmd=_express-checkout&token=');
	}
}
/*
if(!defined('PAYPAL_SENDER_EMAIL')){
	define('PAYPAL_SENDER_EMAIL', 'silkysethi@zapbuild.com');
}
* */
/**
# Version: this is the API version in the request.
# It is a mandatory parameter for each API request.
# The only supported value at this time is 2.3
*/
if(!defined('VERSION')){
	define('VERSION', '3.0');
}	


/* configurations for Facebook Connect */

/* configurations for Facebook Connect end here */

/* configurations for Twitter Connect */

/* configurations for Twitter Connect end here */


?>
