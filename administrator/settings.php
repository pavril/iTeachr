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
			require '../stuff/scripts/app_config.php';
		} else {
			header ("location: ../index.php");
		}
	
	}
?>
<!DOCTYPE HTML>
<html>
  
  <head>
    <title>Administrator Settings - iTeachr</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="../stuff/css/bootstrap.css">
    <link rel="stylesheet" href="../stuff/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="../stuff/css/jquery.autocomplete.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
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
                  <a href="admin.php" class="active">Home</a>
                </li>
                <li>
                  <a href="settings.php" class="active">Setting</a>
                </li>
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
    <div class="container-fluid">
      <h3 class="page-header">Settings</h3>
      <h4><b>General</b></h4>
      <div class="row-fluid">
        <div class="span4">
          <form class="form-vertical" method="post">
            <p>News Slideshow delay (in secs)<br></p>
            <input name="number" type="number" id="number" max="50" min="5" value="5">
            <p>
              <button type="submit" class="btn btn-primary">Change</button></p>
          </form>
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b>Warning!</b> You best check yourself, you're not looking so good.
          </div>
        </div>
        <div class="span4">
          <form>
            <p>Screens refresh delay (in mins)</p>
            <input name="number" type="number" id="number" max="10" min="1" value="5">
            <p>
              <button type="submit" class="btn btn-primary">Change</button></p>
          </form>
          <div class="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b>Warning!</b> You best check yourself, you're not looking so good.
          </div>
        </div>
      
      
        </div>
      </div>
    </div>
	<div id="footer">iTeachr powered by <a href="http://www.smartconstructions.net" target="_blank">Smartconstructions</a><span class="pull-right">European School of Mamer</span></div>
  </body>

</html>