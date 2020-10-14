<?php
	include('configs/config.php');
	$welcome = new Database_Conn();
	session_start();

	// validation
	$user_check = $_SESSION["login_user"];
	$utype = $_SESSION["user_type"];

	$validate = $welcome->CheckUser($utype, $user_check);
	$row = mysqli_fetch_array($validate, MYSQLI_ASSOC);

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Welcome</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">

	<style type="text/css">
		.container .box { 
            width: 100%;
            display: table;
            color: black;
        }
        .container .box .box-row { 
            display: table-row;
            padding: 10px;
        }
        .container .box .box-cell { 
            display: table-cell; 
            width: 50%; 
            padding: 10px; 
        }
        .container .box .box-cell .user-left {
            align-content: left;
        }
        .container .box .box-cell .user-right {
            align-content: left;
        }
        .box {
        	color: silver;
        }
        b {
        	color: black;
        	font-size: medium;
        }
        td {
        	border: 0;
        }
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">Welcome <?php echo $row["fullname"]; ?>..</font></h2>
	</div>

	<div style="padding-top: 100px">
	<div class="container">
		<div class="box">
			<div class="box-row">
				<div class="box-cell user-left" style="padding: 0px 50px">
					<div class="box"><b>Email-ID :</b> <?php echo $row["email_id"]; ?></div>
					<br>
					<div class="box"><b>Address :</b> <?php echo $row["address"]; ?></div>
					<br>
					<div class="box"><b>City :</b> <?php echo $row["city"]; ?></div>
					<br>
					<div class="box"><b>Phone :</b> <?php echo $row["phone_no"]; ?></div>
					<br>
					<div class="box">
						<b>Usertype :</b>
						<?php
						switch ($_SESSION["user_type"])
						{
							case 0: echo "Admin"; break;
							case 1: echo "Candidate"; break;
						}
						?>
					</div>
				</div>
				<?php
				$utype = $_SESSION["user_type"];
				if ($utype == 0)
				{
				?>
				<div class="box-cell user-right" style="padding: 0px 50px;">
					<div class="box" style="padding: 10px; text-align: center;"><b>STATUS</b></div>
					<div class="box" style="padding: 10px;">
					<table align="center" border="0" width="90%">
						<tr>
							<td colspan="3">
								<?php
								$query = "SELECT COUNT(id) FROM tbl_applications";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								$total = $row[0];
								echo "Total Applications : <b>".$total."</b>";
								?>
							</td>
						</tr>
						<tr>
							<td style="background-color: limegreen;">
								<?php
								$query = "SELECT COUNT(id) FROM tbl_applications WHERE job_status = 1";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								echo "Approved : <b>".$row[0]."</b>";
								?>
							</td>
							<td style="background-color: orangered;">
								<?php
								$query = "SELECT COUNT(id) FROM tbl_applications WHERE job_status = 0";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								echo "Rejected : <b>".$row[0]."</b>";
								?>
							</td>
							<td style="background-color: yellow;">
								<?php
								$query = "SELECT COUNT(id) FROM tbl_applications WHERE job_status = 2";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								echo "Pending : <b>".$row[0]."</b>";
								?>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<?php
								$query = "SELECT COUNT(user_id) FROM tbl_userdetails";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								$pending = $row[0];
								echo "Number of Registered Users : <b>".$row[0]."</b>";
								?>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<?php
								$query = "SELECT COUNT(id) FROM tbl_job_master";
								$sql = $welcome->WelcomeCount($query);
								$row = mysqli_fetch_array($sql);
								$pending = $row[0];
								echo "Number of Jobs Listed : <b>".$row[0]."</b>";
								?>
							</td>
						</tr>
					</table>
					</div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>

	</div>
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