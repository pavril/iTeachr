<?php
session_start();
	if ( !isset( $_SESSION['user'] ) || time() - $_SESSION['login_time'] > 600){
		function curPageURL() {
      $pageURL = 'http';
      if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
      if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
      } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
      }
       return $pageURL;
      }
    $curPageURL = curPageURL();
	session_destroy();
	header ("location: ../login.php?msg=You%20have%20been%20disconnected%20for%20security%20reasons.%20Please%20login%20again.&type=info&request=$curPageURL");
	} else {
	
		if (($_SESSION['userrole'] = 2) OR ($_SESSION['userrole'] = 1)) {
			$email = $_SESSION['useremail'];
			$first_name = $_SESSION['userfirstname'];
			$last_name = $_SESSION['userlastname'];
			$studentid = $_SESSION['user'];
			require '../stuff/scripts/app_config/iTeachrViewerAccount.php';
		} else {
			header ("location: ../index.php");
		}
	
	}
?>
<!DOCTYPE HTML>
<html>
  
  <head>
    <title>Administrator - iTeachr</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../stuff/css/bootstrap.css">
    <link rel="stylesheet" href="../stuff/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="../stuff/css/jquery.autocomplete.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function getFile(){
			document.getElementById("upfile").click();
		}
		function sub(obj){
			var file = obj.value;
			var fileName = file.split("\\");
			document.getElementById("yourBtn").innerHTML = fileName[fileName.length-1];
			document.myForm.submit();
			event.preventDefault();
		}
	</script>
    </head>
  
  <body>
    <nav>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">        <span class="icon-bar"></span>        <span class="icon-bar"></span>        <span class="icon-bar"></span>      </a><a class="brand" href="#">iTeachr</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li>
                  <a href="news.php" class="active">Home</a>
				</li>
                <li>
                  <a href="about.php ">About</a> 
                </li>
                <li>
                  <p class="navbar-text hidden-desktop">Logged in as <a href="# " class="navbar-link "><?php echo $first_name . " " . $last_name ?></a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
                </li>
              </ul>
              <p class="navbar-text visible-desktop pull-right">Logged in as <a href="# " class="navbar-link "><?php echo $first_name . " " . $last_name ?></a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
            </div>
          </div>
        </div>
      </div>
    </nav>
	<?php 
					if (isset($_GET['msg'])) {
						$msg = $_GET['msg'];
					
						if (isset($_GET['type'])) {
							$type = $_GET['type'];
						
							echo "<div id='msgbox' class='alert alert-{$type}'>";
							echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>{$msg}</div>";
							echo "</div>";
							
						} else {
					
							echo "<div id='msgbox' class='alert alert-default'>";
							echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>{$msg}</div>";
							echo "</div>";
					
					}
					}
	?>
    <div class="container-fluid">
      <ul class="nav nav-pills">
        <li>
          <a href="admin.php">Edit Teachers</a>
        </li>
        <li class="active">
          <a href="news.php">Edit News</a>
        </li>
      </ul>
      <h3>News</h3>
      <div class="row-fluid">
	  
        <div class="span8">
          <h4><b>Current News</b></h4>
          <table class="table table-striped table-bordered ">
            <thead>
              <tr>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
			$raw_results = mysql_query("SELECT *
										FROM news
										ORDER BY newsId DESC;
									") or die(mysql_error());
             
                 
			if(mysql_num_rows($raw_results) > 0){
             
			while($results = mysql_fetch_array($raw_results)){
			
				echo "<tr>";
				echo "<td>{$results['imageUrl']}</td>";
				echo "<td><a href='../stuff/scripts/deletenews.php?newsid={$results['newsId']}'>Delete</a> - <a href='../stuff/news/{$results['imageUrl']}' target='_blank'>Preview</a></td>";
				echo "</tr>";
            }
			    
			}else{
			echo "<tr>";
				echo "<td>No news yet</td>
				<td></td>";
				echo "</tr>";
           	}
			
			
	mysql_close($con);

			
?>
            </tbody>
          </table>
		  </div>
        <div class="span3">
          <h4><b>Add image</b></h4>
          <form action="../stuff/scripts/upload.php" method="POST" enctype="multipart/form-data">
			<p><button type="submit" class="btn btn-primary btn-small">Upload Image</button>
            <p><input type="file" name="file" accept="image/*" required></p>
          </form>
        </div>
      </div>
    </div>
	 </body>

</html>