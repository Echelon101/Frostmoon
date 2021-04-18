<?php 
include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname;", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>   
        <base href="../">
        <?php include '../php/headmeta.php';?>
        <style type="text/css">
		.npadding-r{
		padding-right: 0px!important;
		}
		.npadding-l{
		padding-left: 0px!important;
		}
		</style>
    </head>
		<?php include '../php/cookiemodal.php';?>
		<?php include '../php/navigation.php';
		//Get UserInfo
		$Profile_getInfo_statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
		$Profile_getInfo_result = $Profile_getInfo_statement->execute(array($_SESSION['userid']));
		$Profile_getInfo_fetch = $Profile_getInfo_statement->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="w3-row-padding" style="margin-top:2%; margin-bottom: 2%;">
			<div style="width: 32.5%" class="w3-col">
				<p></p>
			</div>
			<div style="width: 35%" class="w3-col">
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
						<div class="w3-threequarter divmobile npadding-l">
							<input type="text" name="street" placeholder="Straße" class="w3-input" value="<?php echo $Profile_getInfo_fetch['street'];?>" required>
						</div>
						<div class="w3-quarter strmobile npadding-r">
							<input type="text" name="hsnr" placeholder="Nummer" class="w3-input mobile" value="<?php echo $Profile_getInfo_fetch['hsnr'];?>" required>
						</div>
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">PLZ und Stadt</label><br>
						<div class="w3-quarter divmobile npadding-l">
							<input type="text" maxlength="5" name="plz" placeholder="PLZ" class="w3-input" value="<?php echo $Profile_getInfo_fetch['plz'];?>" required> 
						</div>
						<div class="w3-threequarter strmobile npadding-r">
							<input type="text" name="city" placeholder="Stadt" class="w3-input" value="<?php echo $Profile_getInfo_fetch['city'];?>" required>
						</div>
					</div>
					<div><p></p></div>
					<div class="w3-center">
					<button type="submit" class="w3-button w3-black">Ändern</button>
					</div>
				</form>
			</div>
			<div style="width: 32.5%" class="w3-col">
				<p></p>
			</div>
		</div>
		<div class="w3-row w3-center">
			<div>
				<a href="admin/edit.php?a=p&o=profile&id=<?php echo $_SESSION['userid'];?>" class="w3-button w3-black">Passwort Ändern</a>
			</div>
		</div>
    </body>
</html>