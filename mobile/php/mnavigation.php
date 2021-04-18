<?php
if (basename($_SERVER['SCRIPT_NAME'],".php") != "login" && basename($_SERVER['SCRIPT_NAME'],".php") != "logout")
	$_SESSION['lastpage'] = $_SERVER['SCRIPT_NAME'];
	?>
	<div id="menue" class="w3-bar w3-black" style="font-size:%;">
		<a href="index.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Startseite</a>
		<a href="sites/team.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Team</a>
		<a href="sites/events.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Events</a>
		<a href="sites/tickets.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Tickets</a>
		<a href="sites/medien.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Medien</a>
		<a href="sites/downloads.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Downloads</a>
		<a href="sites/kontakt.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Kontakt</a>
		<a href="dataprotection/auswahl.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Datenschutz</a>
		<a href="sites/agb.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">AGB's</a>
		<?php if(isset($_SESSION['userid'])){?>
			<div class="w3-center">
				<button onclick="showContent('accordion')" class="w3-disabled w3-button w3-block w3-center w3-hover-lime w3-black"><?php echo 'Angemeldet als '. $_SESSION['username'];?></button>
				<!--<div id="accordion" class="w3-hide w3-container w3-black w3-center"> -->
					<a href="login/profile.php" class="w3-bar-item w3-hover-lime w3-black w3-button" style="width:100%">Profil</a>
					<a href="login/order.php" class="w3-bar-item w3-hover-lime w3-black w3-button" style="width:100%">Bestellungen</a>
					<a href="login/logout.php" class="w3-bar-item w3-hover-lime w3-black w3-button" style="width:100%">Abmelden</a>
			</div>
		<?php }else{?>
			<a href="login/login.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Anmelden / Registrieren</a>
		<?php }?>
	</div>
	<script>
		function showContent(accordion) {
			var x = document.getElementById(accordion);
			if (x.className.indexOf("w3-show") == -1) {
				x.className += " w3-show";
			} else { 
				x.className = x.className.replace(" w3-show", "");
			}
		}
	</script>