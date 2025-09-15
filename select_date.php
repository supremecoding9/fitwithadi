<?php
		session_start();
		
		$pagetitle = " ";
		$curpage = 'index';
		require ("head.php");
		require ("inputgen.php");
		
		$activity = $_GET["a"];
		$_SESSION["activity"] = $activity;
		
		
		$sql="SELECT DISTINCT activity_date FROM schedule WHERE activity_id=? AND deleted=0";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$activity]);
		$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
		$acLen = count($arr);
		$x=0;
		echo "<script>var highlightedDates = [";
		foreach ($arr as $row)	{
			echo "\"".$row["activity_date"]."\"";
			if ($x < ($acLen - 1))	{
				echo ", ";
			}
			$x++;	
		}
		echo "];</script>";
?>
		<style>
			 .highlighted, .highlighted a {
				 
				 background: #3C3CEE!important;
				 color: #fff!important;
			 }
			 .highlighted a .ui-state-active	{
				 background: #ee3cd6!important;
				  color: #fff!important;
			}
		</style>

		
		
		
	
				<div class="truckswrap">
					<h3 class="twhb"><span>Personal Info</span></h3>
					<div class="twhbm"></div>
					
					<form id="slotform" method=post action="viewall.php">
						<input type=hidden name="formact" id="formact" value="<?php echo $activity;?>">
						<input type=hidden name="formdate" id="formdate" value="">
						<input type=hidden name="formtime" id="formtime" value="">
						<input type=hidden name="schedid" id="schedid" value="">
						<div istyle="float:left;width:315px;margin-bottom:30px;">
							<div id="datepicker"></div>
							<div style="margin-bottom:20px;color:#3C3CEE;">Available dates are shown in blue.</div>
						</div>
						<div style="float:left; width:315px;">
				    		<section id="validtimes" class="flexSec" style="width:100%;"></section>
							<div id="legend" style="display:none;margin-top:50px;text-align:center;">
								<div style="display:inline-block;margin-bottom:10px; text-align:center;background-color: #f1dc1c;border-radius:10px; width:90px; font-size:.8rem; padding:5px;">Reserved<br>by you.</div>
								<div style="display:inline-block;margin-bottom:10px; text-align:center;background-color: #00DE0F;border-radius:10px; width:90px; font-size:.8rem; padding:5px;">Space<br>Available</div>
								<div style="display:inline-block;margin-bottom:10px; text-align:center;background-color: #eb5149;border-radius:10px; width:90px; font-size:.8rem; padding:5px;">Full<br>No Room Left.</div>
							</div>
						</div>
						<div style="clear:both;"></div>
						
					</form>



<?php
					
					$sql="SELECT * FROM users WHERE username=? LIMIT 1";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_SESSION["username"]]);
					$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
					$stmt = null;
					
					if ($arr[0]["packages"] != "")	{
						$packages = json_decode($arr[0]["packages"],true);
						if ((isset($packages[$activity])) && ($packages[$activity] > 0))	{
							echo "You currently have ".$packages[$activity]." visit(s) left in your package.";
						}
					}


?>

				</div>
				
				
				<div class="form-group" style="max-width:400px;margin:30px auto 30px auto;">
					<button type=button onclick="window.location.href='index.php';"  style="margin-top:15px;">Return To Main Page</button>
				</div>
				
<?php
	require("pagefoot.php");
