<!DOCTYPE html>
<html>
<body>

<?php	
	session_start();
	unset($_SESSION["login_user"]);
	unset($_SESSION["user_type"]);
	session_destroy();
	header("Location:index.php");
?>

</body>
</html>