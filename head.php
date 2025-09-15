<?php
#####################################################################
$ip = $_SERVER['REMOTE_ADDR'];

###################################################################
session_start();
	
	
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Pragma: no-cache"); // HTTP/1.0
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header('Content-Type: text/html; charset=utf-8');
	require ("connection.php");


	$ip = $_SERVER['REMOTE_ADDR'];




#############################################
$darkMode = 0;
###############################################
	if (($curpage != 'login') && ($nolog != 1))	{
		if(!isset($_COOKIE["loggedin"]) || ($_SESSION["username"] == "")){
			header("location: login.php");
			exit;
		}
	}
if ($_SESSION["username"] != "")	{
	require("timezone.php");
}
	


?>

<!DOCTYPE html>
<html>

	<head>
	  <title>Adi Fitness</title>
	  <meta charset="utf-8" />


	  <link rel="stylesheet" href="css/themes/m5b.css?<?php echo time();?>" />

		

		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />




	  <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
	  <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" /> 
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


	  
	  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	  <script>$(document).bind('mobileinit',function(){
	   $.mobile.selectmenu.prototype.options.nativeMenu = false;
	   });
	
	
	   $(document).bind("mobileinit", function () {
			$.mobile.ajaxEnabled = false;
		});
		
		

	var aw = 0;
	var nw = 0;
	
	/////
	var curpage = '<?php echo $curpage;?>';
		
	</script>
	  <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>  




	  <?php 
	 	if ($_COOKIE["loggedin"] == "true")	{ require ("phpjs.php");}
	  ?>
<style type="text/css">
	
	
</style>
	</head>
	<body style="overflow:auto!important;background:#cccccc!important;">

		 <div id="page" data-role="page" class="<?php echo $curpage;?>" style="overflow-x:auto!important;">
			 
			 
			<div data-role="header" id="header" data-position="fixed" data-tap-toggle="false" style="z-index:99999;">

				<div id="logodiv" style="background-color:#121a42;">
		
						<a href="index.php"><img src="images/logo.png" style="max-width:100%;"></a>
			

				</div>

				<div class="cb"></div>
				
					

			</div><!-- /header -->


			<div data-role="content" class="ui-content" id="content" style="overflow-x:auto!important;">
<?php

if ($ip == "45.25.159.195")	{	
	print_r($_COOKIE);
	echo "<br><br><br>";
	print_r($_SESSION);
}

			if (($_COOKIE["loggedin"] == "true") && ($_SESSION["username"] != ""))	{?>
				<div style="text-align:center;" id="topnav">
					<a href="settings.php">Account</a>
					<a href="viewall.php" style="margin:0 30px;">Reservations</a>
					<a href="logout.php">Logout</a>
				</div>
<?php		}					
				

	if ($_SESSION["admin"] == 1)	{
?>
		<select id="adminnav" data-native-menu=true>
			<option value="">Navigate</option>
			<option value="admin.php">Schedule</option>
			<option value="admin_appointments.php">Appointments</option>
			<option value="admin_users.php">Users</option>
			<option value="admin_activities.php">Activities</option>
		</select>


		
<?php		
	}
?>
