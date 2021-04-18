<?php
	if (basename($_SERVER['SCRIPT_NAME'],".php") != "login" && basename($_SERVER['SCRIPT_NAME'],".php") != "logout")
	$_SESSION['lastpage'] = $_SERVER['SCRIPT_NAME'];
?>
	<div id="menue" class="w3-bar w3-black">
		<a href="index.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Startseite</a>
		<?php if(isset($_SESSION['userid'])){?>
			<div class="w3-dropdown-hover w3-right w3-bar">
				<button class=" w3-bar-item w3-hover-lime w3-mobile w3-button w3-center"><?php echo 'Angemeldet als '. $_SESSION['username'];?></button>
				<div class="w3-dropdown-content w3-bar-block w3-card-4 drop" style="right:0">
					<a href="login/profile.php" class="w3-bar-item w3-button">Profil</a>
					<a href="login/order.php" class="w3-bar-item w3-button">Bestellungen</a>
					<a href="login/logout.php" class="w3-bar-item w3-button">Abmelden</a>
				</div>
			</div>
		<?php }else{?>
			<a href="login/login.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Anmelden / Registrieren</a>
		<?php }?>
	</div>
		