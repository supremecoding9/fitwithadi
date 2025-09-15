<?php
session_start();
if ($_SESSION["username"] == "")	{
	header("location: logout.php");
}
$pagetitle = "View All";
$curpage = 'viewall';
require ("head.php");
require ("inputgen.php");
$curTime = time();


		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			$formdate = $_POST["formdate"];
			$formtime = $_POST["formtime"];
			$activity = $_POST["formact"];
			$schedId = $_POST["schedid"];
			$unixDate = (strtotime($formdate) + 86400);
			
			$slotArray = [$unixDate, $formdate, $formtime, $activity];

			
			$sql="SELECT * FROM users WHERE username=? LIMIT 1";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION["username"]]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			$tmpSlots = explode(",",$arr[0]["scheduled"]);
			$userPhone = $arr[0]["phone"];
			$userSms = $arr[0]["notifications"];
			$firstName = $arr[0]["first_name"];
			$packages = json_decode($arr[0]["packages"],true);
			
			$usedPackage = "No";
			if ($arr[0]["packages"] != "")	{
			
		
				if ((isset($packages[$activity])) && ($packages[$activity] > 0))	{
					$packages[$activity] = $packages[$activity] - 1;
					$usedPackage = "Yes";
			
				}
				
			}
			$updatedPackages = json_encode($packages);

			$curId = $arr[0]["id"];

			
			$sql="UPDATE users SET packages=? WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$updatedPackages, $curId]);
			$stmt = null;
			
			
			$sql="SELECT * FROM schedule WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$schedId]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			$activityName = $arr[0]["activity_name"];
			$remainingSlots = $arr[0]["slots"];

			
			$updatedSlots = $remainingSlots - 1;
			
			$sql="UPDATE schedule SET slots=? WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$updatedSlots, $schedId]);
			$stmt = null;
			
			$t = time();
			
			$date = new DateTime($formdate." ".$formtime, new DateTimeZone($timezoneName));
			$timestamp = $date->format('U');

			
			
			
			$sql="INSERT INTO appointments (username, activity_id, schedule_id, package, app_time, app_date, timestamp, notifications, first_name, phone, activity_name) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION["username"], $activity, $schedId, $usedPackage, $formtime, $formdate, $timestamp, $userSms, $firstName, $userPhone, $activityName]);
			$lastId = $pdo->lastInsertId();
			$stmt = null;
			
			$cancelId = $lastId.$t;
			$sql="UPDATE appointments SET cancel_id='$cancelId' WHERE id=$lastId";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$stmt = null;
			
			
			
			
			
			if ($userSms == 1)	{
				require("sms_confirmation.php");
			}
			
			
?>
			<div id="confirmed" style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#05a546;padding:20px;margin:20px auto;border-radius:10px;">
				Your time slot is confirmed for <?php echo $formtime." on ".$formdate." for the following activity:<br>".$activityName;?>
				<?php if ($usedPackage == "Yes"){echo "<br>1 visit has been deducted from your package balance.";}?>
			</div>
<?php

		}





?>

	<div class="truckswrap" id="viewalldiv">
		<h3 class="twhb"><span>Your Current Reservations</span></h3>
		<div class="twhbm"></div>
		<?php
		
		
		$sql="SELECT * FROM appointments WHERE expired=0 AND username=? AND cancelled=0 AND timestamp>$curTime";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION["username"]]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
	

		echo "<section id=\"validtimes\" class=\"flexSec\">";
		$v=0;
		if (count($arr) > 0)	{
			
			foreach ($arr as $row)	{
				$appId = $row["id"];

				$sql="SELECT * FROM schedule WHERE id=? LIMIT 1";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$row["schedule_id"]]);
				$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt = null;
				
				echo "<article style=\"position:relative;\" class=\"viewAllTimes\">";
				echo "<form method=post action=cancel.php>";
					echo "<input type=hidden name=\"slotid\" value=\"$appId\">";
					echo "<div class=\"cancelAppointment\">X</div>";

					echo "<span>Date:</span> ".$arr2[0]["activity_date"]."<br>";	
					echo "<span>Time:</span> ".$arr2[0]["activity_time"]."<br>";
					echo "<span>Activity:</span><br>".$arr2[0]["activity_name"];
				echo "</form>";
				
				echo "</article>";
				$v++;

			}
		}else{
			echo "You currently have nothing scheduled.";
		}
		
		echo "</section>";
	?>
	</div>	
	<div style="max-width:400px;margin-top:30px;">
		<input type=button onclick="window.location.href='index.php';" value="Make A New Reservation">
	</div>
	<script> var viewAllLen = <?php echo $v;?>;</script>
	
<?php
##############################################################################################################
?>	
	
	
	<div class="truckswrap" id="viewalldiv">
		<h3 class="twhb"><span>Past & Cancelled Reservations</span></h3>
		<div class="twhbm"></div>
		<?php
		
		
		$sql="SELECT * FROM appointments WHERE expired=0 AND username=? AND (timestamp<=$curTime OR cancelled>0)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION["username"]]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		
	
	
		echo "<section class=\"flexSec\">";

		if (count($arr) > 0)	{
			
			foreach ($arr as $row)	{
				$appId = $row["id"];
	
				$sql="SELECT * FROM schedule WHERE id=? LIMIT 1";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$row["schedule_id"]]);
				$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt = null;
				
				echo "<article style=\"position:relative;\" class=\"viewAllTimes\">";
				echo "<span>Date:</span> ".$arr2[0]["activity_date"]."<br>";	
				echo "<span>Time:</span> ".$arr2[0]["activity_time"]."<br>";
				echo "<span>Activity:</span><br>".$arr2[0]["activity_name"];
				if ($row["cancelled"] == 1)	{
					echo "<br>CANCELLED BY YOU";
				}elseif ($row["cancelled"] == 2)	{
					echo "<br>CANCELLED BY PROVIDER";	
				}
				
				echo "</article>";

	
			}
		}else{
			echo "You currently have nothing scheduled.";
		}
		
		echo "</section>";
	?>
	Past 30 days shown.
	</div>	
	
	
	
	
	
	
	
	
	<?php
	require("pagefoot.php");
