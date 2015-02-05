<?php 
class AuthorizeCmiComponent extends Component {
	
	public $loginname = AUTHLOGIN; // Keep this secure.
	public $transactionkey = AUTHAPIKEY; // Keep this secure.
	public $apihost = AUTHURL;
	public $apipath = "/xml/v1/request.api";
	
	public function createprofile($email,$userid) {
		//echo "create profile...<br><br>";
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<profile>".
			"<merchantCustomerId>".$userid."</merchantCustomerId>". // Your own identifier for the customer.
			"<description></description>".
			"<email>" . $email . "</email>".
			"</profile>".
			"</createCustomerProfileRequest>";

		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		//die;
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			/*echo "customerProfileId <b>"
				. htmlspecialchars($parsedresponse->customerProfileId)
				. "</b> was successfully created.<br><br>";
			*/
				return (htmlspecialchars($parsedresponse->customerProfileId));
		} else {
			//echo "here";
			return false;
		}
		//die;
	}
	
	function createpaymentprofile($profileid = NULL ,$card = "4111111111111111", $expdate = "2020-11", $firstname = "John", $lastname = "Smith", $phone= "000-000-0000") {
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<customerProfileId>" . $profileid . "</customerProfileId>".
			"<paymentProfile>".
			"<billTo>".
			 "<firstName>".$firstname."</firstName>".
			 "<lastName>".$lastname."</lastName>".
			 "<phoneNumber>".$phone."</phoneNumber>".
			"</billTo>".
			"<payment>".
			 "<creditCard>".
			  "<cardNumber>".$card."</cardNumber>".
			  "<expirationDate>".$expdate."</expirationDate>". // required format for API is YYYY-MM
			 "</creditCard>".
			"</payment>".
			"</paymentProfile>".
			"<validationMode>".AUTHMODE."</validationMode>". // or testMode
			"</createCustomerPaymentProfileRequest>";

		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			/*echo "customerPaymentProfileId <b>"
				. htmlspecialchars($parsedresponse->customerPaymentProfileId)
				. "</b> was successfully created for customerProfileId <b>"
				. htmlspecialchars($profileid)
				. "</b>.<br><br>";*/
			return htmlspecialchars($parsedresponse->customerPaymentProfileId);
		} else {
			return false;
		}
	}
	
	function createshippingprofile($profileid = NULL,$firstname = "John", $lastname = "Smith", $phone = "000-000-0000") {
		$content =
		"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
		"<createCustomerShippingAddressRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
		$this->MerchantAuthenticationBlock().
		"<customerProfileId>" . $profileid . "</customerProfileId>".
		"<address>".
		"<firstName>John</firstName>".
		"<lastName>".$lastname."</lastName>".
		"<phoneNumber>".$phone."</phoneNumber>".
		"</address>".
		"</createCustomerShippingAddressRequest>";

		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			/*echo "customerAddressId <b>"
				. htmlspecialchars($parsedresponse->customerAddressId)
				. "</b> was successfully created for customerProfileId <b>"
				. htmlspecialchars($profileid)
				. "</b>.<br><br>";*/
				return htmlspecialchars($parsedresponse->customerAddressId);
		} else {
			return false;
		}
	}
	
	
	function makepayment($profileid,$paymentprofileid,$shippingprofileid,$amount,$description=NULL,$invoice="123456",$lineitems = array()) {
		//build xml to post
		$flag = false;
		$returnresponse = array();
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<transaction>".
			"<profileTransAuthOnly>".
			"<amount>" . $amount . "</amount>". // should include tax, shipping, and everything.
			"<customerProfileId>" . $profileid . "</customerProfileId>".
			"<customerPaymentProfileId>" . $paymentprofileid . "</customerPaymentProfileId>".
			"<customerShippingAddressId>" . $shippingprofileid . "</customerShippingAddressId>".
			"<order>".
			"<invoiceNumber>".$invoice."</invoiceNumber>".
			"</order>".
			"</profileTransAuthOnly>".
			"</transaction>".
			"</createCustomerProfileTransactionRequest>";
			

		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			$flag = true;
		}
		if (isset($parsedresponse->directResponse)) {
			$directResponseFields = explode(",", $parsedresponse->directResponse);
			$responseCode = $directResponseFields[0]; // 1 = Approved 2 = Declined 3 = Error
			$responseReasonCode = $directResponseFields[2]; // See http://www.authorize.net/support/AIM_guide.pdf
			$responseReasonText = $directResponseFields[3];
			$approvalCode = $directResponseFields[4]; // Authorization code
			$transId = $directResponseFields[6];
			
			if ("1" == $responseCode) $flag = true;
			else if ("2" == $responseCode) $flag = false;
			else $flag = false;
			if ($flag) {
				$returnresponse["responseReasonCode"] = htmlspecialchars($responseReasonCode);
				$returnresponse["responseReasonText"] = htmlspecialchars($responseReasonText);
				$returnresponse["approvalCode"]		= htmlspecialchars($approvalCode);
				$returnresponse["transId"]			= htmlspecialchars($transId);
			}
		}
		if ($flag) {
			return $returnresponse;
		} else {
			return false;
		}
	}
	
	function refundpayment($profileid,$paymentprofileid,$shippingprofileid,$amount,$description=NULL,$invoice="123456",$lineitems = array()) {
		//build xml to post
		$flag = false;
		$returnresponse = array();
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<transaction>".
			"<profileTransRefund>".
			"<amount>" . $amount . "</amount>". // should include tax, shipping, and everything.
			"<customerProfileId>" . $profileid . "</customerProfileId>".
			"<customerPaymentProfileId>" . $paymentprofileid . "</customerPaymentProfileId>".
			"<customerShippingAddressId>" . $shippingprofileid . "</customerShippingAddressId>".
			"<order>".
			"<invoiceNumber>".$invoice."</invoiceNumber>".
			"</order>".
			"</profileTransRefund>".
			"</transaction>".
			"</createCustomerProfileTransactionRequest>";
			

		//echo "Raw request: " . htmlspecialchars($content) . "<br><br>";
		$response = $this->send_xml_request($content);
		//echo "Raw response: " . htmlspecialchars($response) . "<br><br>";
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			$flag = true;
		}
		if (isset($parsedresponse->directResponse)) {
			$directResponseFields = explode(",", $parsedresponse->directResponse);
			$responseCode = $directResponseFields[0]; // 1 = Approved 2 = Declined 3 = Error
			$responseReasonCode = $directResponseFields[2]; // See http://www.authorize.net/support/AIM_guide.pdf
			$responseReasonText = $directResponseFields[3];
			$approvalCode = $directResponseFields[4]; // Authorization code
			$transId = $directResponseFields[6];
			
			if ("1" == $responseCode) $flag = true;
			else if ("2" == $responseCode) $flag = false;
			else $flag = false;
			if ($flag) {
				$returnresponse["responseReasonCode"] = htmlspecialchars($responseReasonCode);
				$returnresponse["responseReasonText"] = htmlspecialchars($responseReasonText);
				$returnresponse["approvalCode"]		= htmlspecialchars($approvalCode);
				$returnresponse["transId"]			= htmlspecialchars($transId);
			}
		}
		if ($flag) {
			return $returnresponse;
		} else {
			return false;
		}
	}
	
	function deleteprofile($profileid = NULL) {
		//build xml to post
		$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<deleteCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			$this->MerchantAuthenticationBlock().
			"<customerProfileId>" . $profileid . "</customerProfileId>".
			"</deleteCustomerProfileRequest>";
		$response = $this->send_xml_request($content);
		$parsedresponse = $this->parse_api_response($response);
		if ("Ok" == $parsedresponse->messages->resultCode) {
			return true;
		} else {
			return false;
		}
	}
	
	//function to send xml request to Api.
	//There is more than one way to send https requests in PHP.
	function send_xml_request($content) {
		return $this->send_request_via_fsockopen($this->apihost,$this->apipath,$content);
	}

	//function to send xml request via fsockopen
	//It is a good idea to check the http status code.
	function send_request_via_fsockopen($host,$path,$content) {
		$posturl = "ssl://" . $host;
		$header = "Host: $host\r\n";
		$header .= "User-Agent: PHP Script\r\n";
		$header .= "Content-Type: text/xml\r\n";
		$header .= "Content-Length: ".strlen($content)."\r\n";
		$header .= "Connection: close\r\n\r\n";
		$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
		$out = '';
		if (!$fp) {
			$body = false;
		} else {
			error_reporting(E_ERROR);
			fputs($fp, "POST $path  HTTP/1.1\r\n");
			fputs($fp, $header.$content);
			fwrite($fp, $out);
			$response = "";
			while (!feof($fp)) {
				$response = $response . fgets($fp, 128);
			}
			fclose($fp);
			error_reporting(E_ALL ^ E_NOTICE);
			
			$len = strlen($response);
			$bodypos = strpos($response, "\r\n\r\n");
			if ($bodypos <= 0) {
				$bodypos = strpos($response, "\n\n");
			}
			while ($bodypos < $len && $response[$bodypos] != '<') {
				$bodypos++;
			}
			$body = substr($response, $bodypos);
		}
		return $body;
	}

	//function to send xml request via curl
	function send_request_via_curl($host,$path,$content) {
		$posturl = "https://" . $host . $path;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return $response;
	}


	//function to parse the api response
	//The code uses SimpleXML. http://us.php.net/manual/en/book.simplexml.php 
	//There are also other ways to parse xml in PHP depending on the version and what is installed.
	function parse_api_response($content) {
		$parsedresponse = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOWARNING);
		if ("Ok" != $parsedresponse->messages->resultCode) {
			echo "The operation failed with the following errors:<br>";
			foreach ($parsedresponse->messages->message as $msg) {
				echo "[" . htmlspecialchars($msg->code) . "] " . htmlspecialchars($msg->text) . "<br>";
			}
			echo "<br>";
		}
		return $parsedresponse;
	}

	function MerchantAuthenticationBlock() {
		return
			"<merchantAuthentication>".
			"<name>" . $this->loginname . "</name>".
			"<transactionKey>" . $this->transactionkey . "</transactionKey>".
			"</merchantAuthentication>";
	}
}
?>
