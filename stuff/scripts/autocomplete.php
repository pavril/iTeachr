<?php
 $q=$_GET['q'];

 require ('app_config/iTeachrViewerAccount.php');
 $con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
 mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
 
 $sql="SELECT email FROM teachers2 WHERE email LIKE '%$q%' ORDER BY email";
 $result = mysql_query($sql) or die(mysql_error());

 if($result)
 {
  while($row=mysql_fetch_array($result))
  {
   echo $row['email']."\n";
  }
 }
 
 mysql_close($con);
 
?>