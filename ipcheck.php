<?php


#https://ip-api.com/docs/api:json

	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://ip-api.com/json/'.$ip);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

	
	$response = curl_exec($ch);
	
	curl_close($ch);
	

	
	$ipDetail = json_decode($response,true);
	
	$city = $ipDetail["city"];
	$country = $ipDetail["countryCode"];
	
	
	#echo $city;
	#echo $country;
	
?>