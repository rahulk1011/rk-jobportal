<?php

define('servername','localhost');
define('username','root');
define('password' ,'');
define('dbname', 'rahuljobs');

class Database_Conn
{
	function __construct()
	{
		$conn = mysqli_connect(servername, username, password, dbname);
		$this->db_conn = $conn;

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}

	function LoginUser($email, $pass, $utype)
	{
		if ($utype == 0)
		{
			$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE email_id = '$email' AND password = '$pass'");
			return $sql;
		}
		elseif ($utype == 1)
		{
			$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_userdetails WHERE email_id = '$email' AND password = '$pass'");
			return $sql;
		}
	}

	function CheckUser($utype, $user_check)
	{
		if ($utype == 0)
		{
			$ses_sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE email_id = '$user_check' ");
			return $ses_sql;
		}
		elseif ($utype == 1)
		{
			$ses_sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_userdetails WHERE email_id = '$user_check' ");
			return $ses_sql;
		}
	}

	function RegisterUser($fullname, $pass, $email, $address, $city, $phone, $usertype)
	{
		if ($usertype == 0)
		{
			$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE email_id = '$email'");
		    $checkrows = mysqli_num_rows($check);

		    if($checkrows > 0)
		    {
				header('Refresh:0; URL=register.php');
		    }
		    else
		    {
		    	$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_adminlist (fullname, password, email_id, address, city, phone_no) VALUES ('$fullname', '$pass', '$email', '$address', '$city', '$phone')");
		    	return $sql;
		    }
		}
		elseif ($usertype == 1)
		{
			$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_userdetails WHERE email_id = '$email'");
		    $checkrows = mysqli_num_rows($check);

		    if($checkrows > 0)
		    {
				header('Refresh:0; URL=register.php');
		    }
		    else
		    {
				$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_userdetails (fullname, password, email_id, address, city, phone_no) VALUES ('$fullname', '$pass', '$email', '$address', '$city', '$phone')");
				return $sql;
		    }
		}
	}

	function WelcomeCount($query)
	{
		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}

	function AdminList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist");
		return $sql;
	}

	function UserList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_userdetails");
		return $sql;
	}

	function Job_Master($job_id, $organisation, $job_title, $location, $post_date, $expire_date)
	{
		$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_job_master (job_id, organisation, job_title, location, post_date, expire_date) VALUES ('$job_id', '$organisation', '$job_title', '$location', '$post_date', '$expire_date')");
		return $sql;
	}

	function Job_Details($job_id, $job_description, $industry, $function, $experience, $salary, $employment)
	{
		$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_job_details (job_id, job_description, industry, function, experience, salary, employment) VALUES ('$job_id', '$job_description', '$industry', '$function', '$experience', '$salary', '$employment')");
		return $sql;
	}

	function JobsList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_job_master JOIN tbl_job_details ON tbl_job_master.job_id = tbl_job_details.job_id ORDER BY tbl_job_master.id DESC");
		return $sql;
	}

	function SortJobs($sql_query)
	{
		$sql = mysqli_query($this->db_conn, $sql_query);
		return $sql;
	}

	function GetUserData($user_id)
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_userdetails WHERE email_id = '$user_id'");
		return $sql;
	}

	function GetJobData($job_id)
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_job_master WHERE job_id = '$job_id'");
		return $sql;
	}

	function SaveApplication($job_id, $job_title, $organisation, $location, $user_id, $fullname, $apply_date)
	{
		$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_applications WHERE job_id = '$job_id' AND user_id = '$user_id'");
	    $checkrows = mysqli_num_rows($check);

	    if($checkrows > 0)
	    {
			return false;
	    }
	    else
	    {
	    	$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_applications (job_id, job_title, organisation, location, user_id, fullname, apply_date, job_status) VALUES ('$job_id', '$job_title', '$organisation', '$location', '$user_id', '$fullname', '$apply_date', 2)");
			return $sql;
	    }
	}

	function JobApplications()
	{
		$query = "SELECT * FROM tbl_applications JOIN tbl_job_details ON tbl_job_details.job_id = tbl_applications.job_id ORDER BY tbl_applications.job_status DESC";
		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}

	function JobStatus($job_id, $user_id, $job_status)
	{
		$sql = mysqli_query($this->db_conn, "UPDATE tbl_applications SET job_status = '$job_status' WHERE job_id = '$job_id' AND user_id = '$user_id'");
		return $sql;
	}

	function UserApplications($user_id)
	{
		$query = "SELECT * FROM tbl_applications JOIN tbl_job_details ON tbl_job_details.job_id = tbl_applications.job_id
			WHERE tbl_applications.user_id = '$user_id' ORDER BY tbl_applications.id ASC";
		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}
}

?>