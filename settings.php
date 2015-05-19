<?php
include_once 'db/config.php';
session_start();
check_login();
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
			<b>Change Account settings</b><br />

			<div style="display: inline-block; float: left;">
			<input type="password" name="password" placeholder="Current Password"><br />
			<input type="password" name="password" placeholder="New Password"><br />
			<input type="password" name="password" placeholder="Verify Password"><br />
			<center>
			<input type="submit" name="loginsubmit" class="login" value="Update Password"></center>
			</div>

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