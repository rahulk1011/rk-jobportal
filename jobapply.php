<?php
	include("configs/config.php");
	$jobs = new Database_Conn();

	session_start();
	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE HTML>
<html>

<title>Job Application</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
</head>
<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%; padding:1px 16px;">
<br>

<?php
	$user_id = $_GET['user_id'];
	$job_id = $_GET['job_id'];

	$uQuery = $jobs->GetUserData($user_id);
	while ($row_u = mysqli_fetch_array($uQuery))
	{
		$user_id = $row_u["email_id"];
		$fullname = $row_u["fullname"];
	}

	$pQuery = $jobs->GetJobData($job_id);
	while($row_p = mysqli_fetch_array($pQuery))
	{
		$job_id = $row_p["job_id"];
		$job_title = $row_p["job_title"];
		$organisation = $row_p["organisation"];
		$location = $row_p["location"];
	}
	$apply_date = date("Y-m-d");

	$message = "
	<html><body>
	<b>To,</b><br>
	".$fullname."<br>
	<br>
	This is to inform you that your application for the post of <b>".$job_title."</b> in <b>".$organisation."</b>, located in <b>".$location."</b> has been submitted successfully.
	<br>
	The HR Team will contact you soon.
	<br><br>
	<b>From,</b><br>
	Admin<br>
	Rahul-Jobs</body></html>";

	require 'plugins/phpMailer/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;

	$mail->IsSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = 'risktesting.demo@gmail.com';
	$mail->Password = 'rahul1011!';
	$mail->SMTPSecure = 'tls';

	$mail->From = 'risktesting.demo@gmail.com';
	$mail->FromName = 'R-Jobs Admin';
	$mail->AddAddress($user_id, $fullname);
	$mail->AddAddress($user_id);

	$mail->IsHTML(true);

	$mail->Subject = 'Job Application Submission';
	$mail->Body    = $message;
	$mail->AltBody = $message;

	$query = $jobs->SaveApplication($job_id, $job_title, $organisation, $location, $user_id, $fullname, $apply_date);
	if ($query)
	{
		if ($mail->Send())
		{
			echo "<h2><font color='black'>Application Successful..</font></h2>";
			echo "<h2><font color='black'>You will be contacted shortly..</font></h2>";
			header('Refresh:3; URL=jobapplied.php');
		}
		else
		{
			echo "<h2>Message could not be sent..</h2>";
			echo "<h2>Mailer Error: " . $mail->ErrorInfo . "</h2>";
			exit;
		}
	}
	else
	{
		echo "<h2><font color='black'>Application Failed. You Have Already Applied For This Job..</font></h2>";
		header('Refresh:3; URL=jobapplied.php');
	}
?>

</div>

<?php
	}
	else 
	{
    	header("Location:index.php");
	}	
?>

</body>
</html>