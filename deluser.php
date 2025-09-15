<?php
	session_start();
	
	if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION["admin"] == 1) && ($_SESSION["username"] != ""))	{
		
		require("connection.php");
		
		$delid = $_POST["delid"];
		
		
		$sql="SELECT * FROM appointments WHERE username=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
		foreach ($arr as $row)	{
			$actId = $row["activity_id"];
			$schedId = $row["schedule_id"];	
			$sql="UPDATE schedule SET slots=slots+1 WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$schedId]);
			$stmt = null;
		}
		
		
		
		
		
		
		$sql="DELETE FROM appointments WHERE username=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$stmt = null;
		
		
		

		$sql="DELETE FROM users WHERE username=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delid]);
		$stmt = null;
		
		echo 1;

	}
	
	