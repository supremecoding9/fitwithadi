<?php



###################################################
	
######DATE CONVERTERS#####
function dptosq($dp)	{
	$dpdate = strtotime($dp);
	$sqldt = date("Y-m-d", $dpdate);
	return $sqldt;
}
function sqtodp($sq)	{
	if ($sq == "0000-00-00")	{
		return "00/00/0000";
	}elseif (!isset($sq)){
		return "";
	}else{
		$dpdate = date("m/d/Y", strtotime($sq));
		return $dpdate;
	}
}
#########################
#######DAY DIFF CALC#####
function dateDiffInDays($date1, $date2) 
{
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);
      
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
}



##########WHEEL IDENTIFIERS#######

function wheels($w,$a)
{
	switch ($w)	{
		case 1:
		$tireName = "Driver Front";
		$wheel = "Dr-Fr";
		$msql = "tire_d_f";
		$ids = "tire-d-f";
		$shorts = "tdf";
		$tiny = "DF";
		$lowertiny = "df";
		$alt = "df";
		$shortName = "Dr Front";
		$invBuilder = "df";
		break;
		
		case 2:
		$tireName = "Passenger Front";
		$wheel = "Ps-Fr";
		$msql = "tire_p_f";
		$ids = "tire-p-f";
		$shorts = "tpf";
		$tiny = "PF";
		$lowertiny = "pf";
		$alt = "pf";
		$shortName = "Pass Front";
		$invBuilder = "pf";
		break;

		case 3:
		$tireName = "Driver Rear Outer/Single";
		$wheel = "Dr-RO";
		$msql = "tire_d_out";
		$ids = "tire-d-out";
		$shorts = "tdo";
		$tiny = "DO";
		$lowertiny = "do";
		$alt = "do";
		$shortName = "Dr Rear Out";
		$invBuilder = "do";
		
		break;

		case 4:
		$tireName = "Driver Rear Inner";
		$wheel = "Dr-RI";
		$msql = "tire_d_in";
		$ids = "tire-d-in";
		$shorts = "tdi";
		$tiny = "DI";
		$lowertiny = "di";
		$alt = "di";
		$shortName = "Dr Rear In";
		$invBuilder = "di";
		break;

		case 5:
		$tireName = "Passenger Rear Inner";
		$wheel = "Ps-RI";
		$msql = "tire_p_in";
		$ids = "tire-p-in";
		$shorts = "tpi";
		$tiny = "PI";
		$lowertiny = "pi";
		$alt = "pi";
		$shortName = "Pass Rear In";
		$invBuilder = "pi";
		break;

		case 6:
		$tireName = "Passenger Rear Outer/Single";
		$wheel = "Ps-RO";
		$msql = "tire_p_out";
		$ids = "tire-p-out";
		$shorts = "tpo";
		$tiny = "PO";
		$lowertiny = "po";
		$alt = "po";
		$shortName = "Pass Rear Out";
		$invBuilder = "po";
		break;

		case 7:
		$tireName = "Driver Far Outer";
		$wheel = "Dr-Far-O";
		$msql = "tire_dfar_out";
		$ids = "tire-dfar-out";
		$shorts = "tdfo";
		$tiny = "DFO";
		$lowertiny = "dfo";
		$alt = "dfarout";
		$shortName = "Dr Far Out";
		$invBuilder = "dfaro";
		break;

		case 8:
		$tireName = "Driver Far Inner";
		$wheel = "Dr-Far-I";
		$msql = "tire_dfar_in";
		$ids = "tire-dfar-in";
		$shorts = "tdfi";
		$tiny = "DFI";
		$lowertiny = "dfi";
		$alt = "dfarin";
		$shortName = "Dr Far In";
		$invBuilder = "dfari";
		break;

		case 9:
		$tireName = "Passenger Far Inner";
		$wheel = "Ps-Far-I";
		$msql = "tire_pfar_in";
		$ids = "tire-pfar-in";
		$shorts = "tpfi";
		$tiny = "PFI";
		$lowertiny = "pfi";
		$alt = "pfarin";
		$shortName = "Pass Far In";
		$invBuilder = "pfari";
		break;

		case 10:
		$tireName = "Passenger Far Outer";
		$wheel = "Ps-Far-O";
		$msql = "tire_pfar_out";
		$ids = "tire-pfar-out";
		$shorts = "tpfo";
		$tiny = "PFO";
		$lowertiny = "pfo";
		$alt = "pfarout";
		$shortName = "Pass Far Out";
		$invBuilder = "pfaro";
		break;
	}	
	  

  
	switch ($a)	{
		case 1:
		return $wheel;
		break;
		
		case 2:
		return $msql;
		break;
		
		case 3:
		return $ids;
		break;

		case 4:
		return $shorts;
		break;
		
		case 5:
		return $tiny;
		break;
		
		case 6:
		return $lowertiny;
		break;
		
		case 7:
		return $alt;
		break;
		
		case 8:
		return $tireName;
		break;
		
		case 9:
		return $shortName;
		break;
		
		case 10:
		return $invBuilder;
		break;

	}
	
}
#########################################TIRE DATABASE INSERTER###################
### ALWAYS use tires[] tireBrand[] tireTreads[]
### ALWAYS returns $tireDbNames and $tireValues
### Parameters are to determing what to call in the wheels() function.
##### Use the following 2 vars on the script that is calling this info.
#	$tireDbName = dbInsertTiresNames(2,7,7);
#	$tireDbValue = dbInsertTiresValues($tire, $tireBrand, $tireTread);
# service_records = 2,7,7 _mfg _tread
# service_requests = 2,4,4 _brand _rt
				
