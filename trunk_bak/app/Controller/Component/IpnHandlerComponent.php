<?php
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');
require_once('includes/ipnlistener.php');

class IpnHandlerComponent extends Component {

	function makelog() {
		$listener = new IpnListener();

		// tell the IPN listener to use the PayPal test sandbox
		$listener->use_sandbox = true;

		// try to process the IPN POST
		try {
			$listener->requirePostMethod();
			$verified = $listener->processIpn();
		} catch (Exception $e) {
			error_log($e->getMessage());
			exit(0);
		}
		
		if ($verified) {
			$this->log($listener->getTextReport());
			mail('shivamsharma@zapbuild.com', 'Valid IPN', $listener->getTextReport());
			return ($listener->getTextReport());
		} else {
			return ($listener->getTextReport());
		}
	}
}

?>
