<?php 
//Http authentication check
if (!isset($_SERVER['PHP_AUTH_USER']) || ($_SERVER['PHP_AUTH_USER'] !='codeuser' ||  $_SERVER['PHP_AUTH_PW'] != 'codepass')) {  
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}
//

// http_response_code(404); exit; //Uncomment this line in order to check 404, 500 OR 408 API crash issue behaviour on topup functionality
require_once('constants.php');

if(!isset($_GET["action"]) || (isset($_GET['action']) && !in_array($_GET['action'], array('addBalance', 'getBalance')) )) 
{
	$requestContentType = $_SERVER['HTTP_ACCEPT'];
	header("HTTP/1.1 200 OK" );		
	header("Content-Type:". $requestContentType);

	$xml = new SimpleXMLElement('<?xml version="1.0"?><results></results>');
	$xml->addChild('type', ERROR_TEXT);
	$xml->addChild('text', UNKNOWN_ACTION);
	$response = $xml->asXML();

	ob_clean();
	echo $response;
	exit;
}

$action = $_GET["action"];

require_once("Topup.php");
/*
controls the RESTful services
URL mapping
*/
switch($action) {
	case "getBalance":
		$topup = new Topup();
		$result = $topup->getBalance($_GET['number']);
		break;

	case "addBalance":
		$topup = new Topup();
		$result = $topup->addBalance($_GET['number'], $_GET['currency'], $_GET['amount']);
		break;
}
