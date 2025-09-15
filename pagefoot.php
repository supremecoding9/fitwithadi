		</div> <!-- /content -->
		
		

	<div data-role="panel" id="mypanel" data-position="right" data-display="overlay" style="background:#333;">
		<div style="padding-top:100px;color:#fff; font-weight:bold;">
			COLUMNS
			
			<?php	
			$x=0;
			foreach ($columns["db"] as $col)	{		
				if (in_array($col, $usedCols))	{
					$checked = " checked";
				}else{
					$checked = "";
				}
				echo "<div style=\"max-width:200px;\">";
					echo "<label for=\"$col\">".$columns["names"][$x];
					echo "<input data-mini=true type=checkbox name=\"cols[]\" value=\"$col\" id=\"$col\"$checked onclick=\"cols(this,'$col');\">";
					echo "</label>";
				echo "</div>";
				$x++;
			}?>
		</div>
	</div>
		
		
		
	<?php #	<div style="margin-bottom:50px; font-size:.8rem;">Powered by <a target="_blank" href="https://supremecoding.com">Supreme Coding</a></div> ?>
		<div style="padding:10px;font-size:.75rem;">EasyBookMe by <a target="_blank" href="https://supremecoding.com">Supreme Coding</a></div>
		</div><!-- /page -->
		<script src="validate.js"></script>
		 </body>
		 </html>
<?php
