<?php
	include('configs/config.php');
	$jobs = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Job List</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
	<script src="js/jquery-3.4.1.js"></script>
	
	<script>
		$(document).ready(function()
		{
			$("#filter_head").click(function()
			{
				$("#filter_menu").slideToggle("medium");
			});
		});

		function onlyNos(e, t)
		{
			try 
			{
				if (window.event)
				{	var charCode = window.event.keyCode;	}
				else if (e)
				{	var charCode = e.which;	}
				else {	return true;	}
				if (charCode > 31 && (charCode < 46 || charCode > 57)) 
				{	return false;	}
				return true;
			}
			catch (err) 
			{	alert(err.Description);	}
		}
	</script>
	<style type="text/css">
        .no-result {
        	background-color: lavender;
        	padding: 5px;
        }
        td {
        	border: 0;
        	height: 20px;
        	padding: 5px;
        }
        .input-exp {
        	padding: 5px;
			margin: 2px;
			box-sizing: border-box;
			border: 1px solid black;
			border-radius: 3px;
			width: 100px;
        }
        .notify {
			width: 100%;
		}
		.notify td {
			text-align: center;
			background: linear-gradient(to right, #003366 0%, lavender 50%, #003366 100%);
			color: white;
		}
		.notify-fail {
			width: 100%;
		}
		.notify-fail td {
			text-align: center;
			background: linear-gradient(to right, #cc0000 0%, lavender 50%, #cc0000 100%);
			color: white;
			font-weight: bold;
		}
		#filter_head {
			cursor: pointer;
		}
		#filter_menu {
			display: none;
			font-weight: bold;
		}
		#filter_menu table {
			padding: 5px;
			background-color: gray;
		}
		.main-table {
			padding: 2px;
			background-color: black;
		}
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">
	<div class="top-bar">
		<div id="filter_head"><h2><font color="white">Job Filter:</font></h2></div>
		<div id="filter_menu">
			<form method="post" action="">
			<table cellspacing="0" width="75%" align="center">
				<tr>
					<td align="right" width="15%">JOB TITLE</td>
					<td align="left" width="35%"><input type="text" name="title" class="form-control"></td>
					<td align="right" width="15%">LOCATION</td>
					<td align="left" width="35%"><input type="text" name="location" class="form-control"></td>
				</tr>
				<tr>
					<td align="right">INDUSTRY</td>
					<td align="left"><input type="text" name="industry" class="form-control"></td>
					<td align="right">EMPLOYMENT</td>
					<td align="left">
						<select name="employment" > 
							<option value="">Select Type</option>
							<option value="Full-Time"> Full-Time </option>
							<option value="Part-Time"> Part-Time </option>
							<option value="Internship"> Internship </option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">EXPERIENCE</td>
					<td align="left">
						<input type="text" name="fexperience" class="input-exp" onkeypress="return onlyNos(event, this);"><b> - </b> 
						<input type="text" name="texperience" class="input-exp" onkeypress="return onlyNos(event, this);">
					</td>
					<td align="right">SALARY</td>
					<td align="left">
						<input type="text" name="fsalary" class="input-exp" onkeypress="return onlyNos(event, this);"><b> - </b> 
						<input type="text" name="tsalary" class="input-exp" onkeypress="return onlyNos(event, this);">
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center"><input type="submit" name="sort" value="Show Results" class="button"></td>
				</tr>
			</table>
			</form>
			<br>
		</div>
	</div>

	<div style="padding-top: 80px;">
	<?php

	if (isset($_POST["sort"]))
	{
		$title = $_POST["title"];
		$location = $_POST["location"];
		$industry = $_POST["industry"];
		$employment = $_POST["employment"];
		$fexperience = $_POST["fexperience"];
		$texperience = $_POST["texperience"];
		$fsalary = $_POST["fsalary"];
		$tsalary = $_POST["tsalary"];

		$whereClause = array();

		if (!empty($title)) 
			$whereClause[] = "tbl_job_master.job_title LIKE '%".$title."%'"; 
		$where = '';

		if (!empty($location)) 
			$whereClause[] = "tbl_job_master.location = '".$location."'"; 
		$where = '';

		if (!empty($industry)) 
			$whereClause[] = "tbl_job_details.industry = '".$industry."'"; 
		$where = '';

		if (!empty($employment)) 
			$whereClause[] = "tbl_job_details.employment = '".$employment."'"; 
		$where = '';

		if (!empty($fexperience) && !empty($texperience)) 
			$whereClause[] = "tbl_job_details.experience >= '".$fexperience."' AND tbl_job_details.experience <= '".$texperience."'"; 
		$where = '';

		if (!empty($fsalary) && !empty($tsalary)) 
			$whereClause[] = "tbl_job_details.salary >= '".$fsalary."' AND tbl_job_details.salary <= '".$tsalary."'"; 
		$where = '';

		if (count($whereClause) > 0) 
		{ 
			$where = ' WHERE '.implode(' AND ', $whereClause); 
		}

		$sql_query = "SELECT * FROM tbl_job_master JOIN tbl_job_details ON tbl_job_master.job_id = tbl_job_details.job_id".$where." ORDER BY tbl_job_master.id DESC";

		$sort = $jobs->SortJobs($sql_query);

		if (mysqli_num_rows($sort) > 0)
		{
			$serial = 1;
			while ($row = mysqli_fetch_array($sort))
			{
			?>
			<div class="main-table">
			<table width='100%' align='center'>
				<tr>
					<td rowspan="4" width="10%"><b>Job ID : </b><?php echo $row["job_id"]; ?></td>
					<td width="50%"><b>Organisation: </b><?php echo $row["organisation"]; ?></td>
					<td width="20%"><b>Location: </b><?php echo $row["location"]; ?></td>
					<td width="20%"><b>Employment: </b><?php echo $row["employment"]; ?></td>
				</tr>
				<tr>
					<td><b>Job Title: </b><?php echo $row["job_title"]; ?></td>
					<td><b>Industry: </b><?php echo $row["industry"]; ?></td>
					<td><b>Salary: </b><?php echo $row["salary"]; ?> LPA</td>
				</tr>
				<tr>
					<td rowspan="2" valign="top"><b>Description: </b><?php echo $row["job_description"]; ?></td>
					<td><b>Function: </b><?php echo $row["function"]; ?></td>
					<td><b>Date Posted: </b><?php echo date('d-m-Y', strtotime($row["post_date"])); ?></td>
				</tr>
				<tr>
					<td><b>Experience: </b><?php echo $row["experience"]; ?> Yrs</td>
					<td><b>Apply Before: </b><?php echo date('d-m-Y', strtotime($row["expire_date"])); ?></td>
				</tr>
			</table>
			</div>
			<?php
			if ($_SESSION["user_type"] == 1 && date("Y-m-d") <= $row["expire_date"])
			{
				$job_id = $row['job_id'];
				$user_id = $_SESSION["login_user"];
				echo "<table class='notify'><tr><td><a href='jobapply.php?job_id=".$job_id."&user_id=".$user_id."'><font color='black'> APPLY </font></a></td></tr></table>";
			}
			elseif ($_SESSION["user_type"] == 1 && date("Y-m-d") > $row["expire_date"])
			{
				echo "<table class='notify-fail'><tr><td><font color='black'> JOB EXPIRED </font></td></tr></table>";
			}
			echo "<br>";
			$serial++;
			}
		}
		else
		{
			echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
		}
	}
	else
	{
		$query = $jobs->JobsList();
	
		if (mysqli_num_rows($query) > 0)
		{
			$serial = 1;
			while($row = mysqli_fetch_array($query))
			{
			?>
			<div class="main-table">
			<table width='100%' align='center'>
				<tr>
					<td rowspan="4" width="10%"><b>Job ID : </b><?php echo $row["job_id"]; ?></td>
					<td width="50%"><b>Organisation: </b><?php echo $row["organisation"]; ?></td>
					<td width="20%"><b>Location: </b><?php echo $row["location"]; ?></td>
					<td width="20%"><b>Employment: </b><?php echo $row["employment"]; ?></td>
				</tr>
				<tr>
					<td><b>Job Title: </b><?php echo $row["job_title"]; ?></td>
					<td><b>Industry: </b><?php echo $row["industry"]; ?></td>
					<td><b>Salary: </b><?php echo $row["salary"]; ?> LPA</td>
				</tr>
				<tr>
					<td rowspan="2" valign="top"><b>Description: </b><?php echo $row["job_description"]; ?></td>
					<td><b>Function: </b><?php echo $row["function"]; ?></td>
					<td><b>Date Posted: </b><?php echo date('d-m-Y', strtotime($row["post_date"])); ?></td>
				</tr>
				<tr>
					<td><b>Experience: </b><?php echo $row["experience"]; ?> Yrs</td>
					<td><b>Apply Before: </b><?php echo date('d-m-Y', strtotime($row["expire_date"])); ?></td>
				</tr>
			</table>
			</div>
			<?php
			if ($_SESSION["user_type"] == 1 && date("Y-m-d") <= $row["expire_date"])
			{
				$job_id = $row['job_id'];
				$user_id = $_SESSION["login_user"];
				echo "<table class='notify'><tr><td><a href='jobapply.php?job_id=".$job_id."&user_id=".$user_id."'><font color='black'> APPLY </font></a></td></tr></table>";
			}
			elseif ($_SESSION["user_type"] == 1 && date("Y-m-d") > $row["expire_date"])
			{
				echo "<table class='notify-fail'><tr><td><font color='black'> JOB EXPIRED </font></td></tr></table>";
			}
			echo "<br>";
			$serial++;
			}
		}
		else
		{
			echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
		}
	}
	?>
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