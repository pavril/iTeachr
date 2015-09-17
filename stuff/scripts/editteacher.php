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
								WHERE absentId = '{$_POST['Id']}'
								") or die(mysql_error());
			$get = mysql_fetch_array($info);
			
			//Update absentteachers table
			$email = $_POST['teacheremail'];
			
			$sql = "UPDATE `absentteachers`
					SET
						`comments` = '{$_POST['comments']}'
					WHERE `absentId` = {$_POST['Id']};";
					
			$result = mysql_query($sql);
			
			//Get periods
			$sP1 = (isset($_POST['P1']) && $_POST['P1'] == "true") ? 1 : 0;
			$sP2 = (isset($_POST['P2']) && $_POST['P2'] == "true") ? 1 : 0;
			$sP3 = (isset($_POST['P3']) && $_POST['P3'] == "true") ? 1 : 0;
			$sP4 = (isset($_POST['P4']) && $_POST['P4'] == "true") ? 1 : 0;
			$sP5 = (isset($_POST['P5']) && $_POST['P5'] == "true") ? 1 : 0;
			$sP6 = (isset($_POST['P6']) && $_POST['P6'] == "true") ? 1 : 0;
			$sP7 = (isset($_POST['P7']) && $_POST['P7'] == "true") ? 1 : 0;
			$sP8 = (isset($_POST['P8']) && $_POST['P8'] == "true") ? 1 : 0;
			$sP9 = (isset($_POST['P9']) && $_POST['P9'] == "true") ? 1 : 0;
			
			//Update periods
			$sql = "
					UPDATE `absentperiods`
					SET
						`Period1` = {$sP1},
						`Period2` = {$sP2},
						`Period3` = {$sP3},
						`Period4` = {$sP4},
						`Period5` = {$sP5},
						`Period6` = {$sP6},
						`Period7` = {$sP7},
						`Period8` = {$sP8},
						`Period9` = {$sP9}
					WHERE `PeriodsId` = {$get['PeriodsId']};";
					
			$result = mysql_query($sql);
			
			mysql_close($con);
			
			header("location: ../../administrator/admin.php?msg=The teacher {$email} has been succesfully updated&type=success");
		} else {
			echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
		}
	}else{
		echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
	}
?>