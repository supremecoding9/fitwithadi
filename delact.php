<?php
	session_start();
	
	if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_SESSION["admin"] == 1) && ($_SESSION["username"] != ""))	{
		require("connection.php");
		
		$delAct = $_POST["actid"];
		
		$sql="DELETE FROM activities WHERE id=?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$delAct]);
		$stmt = null;
		
		print_r($_POST);
		
	}else{
		exit;
	}
	