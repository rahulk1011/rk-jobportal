<?php
	include('configs/config.php');
	$index = new Database_Conn();
	session_start();
?>

<!DOCTYPE html>
<html>

<title>Login</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">
</head>

<?php

if(isset($_POST["login"]))
{
	$email = $_POST["email"];
	$pass = MD5($_POST["password"]);
	$utype = $_POST["usertype"];

	$result = $index->LoginUser($email, $pass, $utype);
	$row = mysqli_fetch_array($result);

	if($row["email_id"] == $email && $row["password"] == $pass)
	{
		$_SESSION["login_user"] = $email;
		$_SESSION["user_type"] = $utype;

		header("location: welcome.php");
	}
	else
	{
		$alert_msg = "<h3><font color='white'>Invalid Username / Password..</font></h3>";
		header('Refresh:3; URL=index.php');
	}
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">
	<form class="login100-form" action="" method="post">
		<h1 style="color: white">RAHUL-JOBS</h1>
		<br>
		<div>
			<img src="css/images/logo.jpg" class="login100-form-logo">
		</div>
		<br>
		<div>
			<input type="text" name="email" required="true" class="form-control" placeholder="Email-ID">
		</div>
		<br>
		<div>
			<input type="password" name="password" required="true" class="form-control" placeholder="Password">
		</div>
		<br>
		<div class="form-control" style="color: white">
			<input type="radio" name="usertype" value="0" required="true"> <b>Admin</b>
			&nbsp;
			<input type="radio" name="usertype" value="1" required="true"> <b>Candidate</b>
		</div>
		<div>
			<p><input type="submit" name="login" value="LOGIN" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo $alert_msg;
			} ?>
		</div>
	</form>
	<br>

	<h4 style="color: black;"><a href="register.php"> NEW USER - REGISTER !! </a></h4>
	
	</div>
</div>

</body>

</html>