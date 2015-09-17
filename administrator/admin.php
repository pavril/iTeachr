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
			require '../stuff/scripts/app_config/iTeachrAdminAccount.php';
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
	<script type="text/javascript" src="../stuff/js/jquery.js"></script>
	<script type="text/javascript" src="../stuff/js/jquery.autocomplete.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$("#teacheremail").autocomplete("../stuff/scripts/autocomplete.php", {
        selectFirst: true
		});
		});
		
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
                  <a href="admin.php" class="active">Home</a></li>       
                <li>
                  <a href="about.php">About</a> 
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
        <li class="active">
          <a href="admin.php">Edit Teachers</a>
        </li>
        <li>
          <a href="news.php">Edit News</a>
        </li>
      </ul>
      <div class="row-fluid">
		<h4><a href='javascript:history.go(0)' class='btn pull-right btn-link'><img src='../stuff/images/refresh.png'> Refresh</a></h4>
		<?php if (isset($_GET['edit'])) { if (isset($_GET['id'])) { echo "<h4><a href='admin.php' class='btn pull-right btn-link' onClick='this.value = 'Canceling...''><img src='../stuff/images/close.png'> Cancel Editing</a></h4>"; }} ?>
        <h3>Today's absent teachers</h3>
        <div id="data">
		<table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Teacher</th>
              <th>Replaced Periods</th>
              <th>Comments</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
			<?php
			if (isset($_GET['edit'])) { 
				if ($_GET['edit'] == 1) {
					if (isset($_GET['id'])) {
						$formAction = "../stuff/scripts/editteacher.php"; 
					
						$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
						mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
						//Get information by absentId
						if (isset($_GET['id'])) {
							$id = $_GET['id'];
							$sql = "SELECT users.email, absentteachers.comments, absentperiods.Period1, absentperiods.Period2, absentperiods.Period3, absentperiods.Period4, absentperiods.Period5, absentperiods.Period6, absentperiods.Period7, absentperiods.Period8, absentperiods.Period9
									FROM absentteachers 
									INNER JOIN absentperiods ON absentteachers.periodsId = absentperiods.PeriodsId
									INNER JOIN teachers ON absentteachers.teacherId = teachers.teacherId
									INNER JOIN users ON teachers.userId = users.userId
									WHERE absentteachers.absentId = '{$id}';";
							$result = mysql_query($sql);
							$a = mysql_fetch_array($result);
					
							$teacheremail = "value='" . $a['email'] . "'";
							$comments = "value='" . $a['comments'] . "'";
							if ($a['Period1'] == 1) { $P1s = " checked"; } else { $P1s = NULL; };
							if ($a['Period2'] == 1) { $P2s = " checked"; } else { $P2s = NULL; };
							if ($a['Period3'] == 1) { $P3s = " checked"; } else { $P3s = NULL; };
							if ($a['Period4'] == 1) { $P4s = " checked"; } else { $P4s = NULL; };
							if ($a['Period5'] == 1) { $P5s = " checked"; } else { $P5s = NULL; };
							if ($a['Period6'] == 1) { $P6s = " checked"; } else { $P6s = NULL; };
							if ($a['Period7'] == 1) { $P7s = " checked"; } else { $P7s = NULL; };
							if ($a['Period8'] == 1) { $P8s = " checked"; } else { $P8s = NULL; };
							if ($a['Period9'] == 1) { $P9s = " checked"; } else { $P9s = NULL; };
							$buttonString = "Update Teacher";
							
							mysql_close($con);
						}
					} else {
						$formAction = "../stuff/scripts/addteacher.php";
						$buttonString = "Add Teacher";
					}
				} else { 
					$formAction = "../stuff/scripts/addteacher.php";
					$buttonString = "Add Teacher";
				}
			} else {
				$formAction = "../stuff/scripts/addteacher.php"; 
				$buttonString = "Add Teacher";
			} 
			
				?>
			  <form method="POST" action="<?php echo $formAction ?>">
              <td>
                <input type="email" id="teacheremail" class="input-block-level input-large" placeholder="Teacher Name" name="teacheremail" <?php if (isset($teacheremail)) { echo $teacheremail . " disabled";}?>>
			  </td>
              <td>
                <label class="checkbox inline" for="period1">
                  <input type="checkbox" value="true" id="period1" name="P1"<?php if (isset($P1s)) { echo $P1s; }?>>
                  <span>P1</span>
                </label>
                <label class="checkbox inline" for="period2">
                  <input type="checkbox" value="true" id="period2" name="P2"<?php if (isset($P2s)) { echo $P2s; }?>>
                  <span>P2</span>
                </label>
                <label class="checkbox inline" for="period3">
                  <input type="checkbox" value="true" id="period3" name="P3"<?php if (isset($P3s)) { echo $P3s; }?>>
                  <span>P3</span>
                </label>
                <label class="checkbox inline" for="period4">
                  <input type="checkbox" value="true" id="period4" name="P4"<?php if (isset($P4s)) { echo $P4s; }?>>
                  <span>P4</span>
                </label>
                <label class="checkbox inline" for="period5">
                  <input type="checkbox" value="true" id="period5" name="P5"<?php if (isset($P5s)) { echo $P5s; }?>>
                  <span>P5</span>
                </label>
                <label class="checkbox inline" for="period6">
                  <input type="checkbox" value="true" id="period6" name="P6"<?php if (isset($P6s)) { echo $P6s; }?>>
                  <span>P6</span>
                </label>
                <label class="checkbox inline" for="period7">
                  <input type="checkbox" value="true" id="period7" name="P7"<?php if (isset($P7s)) { echo $P7s; }?>>
                  <span>P7</span>
                </label>
                <label class="checkbox inline" for="period8">
                  <input type="checkbox" value="true" id="period8" name="P8"<?php if (isset($P8s)) { echo $P8s; }?>>
                  <span>P8</span>
                </label>
                <label class="checkbox inline" for="period9">
                  <input type="checkbox" value="true" id="period9" name="P9"<?php if (isset($P9s)) { echo $P9s; }?>>
                  <span>P9</span>
                </label>
              </td>
              <td>
                <input type="text" class="input-block-level input-large" placeholder="Comments" name="comments" autocomplete="off" <?php if (isset($comments)) { echo $comments; }?>>
              </td>
              <td>
				<?php if (isset($_GET['edit'])) { if (isset($_GET['id'])) { echo "<input type='hidden' name='Id' value='{$id}' />";  }} ?>
                <button type="submit" class="btn btn-block btn-primary"><?php echo $buttonString ?></button>
              </td>
			</form>
            </tr>
			<?php
			date_default_timezone_set('UTC'); 
			$yesterday = date('Y-m-d',strtotime("-1 days"));
			$yesterdayString = $yesterday . " 23:59:59";
			
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Error connecting to database: " . mysql_error() . "</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Error selecting the database " . DATABASE_NAME . ":" . mysql_error() . "</p>");
			
			$raw_results = mysql_query("SELECT absentteachers.absentId, users.firstName, users.lastName, users.email, absentteachers.comments, absentperiods.Period1, absentperiods.Period2, absentperiods.Period3, absentperiods.Period4, absentperiods.Period5, absentperiods.Period6, absentperiods.Period7, absentperiods.Period8, absentperiods.Period9
										FROM absentteachers 
										INNER JOIN absentperiods ON absentteachers.periodsId = absentperiods.PeriodsId
										INNER JOIN teachers ON absentteachers.teacherId = teachers.teacherId
										INNER JOIN users ON teachers.userId = users.userId
										WHERE absentteachers.date > '$yesterdayString'
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
				echo "<td><a href='admin.php?edit=1&id={$results['absentId']}'>Edit</a> - <a href='../stuff/scripts/deleteteacher.php?id={$results['absentId']}&teacheremail={$results['email']}'>Delete</a></td>";
				echo "</tr>";
            }
			
			    
			}else{
			echo "<tr>";
				echo "<td>No absent teachers today</td>
				<td></td>
				<td></td>
				<td></td>";
				echo "</tr>";
           	}
			
			
	mysql_close($con);

			
?>
            </tbody>
        </table><br>
		</div>
	</div>
    </div>
	</body>

</html>