##################################################################################	

function dbInsertTiresNames($wTire, $wBrand, $wTread, $pageType)	{
	
	if ($pageType == "request")	{
		$mfgText = "_brand";
		$treadText = "_rt";
	}
	if ($pageType == "record")	{
		$mfgText = "_mfg";
		$treadText = "_tread";
	}
	
	$tireDb = "";
	$brandDb = "";
	$treadDb = "";
	
	for ($x=1; $x<11; $x++)	{
		$tireDb .= wheels($x,$wTire);
		$brandDb .= wheels($x,$wBrand).$mfgText;
		if ($x > 2) {$treadDb .= wheels($x,$wTread).$treadText;}
		if ($x < 10) {
			$tireDb .= ", ";
			$brandDb .= ", ";
			if ($x > 2) {$treadDb .= ", ";}
		}
	}
	$tireDbNames = $tireDb.", ".$brandDb.", ".$treadDb;
	return $tireDbNames;
}


	#################
	
	
function dbInsertTiresValues($tire, $tireBrand, $tireTread)	{
	$tireString = "";
	$tireBrandString = "";
	$tireTreadString = "";
	
	for ($x=1; $x<11; $x++)	{
		$tireString .= "'".$tire[$x]."'";
		$tireBrandString .= "'".$tireBrand[$x]."'";
		if ($x > 2) {$tireTreadString .= "'".$tireTread[$x]."'";}
		if ($x < 10) {
			$tireString .= ", ";
			$tireBrandString .= ", ";
			if ($x > 2) {$tireTreadString .= ", ";}
		}
	}
	$tireValues = $tireString.", ".$tireBrandString.", ".$tireTreadString;
	return $tireValues;
}
#############################TIRE DATABASE UPDATER#####################################################	

function dbUpdateTires($tire, $tireBrand, $tireTread, $wTire, $wBrand, $wTread, $pageType)	{
	if ($pageType == "request")	{
		$mfgText = "_brand";
		$treadText = "_rt";
	}
	if ($pageType == "record")	{
		$mfgText = "_mfg";
		$treadText = "_tread";
	}
	if ($pageType == "builder")	{
		$mfgText = "m";
		$treadText = "t";
	}
	
	$tireString = "";
	$tireMfgString = "";
	$tireTreadString = "";
	
	for ($x=1; $x<11; $x++)	{
		$tireString .= wheels($x,$wTire)."='".$tire[$x]."'";
		if ($x < 10)	{
			$tireString .= ", ";
		}
		$tireBrandString .= wheels($x,$wBrand).$mfgText."='".$tireBrand[$x]."'";
		if ($x < 10)	{
			$tireBrandString .= ", ";
		}
		if ($x > 2)	{
			$tireTreadString .= wheels($x,$wTread).$treadText."='".$tireTread[$x]."'";
			if ($x < 10)	{
				$tireTreadString .= ", ";
			}
		}
	}
		$tireUpdateString = $tireString.", ".$tireBrandString.", ".$tireTreadString;
		return $tireUpdateString;
}
##################################################################

function docFiles($docImg, $a)	{
	$android = $_SESSION["android"];
	$gonative = $_SESSION["gonative"];
	
	$fileExt = substr($docImg, -4); 
	
	if (($fileExt == ".pdf") || ($fileExt == ".PDF"))	{
		if(($android === 1) && ($gonative === 1)){#not android
			$docTarget = "";
		}else{
			$docTarget = " target=\"_blank\"";
		}
	}else{
		$docTarget = " target=\"_blank\"";
		if(($android !== 1) && ($gonative === 1)){#is ios
			$docViewer = "";
		}else{
			$docViewer = "docviewer.php?f=";
		}
	}	

	if ($a === 0){return $docTarget;}
	if ($a === 1){return $docViewer;}

}

##################################################################


function dateSuffix($billDate)	{
	$ds = substr($billDate, -1);
	if ($ds == "1")	{
		$dateSuffix = "st";
	}elseif ($ds == "2")	{
		$dateSuffix = "nd";
	}elseif ($ds == "3")	{
		$dateSuffix = "rd";
	}else{
		$dateSuffix = "th";
	}
	return $dateSuffix;
}




?>