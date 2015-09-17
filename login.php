<?php
	session_start();
	if (isset($_SESSION['user'])){
		if (($_SESSION['userrole'] == '0') OR ($_SESSION['userrole'] == '1')) {
			
			header("location: user/index.php");
			
		} elseif ($_SESSION['userrole'] == '3') {
				
			header("location: view/view.php");
		  
		} elseif ($_SESSION['userrole'] == '2') {
				
			header("location: administrator/admin.php");
		  
		}
	}else{
		
	}
?>

<!DOCTYPE HTML>
<html>
  
  <head>
    <title>Login - iTeachr</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="stuff/css/bootstrap.css">
    <link rel="stylesheet" href="stuff/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="stuff/css/jquery.autocomplete.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
  </head>
  
  <body>
     <nav>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="#">iTeachr</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li></li>
                <li></li>
                <li></li>
              </ul>
			  
			  <p class="navbar-text visible-desktop pull-right"><img src="stuff/images/elogo.png" style="width:140px" class="pull-right"></p>
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
						
							echo "<div class='alert alert-{$type}'>";
							echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>{$msg}</div>";
							echo "</div>";
							
						} else {
					
							echo "<div class='alert alert-default'>";
							echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>{$msg}</div>";
							echo "</div>";
					
					}
					}
			  ?>
    <div class="row-fluid">
       <div class="visible-desktop span3"></div>
          <div class="span6">
            <h2>Welcome to iTeachr</h2>
            <p>Please login to continue</p>
            <hr>
            <form action="stuff/scripts/validate_login.php" method="POST">
				<?php if (isset($_GET['e'])) {
					$e = urlencode(base64_decode($_GET['e']));
					$e = str_replace('%40', '@', $e);
					$value = "value='" . $e . "'";
				} else {
				$value  = NULL;
				}
				?>
              <input type="email" class="input-xxlarge input-block-level" placeholder="Email" name="uname" <?php echo $value ?>>
              <input type="password" class="ds-appended input-xxlarge input-block-level" placeholder="Password" name="passwd">
			  <?php if (isset($_GET['request'])) { echo '<input type="hidden" name="next" value="' . $_GET['request'] . '" />'; }?>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
          <div class="visible-desktop span3"></div>    
			
  </body>

</html>