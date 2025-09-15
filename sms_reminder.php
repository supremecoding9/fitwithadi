<?php 

require("connection.php");
$t=time();
for ($x=0; $x<2; $x++)	{
	if ($x === 0)	{
		$alertName = "sms_24";
		$alertSeconds = 86400;
	}else{
		$alertName = "sms_hour";
		$alertSeconds = 3600;
	}


	
	
	
	$sql="SELECT * FROM appointments WHERE ((timestamp-$alertSeconds)<=$t) AND notifications=1 AND $alertName=0 AND timestamp>0 AND cancelled='0'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;
	
	foreach ($arr as $row)	{
			$curid = $row["id"];
			$firstName = $row["first_name"];
			$userPhone = $row["phone"];
			$activityName = $row["activity_name"];
			$formdate = $row["app_date"];
			$formtime = $row["app_time"];
			$cancelId = $row["cancel_id"];
		
		
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
		
		
		
		
			$respMsg = "Hello $firstName, this is a reminder for your upcoming appointment:\n$activityName on $formdate at $formtime.\nYou may cancel your appointment by clicking on the following link:\n(https://FitWithAdi.com/cancel.php?cancel=$cancelId)";
			
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
			
			$sql="UPDATE appointments SET $alertName=1 WHERE id=$curid";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$stmt = null;
	
	}
}