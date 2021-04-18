<?php
//allow mulitple header rewrite
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
	<script type="text/javascript">
			$( function() {
				$( "#datepicker" ).datepicker({ dateFormat: 'dd.mm.yy', inline: true});
			});
			$( function() {
				$( "#datepicker2" ).datepicker({ dateFormat: 'dd.mm.yy', inline: true});
			});
    </script>
    <script>
		function goBack() {
		    window.history.back();
		}
	</script>
	<?php
	if (isset($_GET['o'])){
		/*
		 * a = d -> delete
		 * a = s -> Stornieren
		 * a = e -> Bearbeiten
		 * a = r -> remove admin
		 * a = a -> add admin
		 * a = p -> User Password Reset
		 */	
		//Switch statement to simplify the prossecing of the variables passed by the invoking script
		switch($_GET['o']){
			case 'order':
				switch ($_GET['a']){
					case 'd' :
						$Order_Delete_statement = $pdo->prepare("DELETE FROM orders WHERE id = ?");
						$Order_Delete_result = $Order_Delete_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'e' :
						$errmsg = NULL;
						editOrder($_GET['id'], $errmsg);
						break;
					case 's' :
						$Order_Cancel_statement = $pdo->prepare("UPDATE orders SET state = ?");
						$Order_Cancel_result = $Order_Cancel_statement->execute(array('storniert'));
						header('location: ../login/order.php');
						break;
					default:
						break;
				}
				break;
			case 'event' :
				switch ($_GET['a']){
					case 'd' :
						$Event_Delete_statement = $pdo->prepare("DELETE FROM events WHERE id = ?");
						$Event_Delete_result = $Event_Delete_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'e' :
						editEvent($_GET['id']);
						break;
					default:
						break;
				}
				break;
			case 'team' :
				switch ($_GET['a']){
					case 'd' :
						$Team_Delete_statement = $pdo->prepare("DELETE FROM team WHERE id = ?");
						$Team_Delete_result = $Team_Delete_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'e' :
						editTeam($_GET['id']);
						break;
					default:
						break;
				}
				break;
			case 'user' :
				switch ($_GET['a']){
					case 'd' :
						$User_Delete_statement = $pdo->prepare("DELETE FROM users WHERE id = ?");
						$User_Delete_result = $User_Delete_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'a' :
						$User_Add_Admin_statement = $pdo->prepare("UPDATE users SET admin = 1 WHERE id = ?");
						$User_Add_Admin_result = $User_Add_Admin_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'r' :
						$User_Remove_Admin_statement = $pdo->prepare("UPDATE users SET admin = 0 WHERE id = ?");
						$User_Remove_Admin_result = $User_Remove_Admin_statement->execute(array($_GET['id']));
						header('location: admin.php');
						break;
					case 'e' :
						$edituserErr = NULL;
						editUser($_GET['id'], $edituserErr);
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
	if(isset($_GET['submitUser'])){
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		$error = false;
		if(strlen($password1) == 0){
			$pwErrMsg = 'Das Passwort Feld darf nicht Leer sein <br />';
			$error = true;
			editUser($_GET['submitUser'], $pwErrMsg);
			
		}elseif($password1 != $password2){
			echo 'Die Passwörter müssen übereinstimmen';
			$error = true;
		}
		if(!$error){
			$password_hash = password_hash($password1, PASSWORD_DEFAULT);
			submitUser($_GET['submitUser'], $password_hash);
		}
	}
	if(isset($_GET['submitOrder'])){
		$state = $_POST['state'];
		if($state != NULL){
			$Order_Edit_statement = $pdo->prepare("UPDATE orders SET state = ? WHERE id = ?");
			$Order_Edit_result = $Order_Edit_statement->execute(array($state, $_GET['submitOrder']));
			if($Order_Edit_result){
				header('location: admin.php');
			}else{
				echo 'Beim abspeichern ist ein Fehler aufgetreten';
			}
		}else{
			$errmsg = 'Bitte einen Status auswählen';
			editOrder($_GET['submitOrder'], $errmsg);
		}
	}
	if(isset($_GET['submitTeam'])){
		$teamVorname = $_POST['Vorname'];
		$teamNachname = $_POST['Nachname'];
		$teamBDay = $_POST['bdaydate'];
		$teamDescr = $_POST['tdescr'];
		$team_getImg_statement = $pdo->prepare("SELECT * FROM team WHERE id = ?");
		$team_getImg_result = $team_getImg_statement->execute(array($_GET['submitTeam']));
		$team_getImg_fetch = $team_getImg_statement->fetch(PDO::FETCH_ASSOC);
		$teamImage = $team_getImg_fetch['image'];
		if(isset($_FILES['teamfile'])){
			try {
				
				// Undefined | Multiple Files | $_FILES Corruption Attack
				// If this request falls under any of them, treat it invalid.
				if (
				!isset($_FILES['teamfile']['error']) ||
				is_array($_FILES['teamfile']['error'])
				) {
					throw new RuntimeException('Invalid parameters.');
				}
				
				// Check $_FILES['upfile']['error'] value.
				switch ($_FILES['teamfile']['error']) {
					case UPLOAD_ERR_OK:
						break;
					case UPLOAD_ERR_NO_FILE:
						throw new RuntimeException('No file sent.');
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						throw new RuntimeException('Exceeded filesize limit.');
					default:
						throw new RuntimeException('Unknown errors.');
				}
				
				// You should also check filesize here.
				if ($_FILES['teamfile']['size'] > 3000000) {
					throw new RuntimeException('Exceeded filesize limit.');
				}
				
				// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
				// Check MIME Type by yourself.
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				if (false === $ext = array_search(
						$finfo->file($_FILES['teamfile']['tmp_name']),
						array(
								'jpg' => 'image/jpeg',
								'png' => 'image/png',
								'gif' => 'image/gif',
						),
						true
						)) {
							throw new RuntimeException('Invalid file format.');
						}
						
						// You should name it uniquely.
						// DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
						// On this example, obtain safe unique name from its binary data.
						$sha1 = sha1_file($_FILES['teamfile']['tmp_name']);
						
						if (!move_uploaded_file(
								$_FILES['teamfile']['tmp_name'],
								sprintf('./../uploads/%s.%s',
										sha1_file($_FILES['teamfile']['tmp_name']),
										$ext
										)
								)) {
									throw new RuntimeException('Failed to move uploaded file.');
								}
								$teamImage = $sha1.'.'.$ext;
			}catch (RuntimeException $e) {
				echo $e->getMessage();
			}
		}
		$team_Edit_statement = $pdo->prepare("UPDATE team SET Vorname = :Vorname, Nachname = :Nachname, Geburtsdatum = :Geburtsdatum, descr = :descr, image = :image WHERE id = :id");
		$team_Edit_result = $team_Edit_statement->execute(array('Vorname' => $teamVorname, 'Nachname' => $teamNachname, 'Geburtsdatum' => $teamBDay, 'descr' => $teamDescr, 'image' => $teamImage, 'id' => $_GET['submitTeam']));
		if($team_Edit_result){
			header('location: admin.php');
		}else{
			echo 'Beim abspeichern ist ein Fehler aufgetreten';
		}
		
	}
	if(isset($_GET['submitEvent'])){
		$eventName = $_POST['eventname'];
		$eventPrice = $_POST['price'];
		$eventDate = $_POST['date'];
		$eventTime = $_POST['time'];
		$eventPlace = $_POST['place'];
		$eventAge = $_POST['age'];
		$eventDescription = $_POST['descr'];
		$Event_getImg_statement = $pdo->prepare("SELECT * FROM events WHERE id = ?");
		$Event_getImg_result = $Event_getImg_statement->execute(array($_GET['submitEvent']));
		$Event_getImg_fetch = $Event_getImg_statement->fetch(PDO::FETCH_ASSOC);
		
		$eventImage = $Event_getImg_fetch['imagepath'];
		if(isset($_FILES['upfile'])){
			try {
				
				// Undefined | Multiple Files | $_FILES Corruption Attack
				// If this request falls under any of them, treat it invalid.
				if (
				!isset($_FILES['upfile']['error']) ||
				is_array($_FILES['upfile']['error'])
				) {
					throw new RuntimeException('Invalid parameters.');
				}
				
				// Check $_FILES['upfile']['error'] value.
				switch ($_FILES['upfile']['error']) {
					case UPLOAD_ERR_OK:
						break;
					case UPLOAD_ERR_NO_FILE:
						throw new RuntimeException('No file sent.');
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						throw new RuntimeException('Exceeded filesize limit.');
					default:
						throw new RuntimeException('Unknown errors.');
				}
				
				// You should also check filesize here.
				if ($_FILES['upfile']['size'] > 3000000) {
					throw new RuntimeException('Exceeded filesize limit.');
				}
				
				// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
				// Check MIME Type by yourself.
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				if (false === $ext = array_search(
						$finfo->file($_FILES['upfile']['tmp_name']),
						array(
								'jpg' => 'image/jpeg',
								'png' => 'image/png',
								'gif' => 'image/gif',
						),
						true
						)) {
							throw new RuntimeException('Invalid file format.');
						}
						
						// You should name it uniquely.
						// DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
						// On this example, obtain safe unique name from its binary data.
						$sha1 = sha1_file($_FILES['upfile']['tmp_name']);
						
						if (!move_uploaded_file(
								$_FILES['upfile']['tmp_name'],
								sprintf('./../uploads/%s.%s',
										sha1_file($_FILES['upfile']['tmp_name']),
										$ext
										)
								)) {
									throw new RuntimeException('Failed to move uploaded file.');
								}
								$eventImage = $sha1.'.'.$ext;
			}catch (RuntimeException $e) {
				echo $e->getMessage();			
			}
		}
		$Event_Edit_statement = $pdo->prepare("UPDATE events SET eventname = :eventname, price = :price, eventdate = :eventdate, entrytime = :entrytime, maxage = :maxage, descr = :descr, imagepath = :imagepath WHERE id = :id");
		$Event_Edit_result = $Event_Edit_statement->execute(array('eventname' => $eventName, 'price' => $eventPrice, 'eventdate' => $eventDate, 'entrytime' => $eventTime, 'maxage' => $eventAge, 'descr' => $eventDescription, 'imagepath' => $eventImage, 'id' => $_GET['submitEvent']));
		if($Event_Edit_result){
			header('location: admin.php');
		}else{
			echo 'Beim abspeichern ist ein Fehler aufgetreten';
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
			exit();
		}elseif($oldPW == $newPassword1){
			$UserErrormsg ='Das neue Passwort darf nicht mit dem Alten übereinstimmen';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
			exit();
		}elseif($newPassword1 != $newPassword2){
			$UserErrormsg ='Die Passwörter müssen übereinstimmen';
			$UserError = true;
			resetPassword($_GET['submitProfile'], $UserErrormsg);
			exit();
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
	function editUser($id, $errmsg){
		include '../config/config.php';
		//$_SESSION['user_id'] = $id;
		$editUserDB = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
		$User_getInfo_statement = $editUserDB->prepare("SELECT * FROM users WHERE id = ?");
		$User_getInfo_result = $User_getInfo_statement->execute(array($id));
		$User_getInfo_fetch = $User_getInfo_statement->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="w3-row">
			<div class="w3-col" style="width:35%">
				<p></p>
			</div>
			<div class="w3-col" style="width:30%">
				<?php echo $errmsg;?>
				<p style="text-decoration: underline; font-weight: bold; font-size: large; text-align: center;">Passwort Zurücksetzen</p>
				<form action="admin/edit.php?submitUser=<?php echo $id;?>" method="post" class="w3-center">
					<label>Passwort</label>
					<input class="w3-input w3-border" type="password" name="password1">
					<label>Passwort Wiederholen</label>
					<input class="w3-input w3-border" type="password" name="password2">
					<br>
					<span onClick="goBack()" class="w3-button w3-black">Abbrechen</span>
					<button type="submit" class="w3-button w3-black">Zurücksetzen</button>
				</form>
			</div>
			<div class="w3-col" style="width:35%">
				<p></p>
			</div>
		</div>
		<?php
	}
	function submitUser($id, $password_hash){
		include '../config/config.php';
		$submitUserDB = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
		$User_Edit_statement = $submitUserDB->prepare("UPDATE users SET password = ? WHERE id = ?");
		$User_Edit_result = $User_Edit_statement->execute(array($password_hash, $id));
		if($User_Edit_result){
		header('location: admin.php');
		}else{
			echo 'Beim abspeichern ist ein Fehler aufgetreten';
		}
	}
	function editEvent($id){
		include '../config/config.php';
		$editEventDB = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
		$Event_getInfo_statement = $editEventDB->prepare("SELECT * FROM events WHERE id = ?");
		$Event_getInfo_result = $Event_getInfo_statement->execute(array($id));
		$Event_getInfo_fetch = $Event_getInfo_statement->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
			<div class="w3-col" style="width:25%;">
			<p></p>
			</div>
			<div class="w3-col w3-container" style="width:50%;">
			<p style="text-decoration: underline; font-weight: bold; font-size: large; text-align: center;">Event Bearbeiten</p>
				<form action="admin/edit.php?submitEvent=<?php echo $id;?>" method="post" enctype="multipart/form-data">
					<div class="w3-row-padding">
						<label>Name</label>
						<input class="w3-input w3-border" name="eventname" type="text" value="<?php echo $Event_getInfo_fetch['eventname'];?>">
					</div>
					<div class="w3-row-padding">
						<label>Preis</label>
						<input class="w3-input w3-border" name="price" type="text" value="<?php echo $Event_getInfo_fetch['price'];?>">
					</div>
					<div class="w3-row-padding">
						<label>Veranstaltungsort</label>
						<input class="w3-input w3-border" name="place" type="text" value="<?php echo $Event_getInfo_fetch['place'];?>">
					</div>
					<div class="w3-row-padding">
						<div class="w3-row-padding w3-third" id="npadding-l">
							<label>Veranstaltungsdatum</label>
							<input class="w3-input w3-border" id="datepicker" type="text" name="date" value="<?php echo $Event_getInfo_fetch['eventdate'];?>">
						</div>
						<div class="w3-row-padding w3-third">
							<label>Einlass</label>
							<input type="time" class="w3-input w3-border" name="time" value="<?php echo $Event_getInfo_fetch['entrytime'];?>">
						</div>
						<div class="w3-row-padding w3-third"  id="npadding-r">
							<label>Mindestalter</label>
							<input type="number" class="w3-input w3-border" name="age" value="<?php echo $Event_getInfo_fetch['maxage'];?>">
						</div>
					</div>
					<div class="w3-row-padding">
						<label>Beschreibung</label>
						<textarea rows="10" cols="50" name="descr" class="w3-input w3-border"><?php echo $Event_getInfo_fetch['descr'];?></textarea>
					</div>
					<div class="w3-row-padding">
						<label>Bild (MAX 2MB)</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
						<input type="file" class="w3-input w3-border" name="upfile">
					</div>
					<br>
					<span onClick="goBack()" class="w3-button w3-black">Abbrechen</span>
					<button class="w3-button w3-black" type="submit">Ändern</button>
				</form>
			</div>
			<div class="w3-col" style="width:25%;">
				<p></p>
			</div>
		</div>
		<?php
	}
	function editOrder($id, $error){
		include '../config/config.php';
		$editOrderDB = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
		$Order_getInfo_statement = $editOrderDB->prepare("SELECT * FROM orders WHERE id = ?");
		$Order_getInfo_result = $Order_getInfo_statement->execute(array($id));
		$Order_getInfo_fetch = $Order_getInfo_statement->fetch(PDO::FETCH_ASSOC);
		echo $error;
		?>
		<div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
			<div class="w3-col" style="width:25%;">
			<p></p>
			</div>
			<div class="w3-col w3-container" style="width:50%;">
			<p style="text-decoration: underline; font-weight: bold; font-size: large; text-align: center;">Order Bearbeiten</p>
			<form action="admin/edit.php?submitOrder=<?php echo $id;?>" method="post" class="w3-container w3-center">
				<div>
					<label class="w3-left">E-Mail</label>
					<input type="email" name="email" class="w3-input" readonly value="<?php echo $Order_getInfo_fetch['username'];?>">
				</div>
				<div>
					<label class="w3-left">Adresse</label>
					<input type="text" name="adress" class="w3-input" readonly value="<?php echo $Order_getInfo_fetch['street'].', '.$Order_getInfo_fetch['hsnr'].' '.$Order_getInfo_fetch['plz'].' '.$Order_getInfo_fetch['city'];?>">
				</div>
				<div>
					<label class="w3-left">Event</label>
					<input type="text" name="event" class="w3-input" readonly value="<?php echo $Order_getInfo_fetch['eventname'];?>">
				</div>
				<div>
					<label class="w3-left">Tickets</label>
					<input type="text" name="Tickets" class="w3-input" readonly value="<?php echo $Order_getInfo_fetch['ticketcount'].'x '.$Order_getInfo_fetch['tickettype'];?>">
				</div>
				<div>
					<label class="w3-left">Bezahlmethode</label><br>
					<input type="text" name="payvar" class="w3-input" readonly value="<?php echo $Order_getInfo_fetch['payvar'];?>">
				</div>
				<div>
					<label class="w3-left">Status</label>
					<select name="state" class="w3-select">
						<option value="" disabled selected>Wählen Sie einen Status aus:</option>
						<option value="Offen">Offen</option>
						<option value="Reserviert">Reserviert</option>
						<option value="Rechnung Versendet">Rechnung Versendet</option>
						<option value="Bezahlt">Bezahlt</option>
						<option value="Storniert">Storniert</option>					
					</select>
				</div>
				<div id="placeholder" style="height: 20px;">
					<p></p>
				</div>
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
	function editTeam($id){
		include '../config/config.php';
		$editTeamDB = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
		$Team_getInfo_statement = $editTeamDB->prepare("SELECT * FROM team WHERE id = ?");
		$Team_getInfo_result = $Team_getInfo_statement->execute(array($id));
		$Team_getInfo_fetch = $Team_getInfo_statement->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
			<div class="w3-col" style="width:25%;">
			<p></p>
			</div>
			<div class="w3-col w3-container" style="width:50%;">
				<p style="text-decoration: underline; font-weight: bold; font-size: large; text-align: center;">Team Bearbeiten</p>
				<form action="admin/edit.php?submitTeam=<?php echo $id;?>" method="post" enctype="multipart/form-data">
			  		<label>Vorname</label>
			  		<input class="w3-input w3-border" name="Vorname" type="text" value="<?php echo $Team_getInfo_fetch['Vorname'];?>">
			  		<label>Nachname</label>
			  		<input class="w3-input w3-border" name="Nachname" type="text" value="<?php echo $Team_getInfo_fetch['Nachname'];?>">
			  		<label>Geburtsdatum</label>
			  		<input class="w3-input w3-border" id="datepicker2" type="text" name="bdaydate" value="<?php echo $Team_getInfo_fetch['Geburtsdatum'];?>">
			  		<label>Beschreibung</label>
			  		<textarea rows="10" cols="50" name="tdescr" class="w3-input w3-border"><?php echo $Team_getInfo_fetch['descr'];?></textarea>
			  		<label>Bild (MAX 2MB)</label>
			  		<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
			  		<input type="file" class="w3-input w3-border" name="teamfile">
			  		<br>
			  		<span onClick="goBack()" class="w3-button w3-black">Abbrechen</span>
			  		<button class="w3-button w3-black" type="submit">Ändern</button>
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