<?php
/* 
	A domain Class to demonstrate RESTful web services
*/
Class Topup {
	private $httpVersion = "HTTP/1.1";

	protected $simArray = ['37250123123' => array('number' => '37250123123', 'blocked' => 'false', 'balance' => '72.00', 'curr' => 'USD'),
			'8132471896' => array('number' => '8132471896', 'blocked' => 'false', 'balance' => '32.00', 'curr' => 'EUR'),
			'02071838750' => array('number' => '02071838750', 'blocked' => 'true', 'balance' => '20.00', 'curr' => 'EUR'),
			'4155552671' => array('number' => '4155552671', 'blocked' => 'false', 'balance' => '-4.99', 'curr' => 'USD'),
			'8885739922' => array('number' => '8885739922', 'blocked' => 'false', 'balance' => '-10.00', 'curr' => 'USD')];

	public function getBalance($simNumber){
		//Check for number validity
		if ($simNumber == '' || !is_numeric($simNumber)) {
			$responseData = array('error' => true, 'data' => SYNTAX_ERROR);
		}
		else {
			if (!empty($this->simArray[$simNumber])) {//Output Array
				$responseData = array('error' => false, 'data' => $this->simArray[$simNumber]);
			}
			else {
				$responseData = array('error' => true, 'data' => CARD_NOT_FOUND);
			}

			//Random "Belarusian" code error - Setting forcefully to generate randomly
			if (rand(0, 1)) {
				$responseData = array('error' => true, 'data' => UNKNOWN_BELARUSIAN);
			}
		}
		$response = $this->encodeXml($responseData, 'getBalance');
		ob_clean();
		echo $response;
		exit;
	}
	
	public function addBalance($simNumber, $currency, $amount){
		//Check for number validity
		if ($simNumber == '' || $currency == '' || $amount == '') {
			$responseData = array('error' => true, 'data' => SYNTAX_ERROR);
		}
		if (!is_numeric($simNumber) || (!is_numeric($amount) && !is_float($amount) || !in_array(strtolower($currency), array('usd', 'eur')) ) ) {
			$responseData = array('error' => true, 'data' => SYNTAX_ERROR);
		}		
		else { 
			//Considering like customer balance updated successfully without an error
			$responseData = array('error' => false);

			//Random "Belarusian" code error - Setting forcefully to generate randomly
			if (rand(0, 1)) {
				$responseData = array('error' => true, 'data' => UNKNOWN_BELARUSIAN);
			}
		}
		$response = $this->encodeXml($responseData, 'addBalance');
		ob_clean();
		echo $response;	
	}

	public function encodeXml($response, $action = '') {
		// creating object of SimpleXMLElement
		switch ($action) {
			case 'getBalance':
				$xml = new SimpleXMLElement('<?xml version="1.0"?><results></results>');				
				if ($response['error']) { //Handle Error
					$xml->addChild('type', ERROR_TEXT);
					$xml->addChild('text', $response['data']);
				}
				else { 	//Success
					$card = $xml->addChild('card');
					foreach($response['data'] as $key=>$value) {
						$card->addChild($key, $value);
					}
				}
				break;
			
			case 'addBalance':
				$xml = new SimpleXMLElement('<?xml version="1.0"?><addBalance></addBalance>');
				if ($response['error']) { //Handle Error
					$xml->addChild('type', ERROR_TEXT);
					$xml->addChild('text', $response['data']);
				}
				else { 	//Success
					$xml->addChild('result', OK_TEXT);
				}
				break;
			default:
				$xml = new SimpleXMLElement('<?xml version="1.0"?><results></results>');
				if ($response['error']) { //Handle Error
					$xml->addChild('type', ERROR_TEXT);
					$xml->addChild('text', $response['data']);
				}
				else { 	//Success
					$xml->addChild('result', OK_TEXT);
				}
				break;	
		}
		return $xml->asXML();
	}
}
?>