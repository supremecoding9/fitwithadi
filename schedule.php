<?php
		session_start();
		
		$pagetitle = " ";
		$curpage = 'select_activity';
		require ("head.php");
		require ("inputgen.php");
		if ($_SESSION["activity"] != "")	{
			$activity = $_SESSION["activity"];
		}else{
			$activity = "";
		}
?>
		

			<script>
				window.addEventListener( "pageshow", function ( event ) {
				  var historyTraversal = event.persisted || 
										 ( typeof window.performance != "undefined" && 
											  window.performance.navigation.type === 2 );
				  if ( historyTraversal ) {
					// Handle page restore.
					window.location.reload();
				  }
				});
			</script>
			
			<?php
				if ((isset($_GET["waiver"]) && ($_GET["waiver"] == 1)))	{	?>
					<div style="margin:40px 20px;padding:20px; background-color:#190;color:#fff; border:dashed 2px #fff; font-weight:bold;text-align:center; border-radius:10px;">
						Thank you for signing the waiver.
					</div>
				<?php
				}
				?>
			
			
				<div class="truckswrap">
					<h3 class="twhb"><span>Select Activity</span></h3>
					<div class="twhbm"></div>
						<h1>Welcome to Adi's Fitness Scheduling!</h1>
						Please select an activity.

						

					
					
<?php	
							$sql="SELECT * FROM activities";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
							$stmt = null;
							echo "<div style=\"max-width:400px;\">";
							echo "<select data-native-menu=true id=\"activity\">";
							echo	"<option value=\"\">Select Activity</option>";
							foreach ($arr as $row)	{
								
								echo "<option value=\"".$row["id"]."\">".$row["name"]."</option>";
								
							}
							echo "</select>";
							echo "</div>";
?>

					



				</div>

<?php
	require("pagefoot.php");
