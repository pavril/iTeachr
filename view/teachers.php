<?php
session_start();
	if ( !isset( $_SESSION['user'] ) ){
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
	header ("location: ../login.php?login.php?msg=Login%20is%20required!&type=warning&request=$curPageURL");
	} else {
	
		if (($_SESSION['userrole'] = 3)) {
			require '../stuff/scripts/app_config/iTeachrViewerAccount.php';
			date_default_timezone_set('UTC');
			
echo '<table class="table table-striped">
            <thead>
              <tr>
                <th>
                  <font size="6">Teacher</font>
                </th>
                <th>
                  <font size="6">Replaced Periods</font>
                </th>
              </tr>
            </thead>
            <tbody>';
			
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
				if (!($results['comments'] == NULL)) {
					$absentperiods = $absentperiods . " - " . $results['comments'];
				}
				echo "<tr>";
				echo "<td><font size='4.5'>{$results['firstName']} <b>{$results['lastName']}</b></font></td>";
				echo "<td><font size='4.5'>{$absentperiods}</font></td>";
				echo "</tr>";
            }
			
			    
			}else{
			echo "<tr>";
				echo "<td><font size='4.5'>No absent teachers today</font></td>
				<td></td>
				<td></td>";
				echo "</tr>";
           	}
			
			
	mysql_close($con);

            echo'</tbody>
          </table>';
		  
		} else {
			echo "<font size='4.5'>Error. Can't display absent teachers for the moment.</font>";
		}
	
	}
?>