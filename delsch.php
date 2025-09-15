<?php
session_start();
	
	if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION["admin"] == 1) && ($_SESSION["username"] != ""))	{
		
		require("connection.php");
		
		$delid = $_POST["schid"];
		
		$sql="UPDATE schedule SET deleted=1 WHERE id=?";
		#$sql="DELETE FROM schedule WHERE id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
		$sql="SELECT * FROM appointments WHERE schedule_id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
		foreach ($arr as $row)	{
			
			$sms = $row["notifications"];	
			if ($sms == 1)	{
				$userPhone = $row["phone"];	
				$appTime = $row["app_time"];
				$appDate = $row["app_date"];
				$actName = $row["activity_name"];
				$usedPackage = $row["package"];
				$userNm = $row["username"];
				$actId = $row["activity_id"];
				
				if ($usedPackage == "Yes")	{
					$sql="SELECT * FROM users WHERE username=?";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$userNm]);
					$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$stmt = null;
					$packages = json_decode($row["packages"]);
					$packages[$actId] = $packages[$actId] + 1;
					
					$newPackages = json_encode($packages);
					
					$sql="UPDATE users SET packages='$newPackages' WHERE username='$userNm'";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					$stmt = null;
				}
				
				
				require("sms_admin_cancel.php");
			}
		}
		$sql="UPDATE appointments SET cancelled=2 WHERE schedule_id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$stmt = null;
		

		
	}else{
		exit;
	}