<?php

	session_start();
	
	if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION["username"] != ""))	{
		require("connection.php");
		
		$dateinfo = $_POST["dateinfo"];
		$sql="SELECT * FROM schedule WHERE activity_date=? AND deleted=0";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$dateinfo]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
		$timeSlots = [];
		
		$x=0;
		foreach ($arr as $row)	{
			
			$sql="SELECT * FROM appointments WHERE username=? AND expired=0 AND cancelled=0";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION["username"]]);
			$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			

			$curCustomers = explode(",",$row["customers"]);
			
			$exists = 0;
			foreach($arr2 as $row2)	{
				if (($row["activity_id"] == $row2["activity_id"]) && ($row["activity_date"] == $row2["app_date"]) && ($row["activity_time"] == $row2["app_time"]))	{
					$exists = 1;	
					break;
				}
			}
			
			
			$timeSlots[$x]["id"] = $row["id"];
			$timeSlots[$x]["activity_id"] = $row["activity_id"];
			$timeSlots[$x]["activity_name"] = $row["activity_name"];
			$timeSlots[$x]["activity_date"] = $row["activity_date"];
			$timeSlots[$x]["activity_time"] = $row["activity_time"];
			$timeSlots[$x]["slots"] = $row["slots"];
			$timeSlots[$x]["customers"] = $row["customers"];
			$timeSlots[$x]["exists"] = $exists;
				
			$x++;
		}
		
		echo json_encode($timeSlots,true);
		
		
		
	}