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
		


		<div class="truckswrap">
			<h3 class="twhb"><span>Activities</span></h3>
			<div class="twhbm"></div>
<?php


			$sql="SELECT * FROM activities";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt = null;
			
?>
			<div style="overflow:auto;">
				<table cellspacing=3 cellpadding=5 border=1 style="border-collapse:collapse;font-size:.85rem;">
					<tr>
						<th>NAME</th>
						<th>DEFAULT SLOTS</th>
						<th>DEL</th>
					</tr>
	<?php
					foreach ($arr as $row)	{
						echo "<tr align=center id=\"row".$row["id"]."\">";	

						echo	"<td>".$row["name"]."</td>";
						echo	"<td>".$row["max_session"]."</td>";
						echo	"<td class=\"actDel\" data-act=\"".$row["id"]."\" style=\"cursor:pointer;font-size:1.3rem; color:#ff0000;font-weight:bold;\">X</td>";
						echo "</tr>";
					}
					
	?>			

				</table>
				
				
				<h3>Add New Activity</h3>
				<form method=post action="admin_activities.php" id="addActivity">
					<table cellspacing=3 cellpadding=5 border=1 style="border-collapse:collapse;font-size:.85rem;margin-top:30px;">
						<tr>
							<td>NAME:<input type=text name="newname" data-mini=true required placeholder="Activity Name"></td>
							<td style="width:120px;">DEFAULT SLOTS:<input type=number inputmode=numeric name="newslots" data-mini=true required placeholder="Slots"></td>						
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
