<?php
	session_start();
	if ($_SESSION["admin"] != 1)	{
		header("location: logout.php");
	}else{
		require("connection.php");
		

		
		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			$curUser = $_POST["user"];
			$curAct = $_POST["act"];
			$curAmt = $_POST["amt"];
		
			$sql="SELECT * FROM users WHERE username=? LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$curUser]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			$curId = $arr[0]["id"];
			$packages = json_decode($arr[0]["packages"],true);
			

			
			$packages[$curAct] = $curAmt;
			
			$newPackages = json_encode($packages);
		
		
		
		
			$sql="UPDATE users SET packages=? WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$newPackages, $curId]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
		
		
			echo 1;
		
		}
	}
	
	