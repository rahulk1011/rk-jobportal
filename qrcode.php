<?php

include("configs/config.php");
$jobs = new Database_Conn();

$user_id = $_GET['qr_id'];

$uQuery = $jobs->GetUserData($user_id);
while ($row_u = mysqli_fetch_array($uQuery))
{
	$user_id = $row_u["email_id"];
	$fullname = $row_u["fullname"];
	$address = $row_u["address"];
	$city = $row_u["city"];
	$phone = $row_u["phone_no"];
}

include 'plugins/phpQR/qrlib.php';

$text = "Name : ".$fullname."
Email-ID : ".$user_id."
Address: ".$address."
City : ".$city."
Phone Number : ".$phone;

$path = 'doc_QR/'; 
$file = $path.uniqid().".png"; 
  
// $ecc stores error correction capability('L') 
$ecc = 'L'; 
$pixel_Size = 5; 
$frame_Size = 10; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size); 
  
// Displaying the stored QR code from directory 
echo "<center><img src='".$file."'></center>"; 

?>