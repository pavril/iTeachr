<?php
session_start();
if ( !isset( $_SESSION['user'] ) || time() - $_SESSION['login_time'] > 600 ){
		header ("location: ../../login.php?msg=You%20have%20been%20automatically%20logged%20out%20for%20security%20reasons&type=info");
	} else {
	
		require 'app_config/iTeachrUserAccount.php';
	
		$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
		mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
		
		$email = $_SESSION['useremail'];
		$first_name = $_SESSION['userfirstname'];
		$last_name = $_SESSION['userlastname'];
		$studentid = $_SESSION['user'];
		if (($_SESSION['userrole'] = 0) OR ($_SESSION['userrole'] = 1)) {
			
			if (isset($_SESSION['useremail'])){
				$usermail = $_SESSION['useremail'];
			}else{
				header("location: ../../user/usersettings.php?msg=An%20error%20has%20occured%20trying%20to%20change%20your%20password&type=warning");
			}
	
			$passone = ($_POST['passone']);
			$passtwo = ($_POST['passtwo']);
			$eteredoldpass = md5(trim($_POST['oldpassetered']));

			//Find old password from database
			$query=mysql_query("
				select * from users where email='$usermail'");
			$row=mysql_num_rows($query);
			if ($row == 1){
				$a=mysql_fetch_array($query);
				$oldpass=$a['password'];
			}else{
				header("location: ../../user/usersettings.php?msg=An%20error%20has%20occured%20trying%20to%20change%20your%20password&type=warning");
			}
 
			if ($oldpass === $eteredoldpass) {

				if ($passone === $passtwo) {
	
					$newpass = md5(trim($passone));
		
					$insert_sql = "UPDATE users SET password='{$newpass}' WHERE email='{$usermail}'";

					mysql_query($insert_sql) or die(mysql_error());
		
					header("location: ../../user/usersettings.php?msg=Your password has been succesfully changed!&type=success");

				} else {
					header("location: ../../user/usersettings.php?msg=The passwords you've entered doesn't match!&type=warning");
				}
			} else {
				header("location: ../../user/usersettings.php?msg=The old password is invalid!&type=warning");
			}

			mysql_close($con);	
		} else {
			header ("location: ../../index.php");
		}
	
	}
?>