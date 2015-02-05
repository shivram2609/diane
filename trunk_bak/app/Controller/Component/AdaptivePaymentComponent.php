<?php

require_once 'PayPalAdaptive/AdaptivePayments.php'  ;
class AdaptivePaymentComponent extends Component {
	
	function __construct(){
			
		/**
		# API user: The user that is identified as making the call. you can
		# also use your own API username that you created on PayPal?s sandbox
		# or the PayPal live site
		*/
		/*if(!defined('API_USERNAME')){
			define('API_USERNAME', 'zrfbl_1298620336_biz_api1.163.com');
		}*/
		/**
		# API_password: The password associated with the API user
		# If you are using your own API username, enter the API password that
		# was generated by PayPal below
		# IMPORTANT - HAVING YOUR API PASSWORD INCLUDED IN THE MANNER IS NOT
		# SECURE, AND ITS ONLY BEING SHOWN THIS WAY FOR TESTING PURPOSES
		*/
		/*if(!defined('API_PASSWORD')){
			define('API_PASSWORD', '1298620354');
		}*/
		/**
		# API_Signature:The Signature associated with the API user. which is generated by paypal.
		*/
		/*if(!defined('API_SIGNATURE')){
			define('API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AeYGJ2JsUj2KzvuzhfTAc6JCSHNh');
		}*/
		/**
		# Endpoint: this is the server URL which you have to connect for submitting your API request.
		*/
		/*if(!defined('SITE_LINK')) {
			if (isset($this->params->base) && $this->params->base != '') {
				define("SITE_LINK","http://".$_SERVER['HTTP_HOST'].$this->params->base."/");
				define("FILE_LINK","http://".$_SERVER['HTTP_HOST'].$this->params->base."/");
			} else { 
				define("SITE_LINK","http://".$_SERVER['HTTP_HOST']."/");
				define("FILE_LINK","http://".$_SERVER['HTTP_HOST']."/");
			}
		}
		if(!defined('RETURN_URL')){
			define('RETURN_URL', SITE_LINK);
		}
		if(!defined('CENCEL_URL')){
			define('CENCEL_URL', SITE_LINK);
		}*/
	}
	function payment( $paymentDetails = array(array('paypalemail'=>'rajinder323-facilitator@gmail.com','amount'=>10.00))){
		$payRequest = new PayRequest();
		$payRequest->actionType = "PAY";
		$returnURL = RETURN_URL;
		$cancelURL = CENCEL_URL;
		$payRequest->cancelUrl = $cancelURL ;
		$payRequest->returnUrl = $returnURL;
		$payRequest->clientDetails = new ClientDetailsType();
		$payRequest->clientDetails->applicationId = API_APPLICATIONID;
		$payRequest->clientDetails->deviceId = '127001';
		$payRequest->clientDetails->ipAddress = $_SERVER['REMOTE_ADDR'];
		$payRequest->currencyCode = 'USD';
		$payRequest->senderEmail = PAYPAL_SENDER_EMAIL;
		$payRequest->requestEnvelope = new RequestEnvelope();
		$payRequest->requestEnvelope->errorLanguage = 'en_US';
		
					
		/*$receiver1 = new receiver();
		$receiver1->email = 'rajind_1303302140_biz@w3syntactic.com';
		$receiver1->amount = '1.00';*/
		
		/*$receiver2 = new receiver();
		$receiver2->email = 'rajind_1299057520_biz@w3syntactic.com';
		$receiver2->amount = '1.00';*/
		
		$receiverList = array ( ) ;
		$i = 0 ;
		foreach ( $paymentDetails as $paymentDetail ){ 
			$receiverList[$i] = new receiver();
			$receiverList[$i]->email = $paymentDetail['paypalemail'];
			$receiverList[$i]->amount = $paymentDetail['amount'] ;
			$i++;
		}		
		
		//$payRequest->receiverList = //array($receiver1, $receiver2);
		
		$payRequest->receiverList = $receiverList ;
	
	
		// Create service wrapper object
		$ap = new AdaptivePayments();
	
		// invoke business method on service wrapper passing in appropriate request params
		$response = $ap->Pay($payRequest);
		$adaptiveResponce['ap'] = $ap ;
		$adaptiveResponce['response'] = $response ;
		//$response1 = $ap->ExecutePayment($adaptiveResponce['response'],true);
		return $adaptiveResponce;
	}
	
}
?>
