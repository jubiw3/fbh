<?php
	// Include the Twilio PHP library
	require '../Services/Twilio.php';

	// Twilio REST API version
	$version = "2010-04-01";

	// Set our Account SID and AuthToken
	$sid = 'SECRET';
	$token = 'SECRET';
	
	// A phone number you have previously validated with Twilio
	$phonenumber = 'SECRET';
	
	// Instantiate a new Twilio Rest Client
	$client = new Services_Twilio($sid, $token, $version);

	$phoneToCall =isset($_GET['phoneToCall']) ? $_GET['phoneToCall'] : 'SECRET';
	$fromwho = isset($_GET['fromwho']) ? $_GET['fromwho'] : 'Piotr';
	$city = isset($_GET['city']) ? $_GET['city'] : 'Krakow';
	$film = isset($_GET['film']) ? $_GET['film'] : 'Rocky';

	try {
		// Initiate a new outbound call
		$call = $client->account->calls->create(
			$phonenumber, // The number of the phone initiating the call
			$phoneToCall, // The number of the phone receiving call
			'http://dev.szeldon.pl/rest/callback.php?fromwho='.rawurlencode($fromwho).'&city='.rawurlencode($city).'&film='.rawurlencode($film) // The URL Twilio will request when the call is answered
		);
		echo 'Started call: ' . $call->sid;
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
