<?php
session_start();
	if ( !isset( $_SESSION['user'] ) || time() - $_SESSION['login_time'] > 600){
		session_destroy();
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
		} else {
			header ("location: ../index.php");
		}
	
	}
?>
<!DOCTYPE HTML>
<html>
  
  <head>
    <title>About - iTeachr</title>
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
                  <a href="admin.php">Home</a></li>   
                <li>
                  <a href="about.php" class="active">About</a> 
                </li>
                <li>
                  <p class="navbar-text hidden-desktop">Logged in as <a href="# " class="navbar-link ">Username</a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
                </li>
              </ul>
              <p class="navbar-text visible-desktop pull-right">Logged in as <a href="# " class="navbar-link "><?php echo $first_name . " " . $last_name ?></a> - <a href="../stuff/scripts/logout.php" class="navbar-link ">Logout</a></p>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row-fluid">
        <h3 class="page-header">About</h3>
        <div class="row-fluid">
          <div class="span5">
            <p><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/lu/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/lu/88x31.png"></a></p>
            <p><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">iTeachr</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.smartconstructions.net/iTeachr" property="cc:attributionName" rel="cc:attributionURL">Photis Avrilionis</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/lu/deed.en_US">Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Luxembourg License</a></p>
            <p><a href="http://creativecommons.org/licenses/by-nc-nd/3.0/legalcode">Legal Code</a></p>
          </div>
          
        </div>
      </div>
    </div>
	</body>

</html>