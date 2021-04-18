<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname;", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <base href="../">
        <?php include '../php/headmeta.php';?>
        <?php include '../php/snapheadmeta.php';?>
         <style type="text/css">
		.npadding{
		padding-right: 0px!important;
		padding-left: 0px!important;
		}
		</style>
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
				<?php
			    $Profile_getInfo_statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
				$Profile_getInfo_result = $Profile_getInfo_statement->execute(array($_SESSION['userid']));
				$Profile_getInfo_fetch = $Profile_getInfo_statement->fetch(PDO::FETCH_ASSOC);
				?>
				<form action="admin/edit.php?a=e&o=profile&id=<?php echo $_SESSION['userid'];?>" method="post">
					<div class="w3-row-padding">
						<label>Vorname</label>
						<input type="text" class="w3-input" name="name" value="<?php echo $Profile_getInfo_fetch['vorname'];?>" required>
						</div>
						<div class="w3-row-padding">
						<label>Nachname</label>
						<input type="text" class="w3-input" name="surname" value="<?php echo $Profile_getInfo_fetch['nachname'];?>" required>
						</div>
						<div class="w3-row-padding">
							<label class="w3-left">Straße und Hausnr.</label><br>
							<div class="w3-threequarter divmobile npadding">
								<input type="text" name="street" placeholder="Straße" class="w3-input" value="<?php echo $Profile_getInfo_fetch['street'];?>" required>
							</div>
							<div class="w3-quarter strmobile npadding">
								<input type="text" name="hsnr" placeholder="Nummer" class="w3-input mobile" value="<?php echo $Profile_getInfo_fetch['hsnr'];?>" required>
							</div>
						</div>
						<div class="w3-row-padding">
						<label class="w3-left">PLZ und Stadt</label><br>
						<div class="w3-quarter divmobile npadding">
							<input type="text" maxlength="5" name="plz" placeholder="PLZ" class="w3-input" value="<?php echo $Profile_getInfo_fetch['plz'];?>" required> 
						</div>
						<div class="w3-threequarter strmobile npadding">
							<input type="text" name="city" placeholder="Stadt" class="w3-input" value="<?php echo $Profile_getInfo_fetch['city'];?>" required>
						</div>
					</div>
					<button type="submit" class="w3-button w3-black" style="margin-top:2%;">Ändern</button>
				</form>
				<br>
				<a href="admin/edit.php?a=p&o=profile&id=<?php echo $_SESSION['userid'];?>" class="w3-button w3-black">Passwort Ändern</a>
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