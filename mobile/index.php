<?php
	session_start();
		$counter_name = "../data/counter.txt";

	// Check if a text file exists. If not create one and initialize it to zero.
	if (!file_exists($counter_name)) {
	  $f = fopen($counter_name, "w");
	  fwrite($f,"0");
	  fclose($f);
	}

	// Read the current value of our counter file
	$f = fopen($counter_name,"r");
	$counterVal = fread($f, filesize($counter_name));
	fclose($f);

	// Has visitor been counted in this session?
	// If not, increase counter value by one
	if(!isset($_SESSION['hasVisited'])){
	  $_SESSION['hasVisited']="yes";
	  $counterVal++;
	  $f = fopen($counter_name, "w");
	  fwrite($f, $counterVal);
	  fclose($f);
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Startseite</title>
		<?php include 'php/headmeta.php';?>
		<?php include 'php/snapheadmeta.php';?>
        <!-- <link href="customcss/frostmoon.css" type="text/css" rel="stylesheet">-->
	</head>
    <?php 
	    if(isset($_SESSION['CookieJar'])){
	    echo '<body>';
	    }else{
	    echo'<body onload="JsCookieJar()">';
	    }
    ?>
		<?php if(isset($_GET['logout'])){
			$_SESSION['CookieJar']='1';
		}else{
			include 'php/CookieJar.php';
		}
		?>
		<div class="snap-drawers w3-black">
            <div class="snap-drawer snap-drawer-left w3-black">
                <div>
                    <h4 class="w3-center">Menü</h4>
						<?php include 'php/mnavigation.php';?>
                </div>
            </div>
        </div>
        <div id="content" class="snap-content">
            <div id="toolbar" style="margin-top: 1%;">
				<button id="MenueButton" class="material-icons w3-button" style="font-size:48px;">&#xe5d2;</button>
			</div>

			<p><img src="bilder/Logo.png" width="358" height="150" ALT="Digital Glance Text"/></p>
			<?php if(isset($_GET['logout'])){?>
			    <div class="w3-panel w3-pale-green w3-display-container">
					<span onclick="this.parentElement.style.display='none'"
					class="w3-button w3-pale-green w3-large w3-display-topright">&times;</span>
					<div class="w3-center">
						<h3>Erfolgreich!</h3>
						<p>Sie sind ausgeloggt</p>
					</div>
				</div>
				<?php }?>
				<?php if(isset($_GET['reset'])){?>
			    <div class="w3-panel w3-pale-green w3-display-container">
					<span onclick="this.parentElement.style.display='none'"
					class="w3-button w3-pale-green w3-large w3-display-topright">&times;</span>
					<div class="w3-center">
						<h3>Erfolgreich!</h3>
						<p>Passwort wurde geändert</p>
					</div>
				</div>
				<?php }?>
			<h1 style="margin-left: 2%; margin-right: 2%;"> Herzlich Willkommen auf unserer Seite!</h1>
			<div id="content1" class="w3-display-container w3-justify" style="margin-left: 3%; margin-right: 3%;">
			<p>
				Wir sind eine kleine Gruppe von Musikern, die auf EDM (Electronic Dance Music)
				stehen und auch selbst produzieren. Wir nennen uns "JANmusic", denn unsere Namen
				lauten Janne-Paul, André und Nina.
			</p>
			</div>
			<hr style="margin-left: 3%; margin-right: 3%;">
			<div id="content2" class="w3-display-container w3-justify" style="margin-left: 3%; margin-right: 3%;">
				Unsere Herzen schlagen in den Beats von EDM. Wir haben Spaß daran,
				selber etwas zu schreiben und wir sind von unserem Können überzeugt.
				Unser Plan ist es, unsere Leidenschaft und unsere Musik mit euch zu teilen.
				Wir planen mit einem kleinen ersten Event zu starten und dann immer öfter
				an verschiedenen Orten aufzutreten. Zur Unterstüzung möchten wir uns ein paar bekanntere
				Producer engagieren. <br>
				Wann, wo und welche Unterstüzung wir uns geholt haben, erfahrt ihr im Reiter Events!<br>
				Falls auch Du uns Unterstüzen willst, dann schau vorbei und genieße!
			</div>
			<hr style="margin-left: 3%; margin-right: 3%;">
			<div id="video1" class="w3-center">
				<h4>Hier etwas zum Anhören von uns:</h4>
				<video id="player" src="../videos/music.mp4" width="320" height="240" controls controlsList="nodownload" poster="../videos/music.PNG"></video>
			</div>	
			<?php include 'php/mfooter.php';?>
        </div>
        <script type="text/javascript" src="../libs/snap/snap.js"></script>
        <script type="text/javascript">
            var snapper = new Snap({
                element: document.getElementById('content')
            });
        </script>
		<script>
				MenueButton.addEventListener('click', function(){

			if( snapper.state().state=="left" ){
				snapper.close();
			} else {
				snapper.open('left');
			}

		});
		</script>
		<script>
			var video = document.getElementById('player');
				video.volume = 0.4;
		</script>
    </body>
</html>
