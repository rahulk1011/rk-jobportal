<?php
	include('configs/config.php');
	$users = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>User List</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
	
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
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">List of Users</font></h2>
	</div>

	<div style="padding-top: 100px">
	<table align="center" width="90%" cellspacing="0">
		<tr>
			<th width="1%">Serial</th>
			<th width="15%">Candidate Name</th>
			<th width="25%">Email-ID</th>
			<th width="25%">Address</th>
			<th width="15%">City</th>
			<th width="10%">Phone</th>
			<th width="9%">Action</th>
		</tr>
		<?php
		$query = $users->UserList();
		
		if (mysqli_num_rows($query) > 0)
		{
			$serial = 1;
			while($row = mysqli_fetch_array($query))
			{
			?>
			<tr>
				<td><?php echo $serial; ?></td>
				<td><?php echo $row["fullname"]; ?></td>
				<td><?php echo $row["email_id"]; ?></td>
				<td><?php echo $row["address"]; ?></td>
				<td><?php echo $row["city"]; ?></td>
				<td><?php echo $row["phone_no"]; ?></td>
				<td align="center">
				<?php
					$user_id = $row["email_id"];
					echo "<a href='pdfprint.php?pdf_id=".$user_id."'><img src='css/images/pdf.png' height='20px' width='20px'></a>";
					echo "&nbsp;&nbsp;";
					echo "<a href='qrcode.php?qr_id=".$user_id."'><img src='css/images/qr.png' height='20px' width='20px'></a>";
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
				<td colspan="7">-- No Records Found --</td>
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