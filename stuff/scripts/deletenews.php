<?php
session_start();
	if (isset($_SESSION['user'])){
		if ($_SESSION['userrole'] = 2) {
			if (isset($_GET['newsid'])) {
				require 'app_config/iTeachrAdminAccount.php';
				$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
				mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
				
				$sql = mysql_query("SELECT * FROM news
						WHERE newsId={$_GET['newsid']};
						") or die(mysql_error());
				
				$results = mysql_fetch_array($sql);
				
				$fileName = $results['imageUrl'];
				
				$sql = mysql_query("DELETE FROM news
						WHERE newsId={$_GET['newsid']};
						") or die(mysql_error());
				
				unlink('../news/' . $fileName);
				
				mysql_close($con);
				
				header ("location: ../../administrator/news.php?msg={$fileName} has been succesfully deleted from news&type=success");
			}
		} else {
			header ("location: ../../index.php");
		}
	}
?>