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
	
		if (($_SESSION['userrole'] = 0) OR ($_SESSION['userrole'] = 1)) {
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
    <title>Absent Teachers - iTeachr</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../stuff/css/bootstrap.css">
    <link rel="stylesheet" href="../stuff/css/bootstrap-responsive.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <nav>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">        <span class="icon-bar"></span>        <span class="icon-bar"></span>        <span class="icon-bar"></span>      </a><a class="brand" href="index.php">iTeachr</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li>
                  <a href="index.php" class="active">Home</a>
				</li>
				<li>
                  <p class="navbar-text hidden-desktop">Logged in as <a href="# " class="navbar-link "><?php echo $first_name . " " . $last_name ?></a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
                </li>
			  </ul>    
  		    </div>  
			<p class="navbar-text pull-right visible-desktop">Logged in as <a href="usersettings.php" class="navbar-link "><?php echo $first_name . " " . $last_name ?></a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
			</div>        </div>      </div>    </nav><div class="container-fluid "><div class="row-fluid ">  <div class="span7 "><h3>Today's absent teachers</h3><table class="table table-striped table-bordered ">  <thead>    <tr>      <th>Teacher</th>      <th>Replaced Periods</th><th>Comments</th>    </tr>  </thead>  <tbody>   
			<?php
			date_default_timezone_set('UTC'); 
			$yesterday = date('Y-m-d',strtotime("-1 days"));
			$yesterdayString = $yesterday . " 00:00:00";
			
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
			$raw_results = mysql_query("SELECT absentteachers.absentId, users.firstName, users.lastName, users.email, absentteachers.comments, absentperiods.Period1, absentperiods.Period2, absentperiods.Period3, absentperiods.Period4, absentperiods.Period5, absentperiods.Period6, absentperiods.Period7, absentperiods.Period8, absentperiods.Period9
										FROM absentteachers 
										INNER JOIN absentperiods ON absentteachers.periodsId = absentperiods.PeriodsId
										INNER JOIN teachers ON absentteachers.teacherId = teachers.teacherId
										INNER JOIN users ON teachers.userId = users.userId
										WHERE absentteachers.date >= '$yesterdayString'
										ORDER BY absentteachers.date DESC;
									") or die(mysql_error());
             
                 
			if(mysql_num_rows($raw_results) > 0){
             
			while($results = mysql_fetch_array($raw_results)){
			
				$absentperiods = NULL;
				
				if ($results['Period1'] == 1) {
					$absentperiods = $absentperiods . "P1,  ";
				}
				if ($results['Period2'] == 1) {
					$absentperiods = $absentperiods . "P2,  ";
				}
				if ($results['Period3'] == 1) {
					$absentperiods = $absentperiods . "P3,  ";
				}
				if ($results['Period4'] == 1) {
					$absentperiods = $absentperiods . "P4,  ";
				}
				if ($results['Period5'] == 1) {
					$absentperiods = $absentperiods . "P5,  ";
				}
				if ($results['Period6'] == 1) {
					$absentperiods = $absentperiods . "P6,  ";
				}
				if ($results['Period7'] == 1) {
					$absentperiods = $absentperiods . "P7,  ";
				}
				if ($results['Period8'] == 1) {
					$absentperiods = $absentperiods . "P8,  ";
				}
				if ($results['Period9'] == 1) {
					$absentperiods = $absentperiods . "P9,  ";
				}
				if ($absentperiods == NULL) {
					$absentperiods = "/";
				}
				if ($absentperiods == "P1,  P2,  P3,  P4,  P5,  P6,  P7,  P8,  P9,  ") {
					$absentperiods = "All day";
				}
				echo "<tr>";
				echo "<td>{$results['firstName']} <b>{$results['lastName']}</b></td>";
				echo "<td>{$absentperiods}</td>";
				echo "<td>{$results['comments']}</td>";
				echo "</tr>";
            }
			
			    
			}else{
			echo "<tr>";
				echo "<td>No absent teachers today</td>
				<td></td>
				<td></td>";
				echo "</tr>";
           	}
			
			
	mysql_close($con);

			
?>
			</tbody></table></div>  <div class="span5 ">
			<p></p>
			<p></p>
			<div class="btn pull-right btn-link">
			<p></p>
			<a href="#" id="slideShowButton"></a>
			</div>
			<h3>News</h3>
			
			<?php
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
			$raw_results = mysql_query("SELECT *
									FROM news
									ORDER BY newsId DESC;
									") or die(mysql_error());
									
			if(mysql_num_rows($raw_results) > 0){
             
				echo "<div id='slideShowImages'>";
				
				while($results = mysql_fetch_array($raw_results)){
					echo "<img src='../stuff/news/{$results['imageUrl']}' />";
				}
				
				echo "</div>";
				
			} else {
			
				echo "<p>No news is good news!";
			
			}
			
			mysql_close($con);
			?>
			<a href="#" id="slideShowButton"></a>
			<script src="../stuff/js/slideShow.js"></script>
			
			</div></div></div>
			</body>
			</html>