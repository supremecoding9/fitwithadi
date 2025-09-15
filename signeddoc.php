<?php
session_start();
require("connection.php");


#########################
#if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST["signed"] > 0))	{
if (($_SERVER["REQUEST_METHOD"] == "POST"))	{
	$curdocid = $_POST["signed"];

	$sigtime = time();
	$sigfile = $qrispid."_".$sigtime."_".$pin;
	$signature=$_POST["inpsig"];	
	list($type, $signature) = explode(';', $signature);
	list(, $signature) = explode(',', $signature);
	$signature = base64_decode($signature);
	$fullSigFile = 'waivers/'.$sigfile.'.png';
	

	$printname = $_POST["printname"];
	$todaydate = $_POST["todaydate"];
	$street = $_POST["street"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	
	$ec1name = $_POST["ec1name"];
	$ec1rel = $_POST["ec1rel"];
	$ec1phone = $_POST["ec1phone"];
	$ec2name = $_POST["ec2name"];
	$ec2rel = $_POST["ec2rel"];
	$ec2phone = $_POST["ec2phone"];
	$ec3name = $_POST["ec3name"];
	$ec3rel = $_POST["ec3rel"];
	$ec3phone = $_POST["ec3phone"];
	
	$minorname = $_POST["minorname"];
	$relationship = $_POST["relationship"];


	$sql="UPDATE users SET waiver_name=?, waiver_date=?, waiver_street=?, waiver_city=?, waiver_state=?, waiver_zip=?, waiver_ec1name=?, waiver_ec1rel=?, waiver_ec1phone=?, waiver_ec2name=?, waiver_ec2rel=?, waiver_ec2phone=?, waiver_ec3name=?, waiver_ec3rel=?, waiver_ec3phone=?, minor_name=?, minor_relation=? WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$printname, $todaydate, $street, $city, $state, $zip, $ec1name, $ec1rel, $ec1phone, $ec2name, $ec2rel, $ec2phone, $ec3name, $ec3rel, $ec3phone, $minorname, $relationship, $_SESSION["username"]]);
	$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;
	
	
		
	file_put_contents($fullSigFile, $signature);
	
	
}else{
	header("location: logout.php");
}


########################################
use setasign\Fpdi\Fpdi;
require_once('fpdf/fpdf.php');

require_once('fpdi/src/autoload.php');
#require('fpdf/image_alpha.php');


class ConcatPdf extends Fpdi
{
	public $files = array();

	public function setFiles($files)
	{
		$this->files = $files;
	}

	public function concat()
	{
		foreach($this->files AS $file) {
			$pageCount = $this->setSourceFile($file);
			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
				$pageId = $this->ImportPage($pageNo);
				$s = $this->getTemplatesize($pageId);
				$this->AddPage($s['orientation'], $s);
				$this->useImportedPage($pageId);
			}
		}
	}
}




	$pdf = new FPDF('P','mm','Letter');

	#$pdf->SetCompression(true, compress);
	

require ("connection.php");

#require ("timezone.php");

####################################################

			$pdf->AddPage("P","Letter");
			$pdf->Image('images/Waiver-1.png',0,0,215);
			


		
			$pdf->AddPage("P","Letter");
			$pdf->Image('images/Waiver-2.png',0,0,215);

			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(47,195);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$printname); #2nd parameter here is H (perfpdf website).  However, it acts the same as a CSS line-height;
			

				
###########################################################			
			
			$pdf->AddPage("P","Letter");
			$pdf->Image('images/Waiver-3.png',0,0,215);

			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(85,142);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$printname);
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(85,152);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$street);
			
			$cityStateZip = $city.", ".$state." ".$zip;
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(85,163);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$cityStateZip);
			
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(30,66);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec1name);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(92,66);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec1rel);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(160,66);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec1phone);
			
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(30,76);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec2name);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(92,76);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec2rel);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(160,76);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec2phone);
			
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(30,88);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec3name);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(92,88);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec3rel);
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(160,88);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$ec3phone);

			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(92,205);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$todaydate);
			
			
			$pdf->Image($fullSigFile,90,188,100);
			
			
			$apos = $pdf->GetY();
			$yPos = $apos + 10;
			#$pdf->Image($fullSigFile,12,$yPos,100);
					
###########################################################	



			$pdf->AddPage("P","Letter");
			$pdf->Image('images/Waiver-4.png',0,0,215);
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(133,52);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$minorname);
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(85,77);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$printname);
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(85,87);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$relationship);
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->SetXY(90,120);
			#$pdf->Cell(95,12,$docname);
			$pdf->MultiCell(0,7,$todaydate);
			

			$pdf->Image($fullSigFile,85,105,100);


				unlink($fullSigFile);
				$curtime = time();

			
				$finalPDF = "/home/fitwithadi.com/waivers/signed".$_SESSION["username"]."-".$curtime.".pdf";
				$sql="UPDATE users SET waiver_pdf='$finalPDF' WHERE username=?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_SESSION["username"]]);
				$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt = null;
				
				
						
				$pdf->Output("F", $finalPDF);
				
				if ((isset($_POST["member"]) && ($_POST["member"] == 1)))	{	
					header("location: index.php?waiver=1");
				}else{
					header("location: login.php?login=1");
				}
				


/*

				$sql="SELECT timezone FROM settings WHERE isp_id='$qrispid'";
				$result = $conn->query($sql);
				while($row = mysqli_fetch_array($result))	{
					$timezone = $row["timezone"];
				}
				switch ($timezone)	{
					case 1: $tz = 5;
					case 2: $tz = 6;
					case 3: $tz = 7;
					case 4: $tz = 7;
					case 5: $tz = 8;
				}
				
	
*/














