<?php
session_start();

$pagetitle = " ";
$curpage = 'select_activity';
require ("head.php");



?>

<div class="truckswrap">
	<h3 class="twhb"><span>Your Appointment is Cancelled</span></h3>
	<div class="twhbm"></div>
	
	<div id="confirmed" style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#ff0000;padding:20px;margin:20px auto;border-radius:10px;">
		Your appointment has been cancelled.
	</div>
</div>
<div style="margin-top:30px; max-width:400px;">
	<input type=button onclick="window.location.href='viewall.php';" value="View My Reservations">
</div>

<?php

require("pagefoot.php");
