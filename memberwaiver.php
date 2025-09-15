<?php
$pagetitle = "Waiver";
$curpage = 'memberwaiver';
$noConn = 1;
require ("head.php");
#########################################	


	#require("timezone.php");
########################################
?>
			<style>

	#signature	{
		border:dotted 2px #333;
		border-radius:10px;
		position:static!important;

		background-color:#docrun;
	}
	#sigholder {
		padding-top:40px;
		z-index:999999;
		background-color:#ddd;
		width:100%;
		position:absolute;
		max-width:100%;
		left:-9999px;
		
		top: 50%;
		transform: translate(-50%, -50%);
	}
	#done, #clear, #crs	{display:none;}
	
	
	

	
	/* Drawing the 'gripper' for touch-enabled devices */ 
	html.touch #content {
		float:left;
		width:92%;
	}
	html.touch #scrollgrabber {
		float:right;
		width:4%;
		margin-right:2%;
		background-image:url(data:image/png;base64,iVBORw0KGgodocrunANSUhEUgdocrunAEdocrunAFCdocrunAACh79lDdocrunAAXNSR0IArs4c6QdocrunBJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwdocrunABJRU5ErkJggg==)
	}
	html.borderradius #scrollgrabber {
		border-radius: 1em;
	}
	#sigwrap, #finalsig	{

		padding:5px;
		margin:60px auto 20px auto;
	}
	

</style>


<script src="sig/libs/jSignature.min.js"></script>
<script>
	$(document).ready(function() {
		$('#signature').jSignature({
		'background-color': 'transparent',
		'decor-color': 'transparent',
		  width:'100%',
		  height:200
		});
	})

function docrun()	{
	var datapair = $('#signature').jSignature('getData', 'image'); 
	var i = new Image();
	i.src = "data:" + datapair[0] + "," + datapair[1];
	$(i).appendTo($("#finalsig")); // append the image (SVG) to DOM.
	$("#inpsig").val(i.src);
	
	$("#sig").val(i.src);
	//$("#done").hide();
	
}


function doneSign()	{
	if( $('#signature').jSignature('getData', 'native').length == 0) {
		alert('You have not signed the document. Please go back and sign.');
		return false;
	}else{

		$("#crs").show();
		docrun();
		/// ADD FOR SUBMIT
		
	}

}


</script>

<?php
$sql="SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;

$wName = $arr[0]["waiver_name"];
$street = $arr[0]["waiver_street"];
$city = $arr[0]["waiver_city"];
$state = $arr[0]["waiver_state"];
$zip = $arr[0]["waiver_zip"];
$ec1n = $arr[0]["waiver_ec1name"];
$ec1r = $arr[0]["waiver_ec1rel"];
$ec1t = $arr[0]["waiver_ec1phone"];
$ec2n = $arr[0]["waiver_ec2name"];
$ec2r = $arr[0]["waiver_ec2rel"];
$ec2t = $arr[0]["waiver_ec2phone"];
$ec3n = $arr[0]["waiver_ec3name"];
$ec3r = $arr[0]["waiver_ec3rel"];
$ec3t = $arr[0]["waiver_ec3phone"];
$minorName = $arr[0]["minor_name"];
$relationship = $arr[0]["minor_relation"];

?>



<form method="post" id="docsignform" action="signeddoc.php">
<div id="tw" class="truckswrap" style="background-color:#000;">
	<h3 class="twhb">Waiver & Release</h3>
	<div class="twhbm"></div>
	

	
	<div style="position:relative;background-color:#fff; padding: 30px;margin:0 auto;">
			<div style="margin-bottom:20px;height:70px;">
				<a target="_blank" href="Waiver2.pdf"><img src="images/pdficon.png" style="height:50px;position:relative;top:15px;"> View Waiver</a>
			</div>
			<div style="margin-bottom:40px;">
				Enter your information below, and it will be automatically added to the PDF waiver which you will be able to view/download once logged in.
			</div>

			<div style="max-width:400px;font-weight:bold;">
				Type your full name:
				<input type="text" name="printname" placeholder="Type your full name" value="<?php echo $wName;?>">
			</div>
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Address:
				<input type="text" name="street" placeholder="Street" value="<?php echo $street;?>">
				<input type="text" name="city" placeholder="City" value="<?php echo $city;?>">
				<select data-native-menu=true name="state"><?php require("state_select.php");?></select>
				<input type="text" name="zip" placeholder="Zip" value="<?php echo $zip;?>">
			</div>
			
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Today's Date:
				<input type="date" name="todaydate" placeholder="Date">
			</div>
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Emergency Contact 1:
				<input type="text" name="ec1name" placeholder="Name" value="<?php echo $ec1n;?>">
				<input type="text" name="ec1rel" placeholder="Relationship" value="<?php echo $ec1r;?>">
				<input type="text" name="ec1phone" placeholder="Telephone" value="<?php echo $ec1t;?>">
			</div>
			
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Emergency Contact 2:
				<input type="text" name="ec2name" placeholder="Name" value="<?php echo $ec2n;?>">
				<input type="text" name="ec2rel" placeholder="Relationship" value="<?php echo $ec2r;?>">
				<input type="text" name="ec2phone" placeholder="Telephone" value="<?php echo $ec2t;?>">
			</div>
			
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Emergency Contact 3:
				<input type="text" name="ec3name" placeholder="Name" value="<?php echo $ec3n;?>">
				<input type="text" name="ec3rel" placeholder="Relationship" value="<?php echo $ec3r;?>">
				<input type="text" name="ec3phone" placeholder="Telephone" value="<?php echo $ec3t;?>">
			</div>
			
			
			<div style="max-width:400px;font-weight:bold;margin-bottom:20px;">
				Minor Information:
				<input type="text" name="minorname" placeholder="Minor's Name" value="<?php echo $minorName;?>">
				<input type="text" name="relationship" placeholder="Relationship" value="<?php echo $relationship;?>">
			</div>
	

			
			
			
			
			<div id="sigwrap" style="background-color:#999;">
				<div style="padding:0 !important;margin:0 !important;width: 100% !important; height: 0 !important;margin-top:-1em !important;margin-bottom:1em !important;">
					<img src="images/signhere.gif" style="width:100px;">
				</div>
				<div style="background-color:#ddd;" id="signature"></div>
			</div>
			<div id="finalsig" style="display:none;"></div>
			

			
			<div style="width:100px;"><button type=button onclick="$('#signature').jSignature('reset');$('#finalsig').html('');">Clear</button></div>
			
	
	</div>
</div>
<div id="ctsholder">
	
	
		
		<input type=hidden name="signed" value="<?php echo $curdocid;?>">
		<input type=hidden name="ispid" value="<?php echo $ispid;?>">
		<input type=hidden name="inpsig" id="inpsig" value="">
		<input type=hidden name="member" value=1>
		<button type=submit style="background-color:rgb(66, 66, 162); color:#fff;" id="cts" onclick="doneSign();">Save Signature & Continue</button>
		
	
	
	<button style="margin-top:40px;" type=button onclick="window.location.href='index.php';">Close Without Signing</button>
	

</div>
</form>
<?php

require ("pagefoot.php");