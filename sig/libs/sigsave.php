<?php

	require("/home/mytruckmate.com/public_html/app/connection.php");
	
	$img = $_POST["sig"];
	
	echo "<img src='$img'>";