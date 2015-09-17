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
			$email = $_SESSION['useremail'];
			$first_name = $_SESSION['userfirstname'];
			$last_name = $_SESSION['userlastname'];
			$studentid = $_SESSION['user'];
			require '../stuff/scripts/app_config/iTeachrViewerAccount.php';
			date_default_timezone_set('UTC');
		} else {
			header ("location: ../index.php");
		}
	
	}
?>
<!DOCTYPE HTML>
<html>
  
<head>
    <title>Viewer - iTeachr</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../stuff/css/bootstrap.css">
    <link rel="stylesheet" href="../stuff/css/bootstrap-responsive.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	<script>
	function updateClock ( )
	{
		var currentTime = new Date ( );

		var currentHours = currentTime.getHours ( );
		var currentMinutes = currentTime.getMinutes ( );
		var currentSeconds = currentTime.getSeconds ( );

		// Pad the minutes and seconds with leading zeros, if required
		currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
		currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

		// Choose either "AM" or "PM" as appropriate
		var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

		// Convert the hours component to 12-hour format if needed
		currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

		// Convert an hours component of "0" to "12"
		currentHours = ( currentHours == 0 ) ? 12 : currentHours;

		// Compose the string for display
		var currentTimeString = currentHours + ":" + currentMinutes +  " " + timeOfDay;

		// Update the time display
		document.getElementById("clock").firstChild.nodeValue = currentTimeString;
	}
</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<script>
    $(document).ready(function(){
        setInterval(function() {
            $("#latestData").load("teachers.php");
        }, 10000);
    });

</script>

	</script>
</head>
  
  <body onload="updateClock(); setInterval('updateClock()', 1000 ); ">

  
  <div id="navbar-example" class="navbar navbar-static">
              <div class="navbar-inner">
                <div class="container" style="width: auto;">
                  <a class="brand" href="#"><img src="../stuff/images/elogo.png" style="width:200px"></a>
                  <ul class="nav" role="navigation">
                    
                  </ul>
                  <ul class="nav pull-right">
				  <div data-spy="affix" data-offset-top="200">&nbsp;</div>
				  <p class="navbar-text"><font size="7"><b><span id="clock">&nbsp;</span></font><font size="6.5"></b> <?php $date = new DateTime(); 

echo  $date->format( '(l, F jS, Y)' );  ?></font></p>
                    <li id="fat-menu" class="dropdown">
                      
                    </li>
                  </ul>
                </div>
              </div>
            </div>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span6">
			<div id = "latestData">
				
			</div>
        </div>
		<div class="span6">
          <div id="slideShowImages">
            <?php
			$con=mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die("<p>Can't display news for the momment</p>");
			mysql_select_db(DATABASE_NAME) or die("<p>Can't display news for the momment</p>");
			
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
			
				echo "<p>No news is good news!</p>";
			
			}
			
			mysql_close($con);
			?>
          </div>
		  <script src="../stuff/js/slideShow.js"></script>
        </div>
      </div>
    </div>
	
	      <div id="footer">
		<a href="../stuff/scripts/logout.php">Logout</a></span>
	</div>
  </body>

</html>