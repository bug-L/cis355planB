<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program logs the user in by setting $_SESSION variables
 * ---------------------------------------------------------------------------
 */

// Start or resume session, and create: $_SESSION[] array
session_start(); 

require 'database.php';

if ( !empty($_POST)) { // if $_POST filled then process the form

	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	$passwordhash = MD5($password);
	// echo $password . " " . $passwordhash; exit();
	// robot 87b7cb79481f317bde90c116cf36084b
		
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM fr_persons WHERE email = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$passwordhash));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['fr_person_id'] = $data['id'];
		$sessionid = $data['id'];
		$_SESSION['fr_person_title'] = $data['title'];
		Database::disconnect();
		header("Location: fr_assignments.php?id=$sessionid ");
		// javascript below is necessary for system to work on github
		echo "<script type='text/javascript'> document.location = 'fr_assignments.php?id=' + $sessionid; </script>";
		exit();
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
	}
} 
// if $_POST NOT filled then display login form, below.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
		
			<div class="row">
				<img src="svsu_fr_logo.png" />
			</div>
			
			<!--
			<div class="row">
				<br />
				<p style="color: red;">System temporarily unavailable.</p>
			</div>
			-->

			<div class="row">
				<h3>Volunteer Login</h3>
			</div>

			<form class="form-horizontal" action="login.php" method="post">
								  
				<div class="control-group">
					<label class="control-label">Username (Email)</label>
					<div class="controls">
						<input name="username" type="text"  placeholder="me@email.com" required> 
					</div>	
				</div> 
				
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input name="password" type="password" placeholder="not your SVSU password, please" required> 
					</div>	
				</div> 

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Sign in</button>
					&nbsp; &nbsp;
					<a class="btn btn-primary" href="fr_per_create2.php">Join (New Volunteer)</a>
				</div>
				
				<p><strong>Dear All</strong>: Thanks so much for volunteering! The April 2017 FIRST Robotics event at SVSU will be awesome with your help!</p>
				<p><strong>Dear NEW Volunteers</strong>: Please register by clicking the blue "Join" button above.</p>
				<p><strong>Dear Registered Volunteers</strong>: To log in, use your email address and password, and click the green "sign in" button.</p>
				<p><strong>Regarding passwords</strong>: Please create a new unique password for this site. <strong><em><span style="color: red;">Please do not use your regular SVSU password.</span><em></strong> If you forgot your password, to RE-SET your password for this site email "re-set password" to: Alissa Myers, aamyers1@svsu.edu.</p>
				
				<br />

				
			
				<p><strong>All volunteers will be provided a T-shirt to identify yourself as a volunteer; you also will receive a voucher for a meal on campus. </strong>We will be scheduling orientation and training sessions for volunteers to help you prepare and to answer your questions. More information on these sessions will be coming in the near future. Most volunteers will likely be stationed in or near the Ryder Center and field house, where the competition will be held.</p>

		
				
				<footer>
					<small>&copy; Copyright 2017, George Corser
					</small>
				</footer>
				
			</form>


		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
  
</html>
	

	