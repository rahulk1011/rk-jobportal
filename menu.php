<?php
	$utype = $_SESSION["user_type"];
?>

<ul>
	<li><a href="welcome.php">Home</a></li>
	<?php

	// Admin Menu Panel
	if ($utype == 0)
	{
		echo "<li><a href='adminlist.php'>Admin List</a></li>";
		echo "<li><a href='userlist.php'>User List</a></li>";
		echo "<li><a href='addjob.php'>Add Jobs</a></li>";
		echo "<li><a href='joblist.php'>Jobs List</a></li>";
		echo "<li><a href='jobapplication.php'>Job Applications</a></li>";
	}

	// Candidate Menu Panel
	if ($utype == 1)
	{
		echo "<li><a href='joblist.php'>Jobs List</a></li>";
		echo "<li><a href='jobapplied.php'>Jobs Applied</a></li>";
	}
	?>
	<li><a href="logout.php">Logout</a></li>
</ul>