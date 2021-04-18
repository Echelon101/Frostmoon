<?php include '../php/phpopening.php';?>
<!DOCTYPE html>
<html>
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
			<div class="w3-container w3-teal">
				 <h1>Beispiel Album</h1>
				</div>
				<div class="w3-row-padding w3-margin-top">
				  <div class="w3-third">
					<div class="w3-card-2">
					  <img src="bilder/medien/bsp1.jpg" ALT="Bild" style="width:100%">
					  <div class="w3-container">
						<h5>Beispiel1</h5>
					  </div>
					</div>
				  </div>
				</div>
				<div class="w3-row-padding w3-margin-top">
				  <div class="w3-third">
					<div class="w3-card-2">
					  <img src="bilder/medien/bsp2.jpg" ALT="Bild" style="width:100%">
					  <div class="w3-container">
						<h5>Beispiel2</h5>
					  </div>
					</div>
				  </div>
				</div>
				<div class="w3-row-padding w3-margin-top">
				  <div class="w3-third">
					<div class="w3-card-2">
					  <img src="bilder/medien/bsp1.jpg" ALT="Bild" style="width:100%">
					  <div class="w3-container">
						<h5>Beispiel3</h5>
					  </div>
					</div>
				  </div>
				</div>
				<div class="w3-row-padding w3-margin-top">
				  <div class="w3-third">
					<div class="w3-card-2">
					  <img src="bilder/medien/bsp2.jpg" ALT="Bild" style="width:100%">
					  <div class="w3-container">
						<h5>Beispiel4</h5>
					  </div>
					</div>
				  </div>
				</div>
			<!-- -----------Footer----------------------------------------- -->
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