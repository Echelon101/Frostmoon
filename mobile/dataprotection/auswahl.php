<?php include '../php/phpopening.php';?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Datenschutz</title>
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
                <button onclick="showContent('item1')" style="margin-top:1%;" class="w3-button w3-block w3-center w3-hover-lime w3-black">Datenschutzerklärung</button>
                    <div id="item1" class="w3-container w3-hide">
                        <?php include 'datenschutzerklaerung.php';?>
                    </div>
                <button onclick="showContent('item2')" style="margin-top:1%;" class="w3-button w3-block w3-center w3-hover-lime w3-black">Impressum</button>
                    <div id="item2" class="w3-container w3-hide">
                        <?php include 'impressum.php';?>
                    </div>
                <button onclick="showContent('item3')" style="margin-top:1%;" class="w3-button w3-block w3-center w3-hover-lime w3-black">Disclaimer</button>
                    <div id="item3" class="w3-container w3-hide">
                        <?php include 'disclaimer.php';?>
                    </div>
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
    </body>
</html>