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


			$sql="SELECT * FROM appointments WHERE cancelled=0";
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
						<th>FIRST NAME</th>
						<th>PHONE</th>
						<th>ACTIVITY</th>
						<th>PACKAGE</th>
						<th>DEL</th>
					</tr>
	<?php
					foreach ($arr as $row)	{
						echo "<tr align=center id=\"row".$row["cancel_id"]."\">";	

						echo	"<td>".$row["app_date"]."</td>";
						echo	"<td>".$row["app_time"]."</td>";
						echo	"<td>".$row["first_name"]."</td>";
						echo	"<td>".$row["phone"]."</td>";
						echo	"<td>".$row["activity_name"]."</td>";
						echo	"<td>".$row["package"]."</td>";
						
						
						
						

						echo	"<td class=\"appDel\" data-cancelid=\"".$row["cancel_id"]."\" style=\"cursor:pointer;font-size:1.3rem; color:#ff0000;font-weight:bold;\">X</td>";
						echo "</tr>";
					}
					
	?>			

				</table>
				

				
			</div>
		</div>
		

		
		
		
		
<?php


require("pagefoot.php");
