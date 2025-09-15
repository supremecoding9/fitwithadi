<?php

	$c=0;
	function makeInput($inpType, $inpName, $inpId, $inpVal, $inpPlaceholder, $required, $selText, $extra, $pagetype)	{

		global $c;
		global $x;
		global $arr;

		if ($pagetype == "listpage")	{
			$datamini = "true";
			$noBotMargin = "style=\"margin-bottom:10px;\"";
		}else{
			$datamini = "false";
			$noBotMargin = "";
		}
		
		$inpValParsed = $inpPlaceholderParsed = $inpIdParsed = "";
		if ($inpVal != "")	{
			$inpValParsed = "value=\"$inpVal\"";
		}
		$inpValParsed = "value=\"".$arr[0][$inpName]."\"";
			
		if ($inpPlaceholder != "")	{
			$inpPlaceholderParsed = "placeholder=\"$inpPlaceholder\"";
		}
		
		if ($inpId != "")	{
			$inpIdParsed = "id=\"$inpId\"";
		}
		
		if ($pagetype == "toptext")	{
			$rel = "style=\"position:relative; min-width:100px;\"";
		}

		if (($inpType == "text") || ($inpType == "date") || ($inpType == "email"))	{
			echo "<article class=\"autoInp\" $noBotMargin $rel>";
				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}
				if ($pagetype == "toptext")	{
					echo "<span style=\"position:absolute;top:-4px;font-weight:bold; font-size:.8rem;\">$inpPlaceholder</span>";
				}
				echo "<input data-mini=$datamini type=\"$inpType\" name=\"$inpName\" $inpIdParsed $inpValParsed $inpPlaceholderParsed $required $extra>";
			echo "</article>";
		}
		
		if ($inpType == "checkbox")	{
			echo "<article class=\"autoInp\" style=\"margin-bottom:0;width:200px;\">";
				echo "<label for=\"$inpId-$c\">";
				echo "\n";
				echo "<input data-mini=$datamini  type=\"checkbox\" name=\"$inpName\" id=\"$inpId\" value=\"1\" $required>$inpPlaceholder";
				echo "\n";
				echo "</label>";
			echo "</article>";
		}
		
		
		
		if ($inpType == "select")	{
			
			echo "<article class=\"autoInp\" $noBotMargin>";
				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}
				echo "<select data-mini=$datamini  name=\"$inpName\" $inpIdParsed>";
				echo "<option value=\"\">Select $inpPlaceholder</option>";
				foreach ($selText as $val)	{
					$val = preg_replace( "/\r|\n/", "", $val);
					$fixName = preg_replace( "/\r|\n/", "", $arr[0][$inpName]);
					if ($val == $fixName)	{
						$selected = "selected";
					}else{
						$selected = "";
					}

					echo "<option value=\"".$val."\" $selected>$val</option>";
				}
				echo "</select>";
			echo "</article>";
		}
		
		
		if ($inpType == "radio")	{
			echo "<article class=\"autoInp\" $noBotMargin>";
				echo "\n";
				echo "$inpPlaceholder<br>";
				echo "<fieldset data-role=\"controlgroup\" data-type=\"horizontal\">";
					echo "\n";
					$x=0;
					foreach ($selText as $val)	{
						echo "<label for=\"$inpId-$x\">$val</label>";
						if ($val == $arr[0][$inpName])	{
							$selected = "checked";
						}else{
							$selected = "";
						}
						echo "<input type=\"radio\" class=\"$inpId\" name=\"$inpName\" id=\"$inpId-$x\" value=\"$val\" $required $selected>";
						$x++;
					}
				echo "</fieldset>";
			echo "</article>";
		}
		
		
		if ($inpType == "textarea")	{
			echo "<article class=\"autoInp\" $noBotMargin>";
				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}
				echo "<textarea name=\"$inpName\"></textarea>";
			echo "</article>";
		}
		
		
		
		###################################################
		
		if ($inpType == "ssn")	{
			echo "<article class=\"autoInp\" $noBotMargin>";

				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}
				#echo "<input type=\"$inpType\" name=\"$inpName\" $inpIdParsed $inpValParsed $inpPlaceholderParsed $required>";
				
				
				echo "<input id=\"ssn\" name=\"ssn\" onkeyup=\"testSSN(this);\" placeholder=\"XXX-XX-XXXX\" $inpValParsed>";

			echo "</article>";
		}
		######################################################
	
		

		if (($inpType == "tel") || ($inpType == "number"))	{
			echo "<article class=\"autoInp\" $noBotMargin>";
				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}
				echo "<input data-mini=$datamini  type=\"$inpType\" inputmode=\"numeric\" name=\"$inpName\" $inpIdParsed $inpValParsed $inpPlaceholderParsed $required $extra>";
			echo "</article>";
		}
		

		
		if ($inpType == "usstates")	{
			
			echo "<article class=\"autoInp\" $noBotMargin>";
				if ($pagetype == "editor")	{
					echo "$inpPlaceholder ";
				}

				echo "<select data-mini=$datamini  data-native-menu=true name=\"$inpName\" $inpIdParsed>";
				echo "<option value=\"\">Select State</option>";
?>
						
				<option value="">Select State</option>
				<option value="AL"<?php if ($arr[0][$inpName] == "AL"){echo " selected";}?>>Alabama</option>
				<option value="AK"<?php if ($arr[0][$inpName] == "Ak"){echo " selected";}?>>Alaska</option>
				<option value="AZ"<?php if ($arr[0][$inpName] == "az"){echo " selected";}?>>Arizona</option>
				<option value="AR"<?php if ($arr[0][$inpName] == "Ar"){echo " selected";}?>>Arkansas</option>
				<option value="CA"<?php if ($arr[0][$inpName] == "CA"){echo " selected";}?>>California</option>
				<option value="CO"<?php if ($arr[0][$inpName] == "CO"){echo " selected";}?>>Colorado</option>
				<option value="CT"<?php if ($arr[0][$inpName] == "CT"){echo " selected";}?>>Connecticut</option>
				<option value="DE"<?php if ($arr[0][$inpName] == "DE"){echo " selected";}?>>Delaware</option>
				<option value="DC"<?php if ($arr[0][$inpName] == "DC"){echo " selected";}?>>District Of Columbia</option>
				<option value="FL"<?php if ($arr[0][$inpName] == "FL"){echo " selected";}?>>Florida</option>
				<option value="GA"<?php if ($arr[0][$inpName] == "GA"){echo " selected";}?>>Georgia</option>
				<option value="HI"<?php if ($arr[0][$inpName] == "HI"){echo " selected";}?>>Hawaii</option>
				<option value="ID"<?php if ($arr[0][$inpName] == "ID"){echo " selected";}?>>Idaho</option>
				<option value="IL"<?php if ($arr[0][$inpName] == "IL"){echo " selected";}?>>Illinois</option>
				<option value="IN"<?php if ($arr[0][$inpName] == "IN"){echo " selected";}?>>Indiana</option>
				<option value="IA"<?php if ($arr[0][$inpName] == "IA"){echo " selected";}?>>Iowa</option>
				<option value="KS"<?php if ($arr[0][$inpName] == "KS"){echo " selected";}?>>Kansas</option>
				<option value="KY"<?php if ($arr[0][$inpName] == "KY"){echo " selected";}?>>Kentucky</option>
				<option value="LA"<?php if ($arr[0][$inpName] == "LA"){echo " selected";}?>>Louisiana</option>
				<option value="ME"<?php if ($arr[0][$inpName] == "ME"){echo " selected";}?>>Maine</option>
				<option value="MD"<?php if ($arr[0][$inpName] == "MD"){echo " selected";}?>>Maryland</option>
				<option value="MA"<?php if ($arr[0][$inpName] == "MA"){echo " selected";}?>>Massachusetts</option>
				<option value="MI"<?php if ($arr[0][$inpName] == "MI"){echo " selected";}?>>Michigan</option>
				<option value="MN"<?php if ($arr[0][$inpName] == "MN"){echo " selected";}?>>Minnesota</option>
				<option value="MS"<?php if ($arr[0][$inpName] == "MS"){echo " selected";}?>>Mississippi</option>
				<option value="MO"<?php if ($arr[0][$inpName] == "MO"){echo " selected";}?>>Missouri</option>
				<option value="MT"<?php if ($arr[0][$inpName] == "MT"){echo " selected";}?>>Montana</option>
				<option value="NE"<?php if ($arr[0][$inpName] == "NE"){echo " selected";}?>>Nebraska</option>
				<option value="NV"<?php if ($arr[0][$inpName] == "NV"){echo " selected";}?>>Nevada</option>
				<option value="NH"<?php if ($arr[0][$inpName] == "NH"){echo " selected";}?>>New Hampshire</option>
				<option value="NJ"<?php if ($arr[0][$inpName] == "NJ"){echo " selected";}?>>New Jersey</option>
				<option value="NM"<?php if ($arr[0][$inpName] == "NM"){echo " selected";}?>>New Mexico</option>
				<option value="NY"<?php if ($arr[0][$inpName] == "NY"){echo " selected";}?>>New York</option>
				<option value="NC"<?php if ($arr[0][$inpName] == "NC"){echo " selected";}?>>North Carolina</option>
				<option value="ND"<?php if ($arr[0][$inpName] == "ND"){echo " selected";}?>>North Dakota</option>
				<option value="OH"<?php if ($arr[0][$inpName] == "OH"){echo " selected";}?>>Ohio</option>
				<option value="OK"<?php if ($arr[0][$inpName] == "OK"){echo " selected";}?>>Oklahoma</option>
				<option value="OR"<?php if ($arr[0][$inpName] == "OR"){echo " selected";}?>>Oregon</option>
				<option value="PA"<?php if ($arr[0][$inpName] == "PA"){echo " selected";}?>>Pennsylvania</option>
				<option value="RI"<?php if ($arr[0][$inpName] == "RI"){echo " selected";}?>>Rhode Island</option>
				<option value="SC"<?php if ($arr[0][$inpName] == "SC"){echo " selected";}?>>South Carolina</option>
				<option value="SD"<?php if ($arr[0][$inpName] == "SD"){echo " selected";}?>>South Dakota</option>
				<option value="TN"<?php if ($arr[0][$inpName] == "TN"){echo " selected";}?>>Tennessee</option>
				<option value="TX"<?php if ($arr[0][$inpName] == "TX"){echo " selected";}?>>Texas</option>
				<option value="UT"<?php if ($arr[0][$inpName] == "UT"){echo " selected";}?>>Utah</option>
				<option value="VT"<?php if ($arr[0][$inpName] == "VT"){echo " selected";}?>>Vermont</option>
				<option value="VA"<?php if ($arr[0][$inpName] == "VA"){echo " selected";}?>>Virginia</option>
				<option value="WA"<?php if ($arr[0][$inpName] == "WA"){echo " selected";}?>>Washington</option>
				<option value="WV"<?php if ($arr[0][$inpName] == "WV"){echo " selected";}?>>West Virginia</option>
				<option value="WI"<?php if ($arr[0][$inpName] == "WI"){echo " selected";}?>>Wisconsin</option>
				<option value="WY"<?php if ($arr[0][$inpName] == "WY"){echo " selected";}?>>Wyoming</option>
			
<?php
			echo "</select>";
			echo "</article>";
		}		
		
		
		
		
		
		
		
		
		
		

		echo "\n\n";	
		$req = "";	
		$c++;
	}