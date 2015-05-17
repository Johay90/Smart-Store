<?php
error_reporting(E_ERROR);

// -- REGISTER SECTION --
if (isset($_POST['regbtn'])){
	$fname = $_POST['fstname'];
	$lname = $_POST['lstname'];
	$usrname = $_POST['usrname'];
	$psword = $_POST['psword'];
	$psword2 = $_POST['vfypsword'];
	$email = $_POST['email'];
	include("db/config.php");
	$conn = dbh();

	// database checks for email
	$sth = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
	$sth->bindParam(':email', $email);
	$sth->execute();
	$email_rows = $sth->fetchColumn(); 

	// database checks for username
	$sth = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :usrname");
	$sth->bindParam(':usrname', $usrname);
	$sth->execute();
	$username_rows = $sth->fetchColumn(); 

	// start of conditional statements
	if (!empty($fname) && !empty($lname) && !empty($usrname) && !empty($psword) && !empty($psword2) && !empty($email) && $psword == $psword2 && filter_var($email, FILTER_VALIDATE_EMAIL) && $email_rows == 0 && $username_rows == 0){

		$rOutput = "Thank for submitting your information.";

		// Info is correct, password hashing now
		$options = [
		'cost' => 11,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
		$hashed_password = password_hash($psword, PASSWORD_DEFAULT, $options);

		// add data to db
		$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password, email) VALUES (:fname, :lname, :usrname, :hashed_password, :email)");
		$stmt->bindParam(':fname', $fname);
		$stmt->bindParam(':lname', $lname);
		$stmt->bindParam(':usrname', $usrname);
		$stmt->bindParam(':hashed_password', $hashed_password);
		$stmt->bindParam(':email', $email);
		$stmt->execute();

	}elseif ($psword != $psword2){

		$rOutput = "Passwords do not match!";

	}else if ($email_rows >= 1){

		$rOutput = "This e-mail address is already registered.";

	}else if ($username_rows >= 1){

		$rOutput = "This username is already registered.";

	}else{

		$rOutput = "Please fill out all the fields correctly.";
	}

}

?>

<html>
<body>
	<head>
		<Title>Smart Store - Made by Jonathan Mummery</Title>
		<link rel="Stylesheet" href="css/style.css">
	</head>

	<div id="wrapper">

		<div id="header">
			<ul>
				<li><a class="navlinks" href="#">Store</a></li>
				<li><a class="navlinks" href="#">Account</a></li>
				<li><a class="navlinks" href="#">Contact</a></li>
				<li><a class="navlinks" href="#">Offers</a></li>
				<li><a class="navlinks" href="login.php">Login</a></li>
				<li><a class="aboutlink" href="index.php">About</a></li>
				<p class="top">This website is not mobile friendly.</p>
			</ul>

		</div>

		<div id="content-loginform">
			<b>Already have an account?</b><br />
			<input type="text" name="username" placeholder="Type your username">
			<input type="text" name="password" placeholder="Type your password">
			<input type="submit" name="loginsubmit" class="login" value="Submit">

		</div>

		<div id="content-registerform">
			<?php 	
			if (!empty($rOutput)) { echo "<center><b>" . $rOutput . "</b></center>"; }
			else {echo "<b>Don't have an acocunt? Sign up!</b><br />";} 
			?>
			<form name="regform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input type="text" name="fstname"  placeholder="First Name">
				<input type="text" name="lstname"  placeholder="Surname">
				<input type="text" name="usrname"  placeholder="Username">
				<input type="password" name="psword"   placeholder="Password">
				<input type="password" name="vfypsword" placeholder="Verify Password">
				<input type="text" name="email"    placeholder="E-Mail">
				<p style="text-align: center;">
					<input name="regbtn" type="submit" class="login" value="Submit"></p>
				</form>

			</div><div style="clear:both"></div>

			<div id="footer">
				<div id="footer-content-logo">
					<img src="img/logo.png" width="200px" height="115px">
				</div>
				<div id="footer-content-text">
					<p>Suspendisse at feugiat elit. Ut imperdiet bibendum mi, quis faucibus turpis semper ac. Maecenas in arcu mattis tortor volutpat</p>
				</div>
				<div id="footer-content-links">
					<ul class="footer">
						<li class="footer"><a class="footerlinks" href="#">Contact</a></li>
						<li class="footer"><a class="footerlinks" href="#">Private Policy</a></li>
						<li class="footer"><a class="footerlinks" href="#">Terms of Service</a></li>
						<li class="footer"><a class="footerlinks" href="#">Copyright Notice</a></li>
						<li class="footer"><a class="footerlinks" href="#">FAQs</a></li>
						<li class="footer"><a class="footerlinks" href="#">Deliverys</a></li>
						<li class="footer"><a class="footerlinks" href="#">Warranty</a></li>
						<li class="footer"><a class="footerlinks" href="#">Support</a></li>
						<li class="footer"><a class="footerlinks" href="#">About Us</a></li>
						<ul>
						</div>

					</div>

				</div>

			</body>
			</html>