<?php
session_start();
	if (isset($_SESSION['user'])){
		$email = $_SESSION['useremail'];
		$first_name = $_SESSION['userfirstname'];
		$last_name = $_SESSION['userlastname'];
		$studentid = $_SESSION['user'];
		if ($_SESSION['userrole'] = 2) {
		
			require 'app_config/iTeachrAdminAccount.php';
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
			$info = mysql_query("SELECT PeriodsId
								FROM absentteachers 
								WHERE absentId = '{$_GET['id']}'
								") or die(mysql_error());
			$informations = mysql_fetch_array($info);
			
			//Delete from absentteachers table
			$email = $_GET['teacheremail'];
			$result = mysql_query("DELETE FROM `absentteachers` WHERE `absentId`='{$_GET['id']}';");		
			
			//Delete periods
			$result = mysql_query("DELETE FROM `absentperiods` WHERE `PeriodsId`='{$informations['PeriodsId']}';");
			mysql_close($con);
			
			header("location: ../../administrator/admin.php?msg=The teacher {$email} has been deleted succesfully&type=success");
		} else {
			echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
		}
	}else{
		echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
	}
?>