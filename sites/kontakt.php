<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Kontakt</title>
        <base href="../">
        <?php include '../php/headmeta.php';?>
		<link href="customcss/iframe.css" type="text/css" rel="stylesheet">
    </head>
	<?php include '../php/cookiemodal.php';?>
    	<?php include '../php/navigation.php';?>
		<div id="placeholder">
			<p></p>	
		</div>
        <div id="kontaktmusik" class="w3-display-container w3-center">
        	<p class="w3-center">
            	Verantwortlicher Musik: Herr Jansen <br />
              	Standort: 25337 Elmshorn  
			</p>
			<div class="">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d37744.08682936387!2d9.636545335478583!3d53.75378644687094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9f2103bd5235d357!2sBerufliche+Schule+Elmshorn%2C+Europaschule!5e0!3m2!1sde!2sde!4v1495399052428" width="500" height="400" frameborder="0" style="border:0" class="iborder breite w3-center" allowfullscreen></iframe>
			</div>
		</div>
        <div class="w3-row" style="margin-top: 3%;">
	    	<div class="w3-col" style="width:25%">
	    	<p></p>
	    	</div>
	        <div class="w3-col" style="width:50%">
	        	<?php 
	        	if(isset($_GET['request'])){
	        		mailContoller("timomrx@gmail.com", $_POST['email'], $_POST['subject'], $_POST['text']);
	        	}
	        	?>
				<form class="w3-conainer w3-center" action="sites/kontakt.php?request=1" method="post">
					<div class="w3-row-padding">
						<label class="w3-left">Ihre Email-Adresse</label>
						<input type="email" name="email" maxlength="250" placeholder="example@example.com" required class="w3-input">
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">Betreff</label>
						<input type="text" name="subject" maxlength="250" placeholder="Betreff" required class="w3-input">
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">Anliegen</label>
						<textarea rows="7" cols="50" name="text" class="w3-input w3-border" placeholder="Beschreiben Sie Ihr Anliegen"></textarea>
					</div>
					<br>
					<button type="submit" class="w3-button w3-black">Absenden</button>
				</form>
	      	</div>
	    	<div class="w3-col" style="width:25%">
	    		<p></p>
	    	</div>
		</div>
       	<?php include '../php/footer.php';?>
    </body>
</html>