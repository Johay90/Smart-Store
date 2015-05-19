<?php
include_once 'db/config.php';
session_start();
check_login();

if (isset($_POST['pwchgsubmit'])){
	$currpassword = $_POST['currpassword'];
	$newpass = $_POST['newpassword'];
	$verifypass = $_POST['verifypassword']; //TODO: 2nd pass - might be best to rename this var. Confusing in the scope of this script.

	if (!empty($currpassword) && !empty($newpass) && !empty($verifypass) && $newpass == $verifypass){
		$conn = dbh(); // db connection

		// Getting hashed password
		$sth = $conn->prepare("SELECT password FROM users WHERE username = :username");
		$sth->bindParam(':username', $_SESSION['user']);
		$sth->execute();
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		$hashed_password = $result['password'];

		$verify_password = password_verify($currpassword, $hashed_password);

		if ($verify_password === TRUE){
			$options = [
			'cost' => 11,
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
			];
			$updatepass = password_hash($newpass, PASSWORD_DEFAULT, $options);

			$std = $conn->prepare("UPDATE users SET password = :password WHERE username = :username");
			$std->bindParam(':username', $_SESSION['user']);
			$std->bindParam(':password', $updatepass);
			$std->execute();

			$pwOutput = "Your password has been changed.";

		}else{
			$pwOutput = "Current password is wrong.";
		}

	}elseif (empty($currpassword)){
		$pwOutput = "Please type in your current password";
	}elseif ($newpass != $verifypass){
		$pwOutput = "Your new password do not match.";
	}else{
		$pwOutput = "please fill out all the password fields.";
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

			<div id="content-settings">
			<b><?php if (!empty($pwOutput)){echo $pwOutput;}else { echo "Change Account settings"; } ?></b><br />

			<div style="display: inline-block; float: left;">
			<form name="chg_password" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input type="password" name="currpassword" placeholder="Current Password"><br />
				<input type="password" name="newpassword" placeholder="New Password"><br />
				<input type="password" name="verifypassword" placeholder="Verify Password"><br />
				<center>
				<input type="submit" name="pwchgsubmit" class="login" value="Update Password"></center>
			</div>
			</form>

			<div style="display: inline-block; float: right;">
			<input type="text" name="password" placeholder="Current E-mail"><br />
			<input type="text" name="password" placeholder="New E-mail"><br />
			<center>
			<input type="submit" name="loginsubmit" class="login" value="Update E-mail"></center></div>
			</div>

			<div id="content-address">
			<b>Change/Add address</b><br />
			<input type="text" name="password" placeholder="Address Line 1" size="60"><br />
			<input type="text" name="password" placeholder="Address Line 2" size="60"><br />
			<input type="text" name="password" placeholder="Address Line 3" size="60"><br />
			<input type="text" name="password" placeholder="Address Line 4 (Postcode)" size="60"><br />
			<center>
			<input type="submit" name="loginsubmit" class="login" value="Update/Add Address"></center>

			</div><div style="clear:both"></div>

			<?php
			include_once 'footer.php';
			?>

		</div>

	</body>
</html>
