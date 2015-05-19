<div id="header">
					<ul>
						<li><a class="navlinks" href="#">Store</a></li>
						<li><a class="navlinks" href="settings.php">Account</a></li>
						<li><a class="navlinks" href="#">Offers</a></li>
						<?php if (isset($_SESSION['user'])) {
						echo '<li><a class="navlinks" href="logout.php">Logout</a></li>';	
						}else{
						echo '<li><a class="navlinks" href="login.php">Login</a></li>';
						}?>
						<li><a class="aboutlink" href="index.php">About</a></li>
						<p class="top">This website is not mobile friendly.</p>
					</ul>

			</div>