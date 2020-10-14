<?php

include("configs/config.php");
$jobs = new Database_Conn();

$user_id = $_GET['pdf_id'];

$uQuery = $jobs->GetUserData($user_id);
while ($row_u = mysqli_fetch_array($uQuery))
{
	$user_id = $row_u["email_id"];
	$fullname = $row_u["fullname"];
	$address = $row_u["address"];
	$city = $row_u["city"];
	$phone = $row_u["phone_no"];
}

require_once('plugins/phpPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rahul Khan');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('times', '', 14, '', true);

$pdf->AddPage();

$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$msg = "Name : ".$fullname."<br>
Email-ID : ".$user_id."<br>
Address: ".$address."<br>
City : ".$city."<br>
Phone Number : ".$phone."<br>";

$pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

$pdf->Output("rpt_".$fullname.".pdf", 'I');

?>