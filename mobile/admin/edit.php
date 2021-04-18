<?php
ob_start();
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edit</title>
		<base href="../">
		<?php include '../php/headmeta.php';?>
		<link href="customcss/buy.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="libs/jquery-ui-1.12.1/jquery-ui.min.css">
	  	<script src="libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
		<script src="libs/jquery-ui-1.12.1/jquery-ui.js"></script>
		<style type="text/css">
		#npadding-r{
		padding-right: 0px;
		}
		#npadding-l{
		padding-left: 0px;
		}
		</style>
	</head>
	<body>
    <script>
		function goBack() {
		    window.history.back();
		}
	</script>
	<?php
	if (isset($_GET['o'])){
		/*
		 * a = s -> Stornieren
		 * a = e -> Bearbeiten
		 * a = p -> User Password Reset
		 */	
		switch($_GET['o']){
			case 'order':
				switch ($_GET['a']){
					case 's' :
						$Order_Cancel_statement = $pdo->prepare("UPDATE orders SET state = ?");
						$Order_Cancel_result = $Order_Cancel_statement->execute(array('storniert'));
						header('location: ../login/order.php');
						break;
					default:
						break;
				}
				break;
			case 'profile':
				switch ($_GET['a']){
					case 'p' :
						$uError = Null;
						resetPassword($_GET['id'], $uError);
						break;
					case 'e' :
						$name = $_POST['name'];
						$sname = $_POST['surname'];
						$street = $_POST['street'];
						$hsnr = $_POST['hsnr'];
						$plz = $_POST['plz'];
						$city = $_POST['city'];
						$Profile_Edit_statement = $pdo->prepare("UPDATE users SET vorname = :vorname, nachname = :nachname, street = :street, hsnr = :hsnr, plz = :plz, city = :city WHERE id = :id");
						$Profile_Edit_result = $Profile_Edit_statement->execute(array('vorname' => $name, 'nachname' => $sname, 'street' => $street, 'hsnr' => $hsnr, 'plz' => $plz, 'city' => $city, 'id' => $_GET['id']));
						if($Profile_Edit_result){
							header('location: ../login/profile.php');
						}else{
							echo 'Beim abspeichern ist ein Fehler aufgetreten';
						}
						break;
					default:
						break;
				}
				break;
			default:
				break;
		}
		
	}
	if(isset($_GET['submitProfile'])){
		$User_ResetPassword_statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
		$User_ResetPassword_result = $User_ResetPassword_statement->execute(array($_GET['submitProfile']));
		$User_ResetPassword_fetch = $User_ResetPassword_statement->fetch(PDO::FETCH_ASSOC);
		$oldPassword = $_POST['oldPW'];
		$newPassword1 = $_POST['nPW1'];
		$newPassword2 = $_POST['nPW2'];
		$UserError = false;
		if(strlen($newPassword1) == 0){
			$UserErrormsg = 'Das Passwort Feld darf nicht Leer sein <br />';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
		}
		if($oldPW == $newPassword1){
			$UserErrormsg ='Das neue Passwort darf nicht mit dem Alten übereinstimmen';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
		}
		if($newPassword1 != $newPassword2){
			$UserErrormsg ='Die Passwörter müssen übereinstimmen';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
		}
		if($User_ResetPassword_fetch !== false && password_verify($oldPassword, $User_ResetPassword_fetch['password'])){
			if(!$UserError){
				$UserPassword_hash = password_hash($newPassword1, PASSWORD_DEFAULT);
				
				$User_SetPassword_statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
				$User_SetPassword_result = $User_SetPassword_statement->execute(array('password' => $UserPassword_hash, 'id' => $_GET['submitProfile']));
				if($User_SetPassword_result){
					header('location: ../login/logout.php?resetPW=1');
					die();
				}else{
					echo 'Beim abspeichern ist ein Fehler aufgetreten';
				}
			}
		}else{
			$UserErrormsg = 'Das Alte Passwort ist nicht korrekt';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
		}
	}
	function resetPassword($id, $errormsg){
		echo $errormsg;
		?>
		<div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
			<div class="w3-col" style="width:25%;">
			<p></p>
			</div>
			<div class="w3-col w3-container" style="width:50%;">
				<p style="text-decoration: underline; font-weight: bold; font-size: large; text-align: center;">Passwort Ändern</p>
				<form action="admin/edit.php?submitProfile=<?php echo $id;?>" method="post">
					<label>Altes Passwort</label>
					<input class="w3-input" type="password" name="oldPW" placeholder="*****">
					<label>Neues Passwort</label>
					<input class="w3-input" type="password" name="nPW1" placeholder="*****">
					<label>Neues Passwort Wiederholen</label>
					<input class="w3-input" type="password" name="nPW2" placeholder="*****">
					<br>
					<span onClick="goBack()" class="w3-button w3-black">Abbrechen</span>
					<button type="submit" class="w3-button w3-black">Ändern</button>
				</form>
				</div>
				<div class="w3-col" style="width:25%;">
					<p></p>
				</div>
			</div>
		<?php 
	}
	?>
	</body>
</html>