<?php
		
		session_start();
		if ($_SESSION["admin"] != 1)	{
			header("location: logout.php");
		}
		
		
		$pagetitle = " ";
		$curpage = 'admin';
		require ("head.php");
		


		if ($_SERVER["REQUEST_METHOD"] == "POST")	{
			$newdate = strtotime($_POST["newdate"]);
			
			$fixedMonth = date("m", $newdate);
			$fixedDate = date("d", $newdate);
			$fixedYear = date("Y", $newdate);
			
			$fixNewDate = $fixedMonth."/".$fixedDate."/".$fixedYear;
			
			
			
			$newtime = $_POST["newtime"];
			
			$newslots = $_POST["newslots"];
			
			$newactivity = $_POST["newactivity"];
			$sql="SELECT * FROM activities WHERE id=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$newactivity]);
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			$activityName = $arr[0]["name"];
			
			$sql="INSERT INTO schedule SET activity_id=?, activity_name=?, activity_date=?, activity_time=?, slots=?, total_slots=?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$newactivity, $activityName, $fixNewDate, $newtime, $newslots, $newslots]);
			$stmt = null;	
?>			
			<div style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#05a546;padding:20px;margin:20px auto;border-radius:10px;">
				Schedule entry successfully added!
			</div>
<?php
		}
?>
		


		<div class="truckswrap">
			<h3 class="twhb"><span>Schedule</span></h3>
			<div class="twhbm"></div>
<?php


			$sql="SELECT * FROM schedule WHERE deleted=0";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			
?>
			<div style="overflow:auto;">
				<table cellspacing=3 cellpadding=5 border=1 style="border-collapse:collapse;font-size:.85rem;">
					<tr>
						<th>DATE</th>
						<th>TIME</th>
						<th>ACTIVITY</th>
						<th>TAKEN</th>
						<th>OPEN</th>
						<th>DEL</th>
					</tr>
	<?php
					foreach ($arr as $row)	{
						echo "<tr align=center id=\"row".$row["id"]."\">";	
						echo	"<td>".$row["activity_date"]."</td>";
						echo	"<td>".$row["activity_time"]."</td>";
						echo	"<td>".$row["activity_name"]."</td>";
						echo	"<td>".($row["total_slots"] - $row["slots"])."</td>";
						echo	"<td>".$row["slots"]."</td>";
						echo	"<td class=\"schedulDel\" data-sched=\"".$row["id"]."\" style=\"cursor:pointer;font-size:1.3rem; color:#ff0000;font-weight:bold;\">X</td>";
						echo "</tr>";
					}
					
	?>			

				</table>
				
				
				<h3>Add New Schedule Entry</h3>
				<form method=post action="admin.php" id="addSchedule">
					<table cellspacing=3 cellpadding=5 border=1 style="border-collapse:collapse;font-size:.85rem;margin-top:30px;">
						<tr>
							<td>DATE:<input type=date name="newdate" data-mini=true required></td>
							<td>TIME:<input type=time name="newtime" data-mini=true required></td>
							<td>ACTIVITY:
	<?php
								$sql="SELECT * FROM activities";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
								$stmt = null;
								echo "<select data-mini=true data-native-menu=true name=\"newactivity\" required>";
								echo	"<option value=\"\">Select Activity</option>";
								foreach ($arr2 as $row2)	{
									
									echo "<option value=\"".$row2["id"]."\">".$row2["name"]."</option>";
									
								}
								echo "</select>";
	?>
	
							</td>
							<td style="width:65px;">SLOTS:<input type="number" inputmode="numeric" name="newslots" data-mini=true required></td>
								
	
						
						</tr>
					
					</table>
					<div style="max-width:250px;">
						<input type=submit value="Save">
					</div>
				</form>
				
			</div>
		</div>
		

		
		
		
		
<?php


require("pagefoot.php");
