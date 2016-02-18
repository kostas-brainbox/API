<?php
//config
	$merchant_id = '<YOUR-MERCHANT-ID>';
	$api_key = '<YOUR-API-KEY>';

//Get data submitted to this page
	$data = file_get_contents('php://input'); 
	//get the post json data to a log file
	data_log($json);
	
	//decode data into a json object
	$json = json_decode($data);

	
//Get Viva Verification for WebHook and display it
	$verificationkey = getVivaVerificationKeyForWebHook($merchant_id, $api_key, true);
	echo $verificationkey;

	
	
	
	

// Helper Functions
	function getVivaVerificationKeyForWebHook($merchant_id, $api_key, $demo=true){
		//Choose demo or not
		if($demo){
			$remote_url = 'http://demo.vivapayments.com/api/messages/config/token';
		} else { 
			$remote_url = 'https://www.vivapayments.com/api/messages/config/token'; 
		}
		
		// Create a stream
		$opts = array(
		  'http'=>array(
			'method'=>"GET",
			'header' => "Authorization: Basic " . base64_encode("$merchant_id:$api_key")                 
		  )
		);
		
		$context = stream_context_create($opts);

		// Open the file using the HTTP headers set above
		$file = file_get_contents($remote_url, false, $context);
		
		return $file;
	}

	function data_log($data){
		date_default_timezone_set('Europe/Athens');
		error_log("[".date('Y-m-d H:i:s')."] ".$msg."\n", 3, "data_log");
	}
?>
