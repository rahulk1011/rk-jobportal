<?php

include("configs/config.php");
$jobs = new Database_Conn();

$query = $jobs->JobApplications();

include 'plugins/phpExcel/PHPExcel.php';
include 'plugins/phpExcel/PHPExcel/Writer/Excel2007.php';

$phpExcel = new PHPExcel();

$phpExcel->setActiveSheetIndex(0);
$phpExcel->getActiveSheet()->SetCellValue('A1', 'Job ID');
$phpExcel->getActiveSheet()->SetCellValue('B1', 'Job Title');
$phpExcel->getActiveSheet()->SetCellValue('C1', 'Fullname');
$phpExcel->getActiveSheet()->SetCellValue('D1', 'Organisation');
$phpExcel->getActiveSheet()->SetCellValue('E1', 'Location');
$phpExcel->getActiveSheet()->SetCellValue('F1', 'Employment');
$phpExcel->getActiveSheet()->SetCellValue('G1', 'Apply Date');
$phpExcel->getActiveSheet()->SetCellValue('H1', 'Status');

$i = 3;
$j_status = "";
while($row = mysqli_fetch_array($query))
{
	$phpExcel->setActiveSheetIndex(0);
	$phpExcel->getActiveSheet()->SetCellValue('A'.$i, $row["job_id"]);
	$phpExcel->getActiveSheet()->SetCellValue('B'.$i, $row["job_title"]);
	$phpExcel->getActiveSheet()->SetCellValue('C'.$i, $row["fullname"]);
	$phpExcel->getActiveSheet()->SetCellValue('D'.$i, $row["organisation"]);
	$phpExcel->getActiveSheet()->SetCellValue('E'.$i, $row["location"]);
	$phpExcel->getActiveSheet()->SetCellValue('F'.$i, $row["employment"]);
	$phpExcel->getActiveSheet()->SetCellValue('G'.$i, $row["apply_date"]);
	if ($row["job_status"] == 0)
		$j_status = "Rejected";
	elseif ($row["job_status"] == 1)
		$j_status = "Approved";
	elseif ($row["job_status"] == 2)
		$j_status = "Pending";
	$phpExcel->getActiveSheet()->SetCellValue('H'.$i, $j_status);
	$i++;
}

date_default_timezone_set("Asia/Calcutta");
$time = date('dmy_His', time());

$objWriter = new PHPExcel_Writer_Excel2007($phpExcel);
$objWriter->save('doc_Excel/JobApplications_'.$time.'.xlsx');

header('Refresh:0; URL=jobapplication.php');

?>