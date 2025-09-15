<?php



$stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
$stmt->execute([$_SESSION["username"]]);
$arr5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;
$settingsTimezone = $arr5[0]["timezone"];

switch ($settingsTimezone)	{
	case "1": $timezoneName = "America/New_York"; break;
	case "2": $timezoneName = "America/Chicago"; break;
	case "3": $timezoneName = "America/Denver"; break;
	case "4": $timezoneName = "America/Phoenix"; break;
	case "5": $timezoneName = "America/Los_Angeles"; break;
	
	default: $timezoneName = "America/New_York";
}
	
$datetime = new DateTime();
$timezone = new DateTimeZone($timezoneName);	
$datetime->setTimezone($timezone);

$localTime = $datetime->format('Y-m-d').'T'.$datetime->format('H:i:s');

$localFormatedDate = $datetime->format('M-j-Y');

$localTimestamp = strtotime($localTime);

date_default_timezone_set($timezoneName);