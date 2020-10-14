<?php
	include('configs/config.php');
	$jobs = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Add Jobs</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">

	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/jquery-ui.js"></script>

	<script>
		$(document).ready(function () {
			$('#expire_date').datepicker({
	            format: 'dd/mm/yyyy',
	            autoclose: true
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
        b {
        	color: black;
        	font-size: larger;
        	text-transform: uppercase;
        }
        .container .box {
            width: 100%;
            display: table;
            color: black;
        }
        th {
        	width: 200px;
        	text-align: right;
        	background-color: silver;
        	border: 0px;
        	color: black;
        }
        td {
        	text-align: center;
        	border: 0px;
        }
        #ui-datepicker-div {
        	width: 20%;
        }
        .row {
        	background-color: silver;
        }
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%; padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">Add Jobs</font></h2>
	</div>

	<div style="padding-top: 100px">
	<form action="" method="post">
		<table align="center" width="60%" cellspacing="0">
			<tr>
				<th>Organisation</th>
				<td class="row"><input type="text" name="organisation" class="form-control" required></td>
			</tr>
			<tr>
				<th>Job Title</th>
				<td class="row"><input type="text" name="job_title" class="form-control" required></td>
			</tr>
			<tr>
				<th>Job Description</th>
				<td class="row"><input type="text" name="job_description" class="form-control" required></td>
			</tr>
			<tr>
				<th>Location</th>
				<td class="row"><input type="text" name="location" class="form-control" required></td>
			</tr>
			<tr>
				<th>Industry</th>
				<td class="row"><input type="text" name="industry" class="form-control" required ></td>
			</tr>
			<tr>
				<th>Job Function</th>
				<td class="row"><input type="text" name="function" class="form-control" required ></td>
			</tr>
			<tr>
				<th>Experience</th>
				<td class="row"><input type="text" name="experience" class="form-control" required onkeypress="return onlyNos(event, this);" placeholder="Years"></td>
			</tr>
			<tr>
				<th>Salary</th>
				<td class="row"><input type="text" name="salary" class="form-control" required onkeypress="return onlyNos(event, this);" placeholder="In LPA"></td>
			</tr>
			<tr>
				<th>Employment</th>
				<td class="row">
					<select name="employment" required="true" class="form-control"> 
						<option value=""> Select Type </option>
						<option value="Full-Time"> Full-Time </option>
						<option value="Part-Time"> Part-Time </option>
						<option value="Internship"> Internship </option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Expiry Date</th>
				<td class="row"><input type="text" id="expire_date" name="expire_date" class="form-control" required autocomplete="off"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="save" value="SAVE" class="button"></td>
			</tr>
		</table>
	</form>

	<?php
	
	if(isset($_POST["save"]))
	{
		$str_result = "0123456789";
		$job_id = "J".substr(str_shuffle($str_result), 0, 4);

		$organisation = $_POST["organisation"];
		$job_title = $_POST["job_title"];
		$job_description = $_POST["job_description"];
		$location = $_POST["location"];
		$industry = $_POST["industry"];
		$function = $_POST["function"];
		$experience = $_POST["experience"];
		$salary = $_POST["salary"];
		$employment = $_POST["employment"];
		$post_date = date("Y-m-d");

		$exp_date = explode("/", $_POST["expire_date"]);
		$expire_date = $exp_date[2]."-".$exp_date[0]."-".$exp_date[1];
        
    	$saveJob_Master = $jobs->Job_Master($job_id, $organisation, $job_title, $location, $post_date, $expire_date);
    	$saveJob_Details = $jobs->Job_Details($job_id, $job_description, $industry, $function, $experience, $salary, $employment);

		if ($saveJob_Master && $saveJob_Details)
		{
			echo "<h3><font color='black'>Job Details Save Successful..</font></h3>";
		}
		else
		{
			echo "<h3><font color='black'>Job Details Save Failed..</font></h3>";
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