<?php
	include('configs/config.php');
	$jobs = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Job Application</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">

	<style>
		.approve {
			background: green;
			color: white;
			font-size: 12px;
			padding: 0 5px;
			width: 60px;
			height: 20px;
			cursor: pointer;
			font-family: "Corbel";
			border-radius: 5px;
		}
		.reject {
			background: red;
			color: white;
			font-size: 12px;
			padding: 0 5px;
			width: 60px;
			height: 20px;
			cursor: pointer;
			font-family: "Corbel";
			border-radius: 5px;
		}
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">Job Application</font></h2>
	</div>

	<div style="padding-top: 100px">
	<div style="float: left; margin-top: -15px; padding-left: 30px;">
		<label><a href="excelprint.php"><img src='css/images/excel.png' height='20px' width='20px'><font color="black"> Print Datasheet</font></a></label>
	</div>
	<br>
	<table align="center" width="98%" cellspacing="0">
		<tr>
			<th width="5%">Job ID</th>
			<th width="15%">Job Title</th>
			<th width="15%">Candidate Name</th>			
			<th width="15%">Organisation</th>
			<th width="10%">Location</th>
			<th width="10%">Employment</th>
			<th width="10%">Apply Date</th>
			<th width="15%">Action</th>
			<th width="5%">Status</th>
		</tr>
		<?php
		$query = $jobs->JobApplications();
		
		if (mysqli_num_rows($query) > 0)
		{
			$serial = 1;
			while($row = mysqli_fetch_array($query))
			{
			?>
			<tr>
				<td><?php echo $row["job_id"]; ?></td>
				<td><?php echo $row["job_title"]; ?></td>
				<td><?php echo $row["fullname"]; ?></td>				
				<td><?php echo $row["organisation"]; ?></td>
				<td><?php echo $row["location"]; ?></td>
				<td><?php echo $row["employment"]; ?></td>
				<td><?php echo date('d-m-Y', strtotime($row["apply_date"])); ?></td>
				<td align="center">
				<?php
				echo "<form action='' method='post'>
				<input type='hidden' name='job_id' value=".$row['job_id'].">
				<input type='hidden' name='user_id' value=".$row['user_id'].">
				<input type='submit' name='approve' value='Approve' class='approve'>&nbsp;<input type='submit' name='reject' value='Reject' class='reject'>
				</form>";

				if(isset($_POST["approve"]))
				{
					$job_id = $_POST["job_id"];
					$user_id = $_POST["user_id"];
					$job_status = 1;
					$status_query = $jobs->JobStatus($job_id, $user_id, $job_status);
					if ($status_query)
						header('Refresh:0; URL=jobapplication.php');
				}
				if(isset($_POST["reject"]))
				{
					$job_id = $_POST["job_id"];
					$user_id = $_POST["user_id"];
					$job_status = 0;
					$status_query = $jobs->JobStatus($job_id, $user_id, $job_status);
					if ($status_query)
						header('Refresh:0; URL=jobapplication.php');
				}
				?>
				</td>
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
				<td colspan="9" align="center">-- No Records Found --</td>
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