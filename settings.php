<?php
include_once 'db/config.php';
session_start();
check_login();
$conn = dbh(); // db connection

// add/update address
if (isset($_POST['adupdate'])){ // TODO: This is a cheap hack. Should add proper address update/finder later on. Look @ http://postcodes.io/
	$address1 = $_POST['adline1'];
	$address2 = $_POST['adline2'];
	$address3 = $_POST['adline3'];
	$address4 = $_POST['adline4'];

	if (!empty($address1) && !empty($address2) && !empty($address3) && !empty($address4)){

		$std = $conn->prepare("UPDATE address SET Address1 = :ad1, Address2 = :ad2, Address3 = :ad3, Address4 = :ad4 WHERE user_ID = :id");
		$std->bindParam(':id', $_SESSION['id']);
		$std->bindParam(':ad1', $address1);
		$std->bindParam(':ad2', $address2);
		$std->bindParam(':ad3', $address3);
		$std->bindParam(':ad4', $address4);
		$std->execute();
		$aOutput = "Updated address.";
	}else{
		$aOutput = "Please fill all the fields.";
	}
}

// Lets get some info for placeholder text below
$sth = $conn->prepare("SELECT * FROM users WHERE username = :username");
$sth->bindParam(':username', $_SESSION['user']);
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);
$holderemail = $result['email'];

$sth = $conn->prepare("SELECT * FROM address WHERE user_ID = :id");
$sth->bindParam(':id', $_SESSION['id']);
$sth->execute();
$addressvalue = $sth->fetch(PDO::FETCH_ASSOC);

// email change/update
if (isset($_POST['chgemail'])) {
	$curremail = $_POST['curremail'];
	$newemail = $_POST['newemail'];

	if (!empty($curremail) && !empty($newemail) && filter_var($curremail, FILTER_VALIDATE_EMAIL) && filter_Var($newemail, FILTER_VALIDATE_EMAIL)){

		// get current email address
		$sth = $conn->prepare("SELECT COUNT(*) from users WHERE email = :email");
		$sth->bindParam(':email', $curremail);
		$sth->execute();
		$emailrows = $sth->fetchColumn();

		if ($emailrows == 1){

			// update new address
			$std = $conn->prepare("UPDATE users SET email = :email WHERE username = :username");
			$std->bindParam(':email', $newemail);
			$std->bindParam(':username', $_SESSION['user']);
			$std->execute();

			$eOutput = "E-Mail address has been updated!";

		}else{
			$eOutput = "This is not the current email address";
		}

	}else{
		$eOutput = "Please fill in all the e-mail fields correctly.";
	}

}

// password change
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
			<b>
				<?php
				if (!empty($pwOutput)){echo $pwOutput;}
				elseif (!empty($eOutput)){echo $eOutput;
				}else { echo "Change Account settings"; } ?></b><br />

			<div style="display: inline-block; float: left;">
			<form name="chg_password" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input type="password" name="currpassword" placeholder="Current Password"><br />
				<input type="password" name="newpassword" placeholder="New Password"><br />
				<input type="password" name="verifypassword" placeholder="Verify Password"><br />
				<center>
				<input type="submit" name="pwchgsubmit" class="login" value="Update Password"></center>
			</div>
			</form>

			<form name="emailchg" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div style="display: inline-block; float: right;">
				<input type="text" name="curremail" value="<?php echo $holderemail; ?>"><br />
				<input type="text" name="newemail" placeholder="New E-mail"><br />
				<center>
				<input type="submit" name="chgemail" class="login" value="Update E-mail"></center></div>
		</div></form>

			<div id="content-address">
			<b><?php if (!empty($aOutput)){echo $aOutput;}else{ echo "Update / change your address";}?></b><br />
			<form name="adform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input type="text" name="adline1" value="<?php echo $addressvalue['Address1'];?>" size="60"><br />
				<input type="text" name="adline2" value="<?php echo $addressvalue['Address2'];?>" size="60"><br />
				<input type="text" name="adline3" value="<?php echo $addressvalue['Address3'];?>" size="60"><br />
				<input type="text" name="adline4" value="<?php echo $addressvalue['Address4'];?>" size="60"><br />
				<center>
				<input type="submit" name="adupdate" class="login" value="Update/Add Address"></center>
		</form>

			</div><div style="clear:both"></div>

			<?php
			include_once 'footer.php';
			?>

		</div>

	</body>
</html>
