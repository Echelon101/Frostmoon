<?php include '../php/phpopening.php';?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Tickets</title>
        <base href="../">
        <?php include '../php/headmeta.php';?>
		<?php include '../php/snapheadmeta.php';?>
    </head>
    <?php include '../php/cookiemodal.php';?>
		<div class="snap-drawers w3-black">
            <div class="snap-drawer snap-drawer-left w3-black">
                <div>
                    <h4 class="w3-center">Menü</h4>
						<?php include '../php/mnavigation.php';?>
                </div>
            </div>
            <div class="snap-drawer snap-drawer-right"></div>
        </div>
        <div id="content" class="snap-content">
            <div id="toolbar" style="margin-top: 1%;">
				<button id="MenueButton" class="material-icons w3-button" style="font-size:48px;">&#xe5d2;</button>
			</div>
			<div class="w3-justify" style="margin: 5%;">       
				<p>Tickets erhalten Sie unter dem gewünschten Event.</p> 
				Es wird unterschieden zwischen <span style="font-weight: bold;">„Standard Ticket“</span> und <span style="font-weight: bold;">„Premium Ticket“</span>: <br>
				<br>
				<span style="font-weight: bold;">Standard Ticket</span><br>
				Dieses Ticket enthält: <br>
				den Eintritt, <br>
				eine Garderoben-Nummer (für z.B. Jacken oder Gepäck)<br>
				freie Platzwahl, lediglich der Bereich vor der Bühne ist mit diesem Ticket nicht zugänglich <br>
				<br>
				<span style="font-weight: bold;">Premium Ticket</span><br>             
				Dieses Ticket enthält:<br>
				den Eintritt, <br>
				zwei Garderoben-Nummern (für z.B. Jacken oder Gepäck)<br>
				freie Platzwahl inkl. Bereich vor der Bühne <br>
				Freigetränke je nach Event <br>
				<hr>
				Die Preise der Tickets variieren je nach Event. Das "Premium Ticket" kostet immer mehr als das "Standard Ticket".
				<hr>
				Beim Kauf der Tickets können Sie sich entscheiden, ob Sie eine Rechnung zugeschickt bekommen wollen
				oder ob Sie bei der Abholung bezahlen wollen.
				<hr>
				Bitte beachten Sie, dass wir ein Mindestalter vorraussetzen. Dieses können Sie bei dem jeweiligen Event einsehen. Wir bitten deshalb
				um Ihr Verständis, wenn wir am Eingang nach Ihrem Ausweis oder ggf. Führerschein fragen. Halten Sie
				bitte für diesen Zweck das entsprechende Dokument griffbereit.
				<hr>
				Wir bitten unsere minderjährigen Fans einen sogenannten "Muttizettel" ausfüllen zu lassen.
				Diesen erhalten Sie <a href="sites/downloads.php">hier</a>.
		    </div>
			<?php include '../php/mfooter.php';?>
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
    </body>
</html>