<?php include '../php/phpopening.php';?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Downloads</title>
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
        </div>
        <div id="content" class="snap-content">
            <div id="toolbar" style="margin-top: 1%;">
				<button id="MenueButton" class="material-icons w3-button" style="font-size:48px;">&#xe5d2;</button>
			</div>
			<div class="w3-center" style="margin: 5%;">
			    <table class="w3-table-all">
					<tr class="w3-grey">
						<th>Beschreibung</th>
						<th>Download</th>
					</tr>
					<tr>
						<td>Muttizettel für Minderjährige Teilnehmer.</td>
						<td><a class="w3-button w3-black" href="documents/muttizettel.pdf" download="Muttizettel_JANmusic.pdf">Download</a></td>
					</tr>
				</table>
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