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
		
		
		
		
			$respMsg = "Hello $firstName, Unfortunately your appointment for $actName at $appTime on $appDate had to be cancelled.  Please visit the schduling app at (https://FitWithAdi.com) to reschedule or contact us directly.\nIf you used a package credit for this appointment, it will now be instantly credited back to your account.\nWe apologize for any inconvenience.";
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
			print_r($smsArray);
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
			
			echo $response;

