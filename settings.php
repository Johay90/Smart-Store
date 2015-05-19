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

			<div id="content">
			<p>LEt the fun begin... (tomorrow)</p>

			</div>

			<?php
			include_once 'footer.php';
			?>

		</div>

	</body>
</html>