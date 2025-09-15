<?php


session_start();
require_once ('PDFMerger.php');
use PDFMerger\PDFMerger;
if ($_SESSION["admin"] == 1)	{

	
	
	$pdf = new PDFMerger;
	
	$pdf->addPDF('/home/fitwithadi.com/waivers/'.$_GET["pdf"]);
	
	
	$pdf->merge('browser');
}else{
	exit;
}