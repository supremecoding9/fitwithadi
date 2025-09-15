<?php
		
		session_start();
		if ($_SESSION["admin"] != 1)	{
			header("location: logout.php");
		}
		
		
		$pagetitle = " ";
		$curpage = 'admin_activities';
		require ("head.php");
		


		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			$newactivity = $_POST["newname"];
			$newslots = $_POST["newslots"];
			
			
			$sql="INSERT INTO activities SET name=?, max_session=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$newactivity, $newslots]);
			$stmt = null;	
?>			
			<div style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#05a546;padding:20px;margin:20px auto;border-radius:10px;">
				Activity successfully added!
			</div>
<?php
		}
?>
		


		<div class="truckswrap" style="padding-bottom:50px;">
			<h3 class="twhb"><span>Activities</span></h3>
			<div class="twhbm"></div>
<?php


			$sql="SELECT * FROM users ORDER BY username ASC";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$userArray = $arr;
			$stmt = null;
			
?>
			<div style="overflow:auto;">
				<table cellspacing=3 cellpadding=5 border=1 style="border-collapse:collapse;font-size:.85rem;">
					<tr>
						<th>USERNAME</th>
						<th>FIRST NAME</th>
						<th>LAST NAME</th>
						<th>PHONE</th>
						<th>EMAIL</th>
						<th>PACKAGES</th>
						<th>TEXT MSGS</th>
						<th>WAIVER</th>
						<th>WAIVER NAME</th>
						<th>STREET</th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>EMERGENCY CONTACT 1</th>
						<th>EMERGENCY RELATION 1</th>
						<th>EMERGENCY PHONE 1</th>
						<th>EMERGENCY CONTACT 2</th>
						<th>EMERGENCY RELATION 2</th>
						<th>EMERGENCY PHONE 2</th>
						<th>EMERGENCY CONTACT 3</th>
						<th>EMERGENCY RELATION 3</th>
						<th>EMERGENCY PHONE 3</th>
						<th>VIEW WAIVER</th>
						<th>DEL</th>
					</tr>
	<?php
					foreach ($userArray as $row)	{
						echo "<tr align=center id=\"row".$row["username"]."\">";	

						echo	"<td>".$row["username"]."</td>";
						echo	"<td>".$row["first_name"]."</td>";
						echo	"<td>".$row["last_name"]."</td>";
						echo	"<td>".$row["phone"]."</td>";
						echo	"<td>".$row["email"]."</td>";
						echo	"<script>creditArray['".$row["username"]."'] = new Array();</script>";
						

						$packages = json_decode($row["packages"],true);
						echo "<td style=\"min-width:250px;text-align:left; font-size:.85rem;\">";
						
						#foreach ($packages as $pack)	{
						
							$sql="SELECT * FROM activities ORDER BY name ASC";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$activityArray = $arr2;
							$stmt = null;
							foreach ($activityArray as $row2)	{
								if ($packages[$row2["id"]] == "")	{
									$packCredit = 0;
								}else{
									$packCredit = $packages[$row2["id"]];
								}
								echo "<script>creditArray['".$row["username"]."'][".$row2["id"]."] = ".$packCredit.";</script>";
								if (isset($packages[$row2["id"]]))	{
									$display = "display:block;";
								}else{
									$display = "display:none;";
								}
								
								echo "<div style=\"$display\" id=\"holder-".$row["username"]."-".$row2["id"]."\">";
									echo "<span style=\"font-weight:bold;\">".$row2["name"].":</span> <span id=\"cr-".$row["username"]."-".$row2["id"]."\">".$packCredit."</span>";
								echo "</div>";
									
								
								
							}
							
						#}
						
						echo "</td>";
						echo	"<td>".$row["notifications"]."</td>";
						echo	"<td>".$row["waiver"]."</td>";
						echo	"<td>".$row["waiver_name"]."</td>";
						echo	"<td>".$row["waiver_street"]."</td>";
						echo	"<td>".$row["waiver_city"]."</td>";
						echo	"<td>".$row["waiver_state"]."</td>";
						echo	"<td>".$row["waiver_zip"]."</td>";
						echo	"<td>".$row["waiver_ec1name"]."</td>";
						echo	"<td>".$row["waiver_ec1rel"]."</td>";
						echo	"<td>".$row["waiver_ec1phone"]."</td>";
						echo	"<td>".$row["waiver_ec2name"]."</td>";
						echo	"<td>".$row["waiver_ec2rel"]."</td>";
						echo	"<td>".$row["waiver_ec2phone"]."</td>";
						echo	"<td>".$row["waiver_ec3name"]."</td>";
						echo	"<td>".$row["waiver_ec3rel"]."</td>";
						echo	"<td>".$row["waiver_ec3phone"]."</td>";
						echo	"<td><a target=\"_blank\" href=\"pdfviewer.php?pdf=".$row["waiver_pdf"]."\"><img src=\"images/pdficon.png\" style=\"max-height:30px;\"></a></td>";

						echo	"<td class=\"userDel\" data-userid=\"".$row["username"]."\" style=\"cursor:pointer;font-size:1.3rem; color:#ff0000;font-weight:bold;\">X</td>";
						echo "</tr>";
					}
					
	?>			

				</table>
				<script> console.log(creditArray);</script>

			</div>
			<div style="font-size:.8rem; margin:15px 0;">
				*Packages will only show for users who have had or currently have an active package assigned to them.
			</div>
<?php
			echo "<div style=\"max-width:350px;margin-top:50px;border:dashed 2px #ccc;border-radius:10px; padding:10px;background-color:#B4F395;\">";
				echo "<h3 style=\"text-align:center;\">PACKAGE CREDITS</h3>";
				echo "<select data-native-menu=true data-mini=true id=\"creditUser\">";
				echo "<option value=\"\">Select User</option>";
					foreach($userArray as $row)	{				
						echo "<option value=\"".$row["username"]."\">".$row["username"]."</option>";
					}
				echo "</select>";
				
				
				
				echo "<select data-native-menu=true data-mini=true id=\"creditActivity\">";
				echo "<option value=\"\">Select Activity</option>";
					foreach($activityArray as $row)	{				
						echo "<option value=\"".$row["id"]."\">".$row["name"]."</option>";
					}
				echo "</select>";
				
				
				
				echo "<div style=\"margin:20px auto; text-align:center;width:150px;font-weight:bold;\">";
					echo "Current Credits:";	
					
					echo "<input id=\"creditValue\" type=number inputmode=numeric name=\"credits\" value=\"\" data-mini=true>";
					
					echo "<input type=button value=\"Update Credits\" id=\"saveCredits\">";
					
				echo "</div>";
				echo "<div style=\"height:40px;\">";
					echo "<div id=\"creditsUpdated\" style=\"display:none;background-color:green; color:#fff; padding:2px; border-radius:5px; font-size:.8rem; width:140px; text-align:center;\">CREDITS UPDATED!</div>";
				echo "</div>";
				
				
			echo "</div>";
?>	
		</div>
		

		
		
		
<?php


require("pagefoot.php");
