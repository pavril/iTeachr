<?php
	session_start();
	if (isset($_SESSION['user'])){
		if (($_SESSION['userrole'] == '0') OR ($_SESSION['userrole'] == '1')) {
			
			header("location: user/index.php");
			
		} elseif ($_SESSION['userrole'] == '3') {
				
			header("location: view/view.php");
		  
		} elseif ($_SESSION['userrole'] == '2') {
				
			header("location: administrator/admin.php");
		  
		}
	}else{
		header("location: login.php");
	}
?>