<?php
	include('configs/config.php');
	$jobs = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Applied Jobs</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">Applied Jobs</font></h2>
	</div>

	<div style="padding-top: 100px">
	<table align="center" width="95%" cellspacing="0">
		<tr>
			<th width="2%">Serial</th>
			<th width="8%">Job ID</th>
			<th width="15%">Job Title</th>
			<th width="30%">Description</th>
			<th width="15%">Organisation</th>
			<th width="10%">Location</th>
			<th width="10%">Apply Date</th>
			<th width="10%">Status</th>
		</tr>
		<?php

		$user_id = $_SESSION["login_user"];
		$query = $jobs->UserApplications($user_id);
		
		if (mysqli_num_rows($query) > 0)
		{
			$serial = 1;
			while($row = mysqli_fetch_array($query))
			{
			?>
			<tr>
				<td><?php echo $serial."."; ?></td>
				<td><?php echo $row["job_id"]; ?></td>
				<td><?php echo $row["job_title"]; ?></td>
				<td><?php echo $row["job_description"]; ?></td>
				<td><?php echo $row["organisation"]; ?></td>
				<td><?php echo $row["location"]; ?></td>
				<td><?php echo date('d-m-Y', strtotime($row["apply_date"])); ?></td>
				<td>
					<?php
					if ($row["job_status"] == 0)
						echo "Rejected";
					elseif ($row["job_status"] == 1)
						echo "Approved";
					elseif ($row["job_status"] == 2)
						echo "Pending";
					?>
				</td>
			</tr>
			<?php
			$serial++;
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="7" align="center">-- No Records Found --</td>
			</tr>
		<?php
		}
		?>
	</table>
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