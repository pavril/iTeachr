<?php
	session_start();
	$teacheremail = $_POST['teacheremail'];
	if (isset($_SESSION['user'])){
		if ($_SESSION['userrole'] == 2) {
			if ($teacheremail == "") {
				header("location: ../../administrator/admin.php?msg=Please enter an email&type=warning");
			} else {
				require 'app_config/iTeachrAdminAccount.php';
				$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
				mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
				//Get teacher id
				$sql = "SELECT teachers.teacherId  FROM users INNER JOIN teachers ON users.userId = teachers.userId WHERE users.email='$teacheremail'";
				$result = mysql_query($sql);
				$a = mysql_fetch_array($result);
				$teacherid = $a['teacherId'];
				
				//Check if teacher is already marked as absent
				date_default_timezone_set('UTC'); 
				$yesterday = date('Y-m-d',strtotime("-1 days"));
				$yesterdayString = $yesterday . " 23:59:59";
				$sql = "SELECT absentId FROM absentteachers WHERE teacherId = '$teacherid' AND date='$yesterdayString';";
				$result = mysql_query($sql);
				$num = mysql_num_rows($result);
				if ($num == 1) {
					
					header("location: ../../administrator/admin.php?msg=The teacher {$teacheremail} is already marked as absent. You can edit the teacher if you want to make changes&type=info");
				} else {
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
			
					//Get comments
					$comments = $_POST['comments'];
			
					//Get current date and time
					date_default_timezone_set('UTC'); 
					$date = date('Y-m-d H:i:s');
			
					//Insert to periods table
					$sql = "INSERT INTO absentperiods (Period1, Period2, Period3, Period4, Period5, Period6, Period7, Period8, Period9) VALUES ('$sP1', '$sP2', '$sP3', '$sP4', '$sP5', '$sP6', '$sP7', '$sP8', '$sP9')";
					$result = mysql_query( $sql,$con );
			
					//Retrieve Period Id
					$periodsid = mysql_insert_id( $con );
			
					//Insert absent teacher to absentteachers table
					$sql = "INSERT INTO absentteachers (`teacherId`, `comments`, `date`, `periodsId`) VALUES ($teacherid, '$comments', '$date', $periodsid)";
					$result = mysql_query($sql);
					
					mysql_close($con);
			
					header("location: ../../administrator/admin.php?msg=The teacher {$teacheremail} has been succesfully marked as absent&type=success");
				}
			}
		} else {
			echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
		}
	}else{
		echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
	}
	
	
?>