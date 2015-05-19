<?php
error_reporting(E_ERROR);
session_start();

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

// -- LOGIN --

if (isset($_POST['loginsubmit'])){
	include("db/config.php");
	$conn = dbh();
	$username = $_POST['username'];
	$password = $_POST['password'];

	// username checks
	$sth = $conn->prepare("SELECT username FROM users WHERE username = :username");
	$sth->bindParam(':username', $username);
	$sth->execute();
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	$verifyuser = $result['username'];

	if ($verifyuser == $username){

		// Getting hashed password
		$sth = $conn->prepare("SELECT password FROM users WHERE username = :username");
		$sth->bindParam(':username', $username);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$hashed_password = $result['password'];
		$verify_password = password_verify($password, $hashed_password);

		if ($verify_password === TRUE){
		// Get the ID for to store it into a session
		$sth = $conn->prepare("SELECT id FROM users WHERE username = :username");
		$sth->bindParam(':username', $username);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$id = $result['id'];

		// Logging them in (adding session etc);
		$_SESSION['id'] = $id;
		$_SESSION['user'] = $username;
		header("Location: member.php");
		}

	}else{
		$lOutput = "Details were not correct";
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

		<?php
			include_once 'nav.php';
		?>

		<div id="content-loginform">
		<?php
		if (isset($_SESSION['id'])) {
			 header("Location: member.php");
		}?>
		<form name="loginform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<?php
			if (!empty($lOutput)) { echo "<center><b>" . $lOutput . "</b></center>"; }
			else { echo "<b>Have an account already?</b><br />";}
			?>
			<input type="text" name="username" placeholder="Type your username">
			<input type="password" name="password" placeholder="Type your password">
			<input type="submit" name="loginsubmit" class="login" value="Submit">
		</form>

		</div>

		<div id="content-registerform">
			<?php
			if (!empty($rOutput)) { echo "<center><b>" . $rOutput . "</b></center>"; }
			else {echo "<b>Don't have an account? Sign up!</b><br />";}
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

			<?php
			include_once 'footer.php';
			?>
			</body>
			</html>
