<?php
	
	session_start();
	if ((($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION["username"] != "")) || (($_SERVER["REQUEST_METHOD"] == "GET") && (isset($_GET["cancel"]))))	{

		require("connection.php");
		
		
		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			$slotid = $_POST["slotid"];
		}elseif ($_SERVER["REQUEST_METHOD"] == "GET")	{
			$sql="SELECT * FROM appointments WHERE cancel_id=?";######POST ONLY
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_GET["cancel"]]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			
			$slotid = $arr[0]["id"];
			$_SESSION["username"] = $arr[0]["username"];
			
			if ((isset($_GET["admin"])) && ($_GET["admin"] == 1))	{
				
				$adminCancel = 1;
				$userPhone = $arr[0]["phone"];
				$actName = $arr[0]["activity_name"];
				$appTime = $arr[0]["app_time"];
				$appDate = $arr[0]["app_date"];
				require("sms_admin_cancel.php");
			}else{
				$adminCancel = 0;
			}
			
		}
		$likeUser = "%".$_SESSION["username"]."%";
		
		
		$sql="SELECT * FROM appointments WHERE id=?";######POST ONLY
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$slotid]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		$scheduleId = $arr[0]["schedule_id"];
		$activityId = $arr[0]["activity_id"];
		$usedPackage = $arr[0]["package"];
		
		$sql="SELECT * FROM schedule WHERE id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$scheduleId]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
	
		$curSlots = $arr[0]["slots"];
		$updatedSlots = $curSlots + 1;
	
		$sql="UPDATE schedule SET slots=? WHERE id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$updatedSlots, $scheduleId]);
		$stmt = null;
	

		
		
		$sql="UPDATE appointments SET cancelled=1 WHERE username=? AND id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION["username"],$slotid]);
		$stmt = null;
		
		
		$sql="SELECT * FROM users WHERE username=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION["username"]]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		$userid = $arr[0]["id"];
		$packages = json_decode($arr[0]["packages"],true);


		if ($usedPackage == "Yes")	{
			if (isset($packages[$activityId]))	{

			
				$packages[$activityId] = $packages[$activityId] + 1;
			}
			
			
			$updatedPackages = json_encode($packages);
			$sql="UPDATE users SET packages='$updatedPackages' WHERE username=? AND id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION["username"], $userid]);
			$stmt = null;
		}
		
	
		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			header("location: viewall.php");
		}
		if ($_SERVER["REQUEST_METHOD"] == "GET")	{
			if ($adminCancel === 0)	{
				header("location: cancelled.php");
			}
			exit;
		}

	}
	

	