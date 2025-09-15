<?php


	$postArray = [
		"number" => $userPhone,
		"country" => "US"
	];
	$jpost = json_encode($postArray);
	
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://sms.supremecoding.com/phone.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: XX0ceeCCSdaetiL8pOv7sg==',
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jpost);
	
	
	
	$intlPhone = curl_exec($ch);
	
	
	
	curl_close($ch);
	$waApiPhone = str_replace("+","",$intlPhone);




	$respMsg = "Hello $firstName, your time slot is confirmed for $activityName on $formdate at $formtime.\nYou may cancel your appointment by clicking on the following link:\n(https://FitWithAdi.com/cancel.php?cancel=$cancelId)";
	
	$smsArray = [
		"messages" => [
			[
				"channel" => "sms",
				"to" => strval($waApiPhone),
				"from" => "13212529924",
				"content" => $respMsg	
			]		
		]
	];
	
	$jMessage = json_encode($smsArray);
	




	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://platform.clickatell.com/v1/message');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jMessage);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type: application/json',
		'Accept: application/json',
		'Authorization: XX0ceeCCSdaetiL8pOv7sg==',
	]);
	

	
	$response = curl_exec($ch);
	
	curl_close($ch);
	
#	$responseArray = json_decode($response,true);
