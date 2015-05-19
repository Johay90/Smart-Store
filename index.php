<?php
session_start();
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
			<p>This website is an home made e-commerce site, with fully fledges systems such as shopping carts, payment systems, account settings - Admin features such as updating stock straight from the database, prices, support systems such as live chat etc.</p> 

			<p>This site is a sample site for my portfolio only and none of the items are actually purchasable, a payment system will work as a "virtual currency" only and no real currency will be exchanged. To test this website out please create an account and login.</p>

			<p>If you are a copyright owner of any content (images) please contact me and I'll remove the content</p>

			</div>

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
					<ul>
				</div>

			</div>

		</div>

	</body>
</html>