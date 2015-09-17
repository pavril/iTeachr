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
			require '../stuff/scripts/app_config/iTeachrUserAccount.php';
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
    <script type="text/javascript" src="../stuff/js/custom.js"></script>
    <link href="../stuff/css/overlaypopup.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <nav>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">              <span class="icon-bar"></span>        <span class="icon-bar"></span>        <span class="icon-bar"></span>      </a><a class="brand" href="index.php">iTeachr</a>
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
      <h3 class="page-header">Your Account</h3>
      <p>Name: <?php echo $first_name . " " . $last_name ?></p>
      <p>Email: <?php echo $email ?></p>
      <p><a href="#" class="show-popup-pass">Change password</a></p>
    </div>
    <div class="changepass">
      <div class="box-content">
        <span class="btn pull-right btn-link ">
          <button class="close-btn-pass"><img src="../stuff/images/close.png"></button>
        </span>
        <h4><b>Change password</b></h4>
        <form class="form-vertical" method="post" action="../stuff/scripts/chpass.php">
          <input type="password" name="oldpassetered" placeholder="Old password" class="input-large input-block-level">
          <input type="password" name="passone" placeholder="New password" class="input-large input-block-level">
          <input type="password" name="passtwo" placeholder="Confirm password" class="input-large input-block-level">
          <button type="submit" class="btn btn-primary">Change password</button>
        </form>
      </div>
    </div>
	</body>

</html>