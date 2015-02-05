<?php 
App::uses('HttpSocket', 'Network/Http');

class PaypalComponent extends Component {
	
	public $environment = '';
	
	function PPHttpPost($methodName_, $nvpStr_) {
		
	 
		// Set up your API credentials, PayPal end point, and API version.
		/*$API_UserName = urlencode('sdk-three_api1.sdk.com'); // set your spi username
		$API_Password = urlencode('QFZCWN5HZM8VBG7Q'); // set your spi password
		$API_Signature = urlencode('A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI'); // set your spi Signature
		*/
		// Set up your API credentials, PayPal end point, and API version.
		//$API_UserName = urlencode('sdk-three_api1.sdk.com'); // set your spi username
		//$API_UserName = urlencode('ramandeepsingh_api1.zapbuild.com'); // set your spi username
		$API_UserName = urlencode(API_USERNAME); // set your spi username
		//$API_Password = urlencode('QFZCWN5HZM8VBG7Q'); // set your spi password
		//$API_Password = urlencode('1366969590'); // set your spi password
		$API_Password = urlencode(API_PASSWORD); // set your spi password
		//$API_Signature = urlencode('A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI'); // set your spi Signature
		//$API_Signature = urlencode('AFcWxV21C7fd0v3bYYYRCpSSRl31AQlOcoawGEVlXYpmukJDINPv8K-t'); // set your spi Signature 
		$API_Signature = urlencode(API_SIGNATURE); // set your spi Signature 
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
		$this->environment = API_MODE;
		if("sandbox" === $this->environment || "beta-sandbox" === $this->environment) {
			$API_Endpoint = "https://api-3t.".$this->environment.".paypal.com/nvp";
		}
		$version = urlencode('51.0');
	 
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	 
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
	 
		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	 
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	 
		// Get response from the server.
		$httpResponse = curl_exec($ch);
	 
		if(!$httpResponse) {
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
		}
	 
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	 
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
	 
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}
	 
		return $httpParsedResponseAr;
	}
	 
	function makepayment($data) { 
		// Set request-specific fields.
		$paymentType = urlencode('Sale');				// 'Authorization' or 'Sale'
		$firstName = urlencode($data['first_name']);
		$lastName = urlencode($data['last_name']);
		$creditCardType = urlencode($data['card_type']);
		$creditCardNumber = urlencode($data['card_number']);
		$expDateMonth = $data['exp_month'];
		// Month must be padded with leading zero
		$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
		 
		$expDateYear = $data['exp_year'];
		$cvv2Number = urlencode($data['cvv']);
		$address1 = urlencode($data['customer_address1']);
		$address2 = urlencode($data['customer_address2']);
		$city = urlencode($data['customer_city']);
		$state = urlencode($data['customer_state']);
		$zip = urlencode($data['customer_zip']);
		$country = urlencode($data['customer_country']);				// US or other valid country code
		$amount = urlencode($data['payment_amount']);
		$currencyID = urlencode('USD');							// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
		 
		// Add request-specific fields to the request string.
		$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
					"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
					"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
		 
		// Execute the API operation; see the PPHttpPost function above.
		$httpParsedResponseAr = $this->PPHttpPost('DoDirectPayment', $nvpStr);
		 
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			//exit('Direct Payment Completed Successfully: '.print_r($httpParsedResponseAr, true));
			return $httpParsedResponseAr;
		} else  {
			//exit('DoDirectPayment failed: ' . print_r($httpParsedResponseAr, true));
			return $httpParsedResponseAr;
		}
	}
		
}
