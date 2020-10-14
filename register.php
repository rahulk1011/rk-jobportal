<!DOCTYPE html>
<html>

<title>Registration</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">

	<script>
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
</head>

<?php

include('configs/config.php');
$registration = new Database_Conn();

if(isset($_POST["register"]))
{	
	$fullname = $_POST["fullname"];
    $pass = MD5($_POST["password"]);
    $email = $_POST["email_id"];
    $address = $_POST["address"];
	$city = $_POST["city"];
	$phone = $_POST["phone_no"];
    $usertype = $_POST["user_type"];

    $result = $registration->RegisterUser($fullname, $pass, $email, $address, $city, $phone, $usertype);

    if ($result)
    {
    	$alert_msg = "<h3><font color='white'>Registration Successful..</font></h3><br>";
    	header('Refresh:3; URL=index.php');
    }
    else
    {
    	$alert_msg = "<h3><font color='white'>Registration Failed..</font></h3><br>";
    }
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">

	<form class="login100-form" action="" method="post" enctype="multipart/form-data">
		<h1 style="color: white">REGISTRATION PAGE</h1>
		<br>
		<div>
			<input type="text" name="fullname" required class="form-control" placeholder="Full Name">
		</div>
		<br>
		<div>
			<input type="password" name="password" required class="form-control" placeholder="Password">
		</div>
		<br>
		<div>
			<input type="email" name="email_id" required class="form-control" placeholder="Email-ID">
		</div>
		<br>
		<div>
			<input type="text" name="address" required class="form-control" placeholder="Address">
		</div>
		<br>
		<div>
			<input type="text" name="city" required class="form-control" placeholder="City">
		</div>
		<br>
		<div>
			<input type="text" name="phone_no" required class="form-control" placeholder="Phone Number" onkeypress="return onlyNos(event, this);" maxlength="10">
		</div>
		<br>
		<div>
			<select name="user_type" required class="form-control"> 
				<option value=""> Select User Type </option>
				<option value="0"> Admin </option>
				<option value="1"> Candidate </option>
			</select>
		</div>
		<br>
		<div>
			<p><input type="submit" name="register" value="REGISTER" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo $alert_msg;
			} ?>
		</div>
	</form>

	<h4><a href="index.php"><font color="white"> GO BACK !! </font></a></h4>
	
	</div>
</div>

</body>

</html>