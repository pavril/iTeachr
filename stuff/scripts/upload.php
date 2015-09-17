<?php
session_start();
if (isset($_SESSION['user'])){
	if ($_SESSION['userrole'] = 2) {
		
		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& in_array($extension, $allowedExts))
		{
			if ($_FILES["file"]["error"] > 0) {
				header("location: ../../administrator/news.php?msg=Return Code: " . $_FILES["file"]["error"] . "&type=info");
			} else {
				
				if (file_exists("../news/" . $_FILES["file"]["name"])) {
					header("location: ../../administrator/news.php?msg={$_FILES["file"]["name"]} already exists.&type=info");
				} else {
				
					require 'app_config/iTeachrAdminAccount.php';
					$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
					mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
					
					$url = $_FILES["file"]["name"];
					
					$sql = "INSERT INTO news
							(imageUrl, hidden)
							VALUES
							('{$url}', 0);";
							
					mysql_query($sql) or die(mysql_error());
					
					mysql_close($con);

					move_uploaded_file($_FILES["file"]["tmp_name"],
					"../news/" . $_FILES["file"]["name"]);
					
	
					header("location: ../../administrator/news.php?msg={$url} has been succesfully added to the news list&type=success");
					
				}
			}
		} else {
			header("location: ../../administrator/news.php?msg=Invalid file");
		}
		
	} else {
		echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
	}
} else {
	echo "<p>You are not authorized to be in this page. <a href='../../index.php'>Go back</a>";
}
?>
