<?php
/*------------------------------------------------------------------------
# mod_donatemeter - donation meter
# ------------------------------------------------------------------------
# author    laotracking individual enterprise, laoapps.com07.
# copyright Copyright (C) 2010 laoapps.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.laoapps.com
# Technical Support:  touya.ra@gmail.com
-------------------------------------------------------------------*/
 /*++++++++++++++++++FUNCTIONS+++++++++++++++++++++++++++*/
 
//$environment = 'live';	// or 'beta-sandbox' or 'live'
 
/**
 * Send HTTP POST Request
 *
 * @param	string	The API method name
 * @param	string	The POST Message fields in &name=value pair format
 * @return	array	Parsed HTTP Response body
 */
 // no direct access
 defined('_JEXEC') or die('Restricted access');
function PPHttpPost($methodName_, $nvpStr_,$environment='live',$API_UserName,$API_Password,$API_Signature) {
 
 //DEMO 
/* $API_UserName = urlencode('yours');
	$API_Password = urlencode('yours');
	$API_Signature = urlencode('yours');*/
 //END DEMO
	$API_Endpoint = "https://api-3t.paypal.com/nvp";

	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');
 
	// setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
 
	// turning off the server and peer verification(TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
 
	// NVPRequest for submitting to server
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
 
	// setting the nvpreq as POST FIELD to curl
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
 
	// getting response from server
	$httpResponse = curl_exec($ch);
 
	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}
 
	// Extract the RefundTransaction response details
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
function percent2Color($value,$brightness = 255, $max = 100,$min = 0, $thirdColorHex = '00')
{       
    // Calculate first and second color (Inverse relationship)
    $first = (1-($value/$max))*$brightness;
    $second = ($value/$max)*$brightness; 
    // Find the influence of the middle color (yellow if 1st and 2nd are red and green)
    $diff = abs($first-$second);    
    $influence = ($brightness-$diff)/2;     
    $first = intval($first + $influence);
    $second = intval($second + $influence); 
    // Convert to HEX, format and return
    $firstHex = str_pad(dechex($first),2,0,STR_PAD_LEFT);     
    $secondHex = str_pad(dechex($second),2,0,STR_PAD_LEFT);  
    //return $firstHex . $secondHex . ''.$thirdColor ;  
    // alternatives:
    // return $thirdColorHex . $firstHex . $secondHex; 
     //return $firstHex . $thirdColorHex . $secondHex;
     return $secondHex.$firstHex. $thirdColorHex  ; 
}
?>