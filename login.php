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
				<b>Already have an account?</b><br />
					<form name="regform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<input type="text" name="fstname"  placeholder="First Name">
						<input type="text" name="lstname"  placeholder="Surname">
						<input type="text" name="usrname"  placeholder="Username">
						<input type="text" name="psword"   placeholder="Password">
						<input type="text" name="vfypsword" placeholder="Verify Password">
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

<?php
error_reporting(E_ERROR);
	if (isset($_POST['regbtn'])){
		// register form handling
		$fname = $_POST['fstname'];
		$lname = $_POST['lstname'];
		$usrname = $_POST['usrname'];
		$psword = $_POST['psword'];
		$psword2 = $_POST['vfypsword'];
		$email = $_POST['email'];

			if (!empty($fname) && !empty($lname) && !empty($usrname) && !empty($psword) && !empty($psword2) && !empty($email)){
				echo "Thank for submitting your information." . $fname;
			}else{
				echo "Please fill out all the fields.";
			}

	}



?>