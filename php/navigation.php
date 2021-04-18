<?php
	//prevent automatic redirect after login to certain sites
	if (basename($_SERVER['SCRIPT_NAME'],".php") != "login" && basename($_SERVER['SCRIPT_NAME'],".php") != "logout" && basename($_SERVER['SCRIPT_NAME'],".php") != "buy" && basename($_SERVER['SCRIPT_NAME'], ".php") != "register")
	$_SESSION['lastpage'] = $_SERVER['SCRIPT_NAME'];
?>
<div class="w3-bar w3-black">
	<a href="index.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Startseite</a>
	<a href="sites/team.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Team</a>
	<a href="sites/events.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Events</a>
	<a href="sites/tickets.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Tickets</a>
	<a href="sites/medien.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Medien</a>
	<a href="sites/downloads.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Downloads</a>
	<a href="sites/kontakt.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile">Kontakt</a>
	<?php if(isset($_SESSION['userid'])){?>
		<div class="w3-dropdown-hover w3-right">
	      <button class="w3-button w3-hover-lime"><?php echo 'Angemeldet als '. $_SESSION['username'];?></button>
	      <div class="w3-dropdown-content w3-bar-block w3-card-4 drop" style="right:0">
	      	<?php if(isset($_SESSION['admin'])){if($_SESSION['admin']){?>
	      	<a href="admin/admin.php" class="w3-bar-item w3-button w3-hover-lime">Admin Bereich</a>
	      	<?php }}?>
	        <a href="login/profile.php" class="w3-bar-item w3-button w3-hover-lime">Profil</a>
	        <a href="login/order.php" class="w3-bar-item w3-button w3-hover-lime">Bestellungen</a>
	        <a href="login/logout.php" class="w3-bar-item w3-button w3-hover-lime">Abmelden</a>
	      </div>
	    </div>
	<?php }else{?>
	<a href="login/login.php" class="w3-bar-item w3-button w3-hover-lime w3-mobile w3-right">Anmelden / Registrieren</a>
	<?php }?>
</div>