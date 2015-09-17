<?php
	require 'app_config/iTeachrLoginAccount.php';
	$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
	mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
	
	
	$u = $_POST['uname'];
	$p = md5(trim($_POST['passwd']));
		
	$query=mysql_query("
         select * from `users` where email='$u' and password='$p'
        ");
	$row=mysql_num_rows($query);
	if ($row == 1){
		
			session_start();
			$a=mysql_fetch_array($query);
			$_SESSION['user']=$a['userId'];
		
			$_SESSION['useremail']=$a['email'];
			$_SESSION['userfirstname']=$a['firstName'];
			$_SESSION['userlastname']=$a['lastName'];
			$_SESSION['userrole']=$a['role'];
			$_SESSION['login_time'] = time();
			
		if (isset($_POST['next'])) {
			$url = $_POST['next'];
			echo "<!DOCTYPE html>
				  <html>
				  <head>
				  	<meta http-equiv='refresh' content='0; url={$url}'>
				 	<title>iTeachr</title>
				  </head>
				  <body>
				  	<p>Loggin in ...</p>
				  </body>
				  </html> ";
		} else {
			if ($a['role'] == '0') {
				header("location: ../../user/index.php");
			} elseif ($a['role'] == '1') {	
				header("location: ../../user/index.php");			
			} elseif ($a['role'] == '3') {
				header("location: ../../view/view.php");
			} elseif ($a['role'] == '2') {
				header("location: ../../administrator/admin.php");
			}
		}
		
	}else{
		$emailfail = urlencode(base64_encode($u));
		header("location: ../../login.php?msg=Wrong email or password! Please try again.&type=error&e=$emailfail");
	}
	
	mysql_close($con);
	
?>