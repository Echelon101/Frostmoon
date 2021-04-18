<?php 
ob_start();
//include section
include '../php/phpopening.php';
include '../config/config.php';
include '../config/mailConfig.php';
//End Include
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <base href="../">
        <link rel="stylesheet" href="libs/jquery-ui-1.12.1/jquery-ui.min.css">
	  	<script src="libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
		<script src="libs/jquery-ui-1.12.1/jquery-ui.js"></script>
        <?php include '../php/headmeta.php';?>
        <style type="text/css">
		#npadding-r{
		padding-right: 0px;
		}
		#npadding-l{
		padding-left: 0px;
		}
		</style>
    </head>
		<?php include '../php/cookiemodal.php';?>
    	<?php include '../php/navigation.php';?>
    	
    	<script type="text/javascript">
			$( function() {
				$( "#datepicker" ).datepicker({ dateFormat: 'dd.mm.yy', inline: true});
			});
			$( function() {
				$( "#datepicker2" ).datepicker({ dateFormat: 'dd.mm.yy', inline: true});
			});
    	</script>
    	<?php if(isset($_SESSION['admin'])){if($_SESSION['admin']){?>
		<div class="w3-row w3-center" style="margin: 1%">
	        <div class="w3-col">
		      	<div>
					<div class="w3-bar w3-red" style="width:100%;">
						<button class="w3-bar-item w3-button tablink" onclick="openItem(event,'Orders')">Bestellungen</button>
						<button class="w3-bar-item w3-button tablink" onclick="openItem(event,'Users')">Benutzer</button>
					    <button class="w3-bar-item w3-button tablink" onclick="openItem(event,'EventsList')">Events</button>
					    <button class="w3-bar-item w3-button tablink" onclick="openItem(event,'TeamList')">Team</button>
					    <button class="w3-bar-item w3-button tablink" onclick="openItem(event,'EMail')">E-Mail</button>
					    <button class="w3-bar-item w3-button tablink" onclick="openItem(event,'EventsCreate')">Event Erstellen</button>
						<button class="w3-bar-item w3-button tablink" onclick="openItem(event,'TeamCreate')">Team Erstellen</button>
					</div>
					  
					<div id="Orders" class="w3-container item">
						<?php //Database Query to get Table info from Order Table
						$Order_list_statement = $pdo->prepare("SELECT * FROM orders");
						$Order_list_result = $Order_list_statement->execute();
						?>
						<div class="w3-responsive">
							<table class="w3-table-all">
								<tr class="w3-grey">
									<th>BestellNr.</th>
									<th>Nutzername</th>
									<th>Adresse</th>
									<th>Eventname</th>
									<th>TicketTyp</th>
									<th>Ticketanzahl</th>
									<th>Preis</th>
									<th>Bezahlmethode</th>
									<th>Status</th>
									<th>Erstellungsdatum</th>
									<th>Bearbeiten</th>
								</tr>
							<?php
							//While loop to fill table
							while ($Order_list_fetch = $Order_list_statement->fetch(PDO::FETCH_ASSOC)){
								$urlencodeDeleteOrder = "a=d&o=order&id=".$Order_list_fetch['id'];
								$urlencodeChangeStateOrder = "a=e&o=order&id=".$Order_list_fetch['id'];
								$adress = $Order_list_fetch['street'] . ', ' . $Order_list_fetch['hsnr'] . ' ' . $Order_list_fetch['plz'] . ' ' . $Order_list_fetch['city'];
								echo '<tr>';
								echo "<td>".$Order_list_fetch['id']."</td>";
								echo "<td>".$Order_list_fetch['username']."</td>";
								echo "<td>".$adress."</td>";
								echo "<td>".$Order_list_fetch['eventname']."</td>";
								echo "<td>".$Order_list_fetch['tickettype']."</td>";
								echo "<td>".$Order_list_fetch['ticketcount']." Stk.</td>";
								echo "<td>".$Order_list_fetch['price']."€</td>";
								echo "<td>".$Order_list_fetch['payvar']."</td>";
								echo "<td>".$Order_list_fetch['state']."</td>";
								echo "<td>".$Order_list_fetch['created_at']."</td>";
								echo "<td>";
								echo '<a href="admin/edit.php?'.$urlencodeDeleteOrder.'">Löschen</a><br>';
								echo '<a href="admin/edit.php?'.$urlencodeChangeStateOrder.'">Bearbeiten</a>';
								echo '</td>';
								echo '</tr>';
							}
							?>
						</table>
					</div>
					</div>
					
					  <div id="EMail" class="w3-container item" style="display:none">
					    <?php 
					    	//invoke of custom mail controller
					    	if(isset($_GET['sender'])){
					    		mailContoller($_POST['to'], $_POST['from'], $_POST['subject'], $_POST['text']);
					    		header('location: admin.php');
					    	}
					    ?>
					    <div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
							<div class="w3-col" style="width:25%;">
							<p></p>
							</div>
							<div class="w3-col w3-container" style="width:50%;">
						    <form action="admin/admin.php?sender=1" method="post">
								<div class="w3-row-padding">
									<label>Von</label>
						    		<input type="email" placeholder="Von" name="from" class="w3-input w3-border">
						    	</div>
						    	<div class="w3-row-padding">
						    		<label>An</label>
						    		<input type="email" placeholder="An" name="to" class="w3-input w3-border">
						    	</div>
						    	<div class="w3-row-padding">
						    		<label>Betreff</label>
						    		<input type="text" placeholder="Betreff" name="subject" class="w3-input w3-border">
						    	</div>
						    	<div class="w3-row-padding">
									<br>
						    		<textarea rows="5" cols="50" name="text" class="w3-input w3-border"></textarea>
						    	</div>
						    	<br>
						    	<button type="submit" class="w3-button w3-black">Absenden</button>
						    </form>
						    </div>
							<div class="w3-col" style="width:25%;">
								<p></p>
							</div>
						</div>
					  </div>
					
					  <div id="EventsList" class="w3-container item" style="display:none; width: 100%">
					  	<?php 
					  	//Database Query to get Table info from Event Table
					  	$Event_list_statement = $pdo->prepare("SELECT * FROM events");
					  	$Event_list_result = $Event_list_statement->execute();
						?>
						<div class="w3-responsive">
							<table class="w3-table-all" style="width: 100%">
								<tr class="w3-grey">
									<th>EventNr.</th>
									<th>Eventname</th>
									<th>Preis</th>
									<th>Veranstaltungsdatum</th>
									<th>Einlass</th>
									<th>Min Alter</th>
									<th>Beschreibung</th>
									<th>Bild</th>
									<th>Erstellungsdatum</th>
									<th>Bearbeiten</th>
								</tr>
							<?php 
							//while loop to fill table
						  	while ($Event_list_saveset = $Event_list_statement->fetch(PDO::FETCH_ASSOC)){
						  		$urlencodeDeleteEvent = "a=d&o=event&id=".$Event_list_saveset['id'];
						  		$urlencodeEditEvent = "a=e&o=event&id=".$Event_list_saveset['id'];
						  		echo '<tr>';
						  		echo '<td>'.$Event_list_saveset['id'].'</td>';
						  		echo '<td>'.$Event_list_saveset['eventname'].'</td>';
						  		echo '<td>'.$Event_list_saveset['price'].'€</td>';
						  		echo '<td>'.$Event_list_saveset['eventdate'].'</td>';
						  		echo '<td>'.$Event_list_saveset['entrytime'].' Uhr</td>';
						  		echo '<td>'.$Event_list_saveset['maxage'].' Jahre</td>';
						  		echo '<td>'.$Event_list_saveset['descr'].'</td>';
						  		if(isset($Event_list_saveset['imagepath'])){
						  			echo '<td><img src="uploads/'.$Event_list_saveset['imagepath'].'" style="width: 100%; height: auto;" ALT="Bild '.$Event_list_saveset['eventname'].'"></td>';
						  		}else{
						  		echo '<td>Es wurde kein Bild hochgeladen</td>';
						  		}
						  		echo '<td>'.$Event_list_saveset['created_at'].'</td>';
						  		echo '<td>';
						  		echo '<a href="admin/edit.php?'.$urlencodeDeleteEvent.'">Löschen</a><br>';
						  		echo '<a href="admin/edit.php?'.$urlencodeEditEvent.'">Bearbeiten</a>';
						  		echo '</td>';
						  		echo '</tr>';
						  	}
						  	?>
						  	</table>
					  	</div>
					  </div>
					  
					  <div id="EventsCreate" class="w3-container item" style="display:none">
					  	<?php if(isset($_GET['create'])){
					  		//rename POST Variables
					  		$eventName = $_POST['eventname'];
					  		$eventPrice = $_POST['price'];
					  		$eventDate = $_POST['date'];
					  		$eventTime = $_POST['time'];
					  		$eventPlace = $_POST['place'];
					  		$eventAge = $_POST['age'];
					  		$eventDescription = $_POST['descr'];
					  		$eventImage = Null;
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
					  			} catch (RuntimeException $e) {
					  				
					  				echo $e->getMessage();
					  				
					  			}
					  			//Insert data into Events Table
					  			$Event_create_statement = $pdo->prepare("INSERT INTO events (eventname, price, eventdate, entrytime, place, maxage, descr, imagepath) VALUES (:eventname, :price, :eventdate, :entrytime, :place, :maxage, :descr, :imagepath)");
					  			$Event_create_result = $Event_create_statement->execute(array('eventname' => $eventName, 'price' => $eventPrice, 'eventdate' => $eventDate, 'entrytime' => $eventTime, 'place' => $eventPlace, 'maxage' => $eventAge, 'descr' => $eventDescription, 'imagepath' => $eventImage));
					  			header('location: admin.php');
					  		}
						}?>
						<div class="w3-row w3-center" style="margin-top:2%; margin-bottom: 2%;">
							<div class="w3-col" style="width:25%;">
							<p></p>
							</div>
							<div class="w3-col w3-container" style="width:50%;">
								<form action="admin/admin.php?create=1" method="post" enctype="multipart/form-data">
									<div class="w3-row-padding">
										<label>Name</label>
										<input class="w3-input w3-border" name="eventname" placeholder="Digital Glance" required type="text">
									</div>
									<div class="w3-row-padding">
										<label>Preis</label>
										<input class="w3-input w3-border" name="price" type="text" placeholder="50.16" required>
									</div>
									<div class="w3-row-padding">
										<label>Veranstaltungsort</label>
										<input class="w3-input w3-border" name="place" type="text" placeholder="Elmshorn" required>
									</div>
									<div class="w3-row-padding" id="npadding-l">
										<div class="w3-row-padding w3-third">
											<label>Veranstaltungsdatum</label>
											<input class="w3-input w3-border" id="datepicker" type="text" name="date" placeholder="01.01.2000" required>
										</div>
										<div class="w3-row-padding w3-third">
											<label>Einlass</label>
											<input type="time" class="w3-input w3-border" name="time" placeholder="20:00" required>
										</div>
										<div class="w3-row-padding w3-third" id="npadding-r">
											<label>Mindestalter</label>
											<input type="number" class="w3-input w3-border" name="age" placeholder="18" required>
										</div>
									</div>
									<div class="w3-row-padding">
										<label>Beschreibung</label>
										<textarea rows="10" cols="50" name="descr" class="w3-input w3-border" required></textarea>
									</div>
									<div class="w3-row-padding">
									<label>Bild (MAX 2MB)</label>
										<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
										<input type="file" class="w3-input w3-border" name="upfile" style="background-color: white">
									</div>
									<br>
									<button class="w3-button w3-black" type="submit">Erstellen</button>
								</form>
							</div>
							<div class="w3-col" style="width:25%;">
								<p></p>
							</div>
						</div>
					</div>
					<div class="w3-container item" style="display: none" id="Users">
						<?php 
						//Database Query to get Table info from User Table
						$User_list_statement = $pdo->prepare("SELECT * FROM users");
						$User_list_result = $User_list_statement->execute();
						
						?>
						<div class="w3-responsive">
							<table class="w3-table-all" style="width: 100%">
								<tr class="w3-grey">
									<th>BenuterNr.</th>
									<th>Nutzername</th>
									<th>Vorname</th>
									<th>Nachname</th>
									<th>Adresse</th>
									<th>Rolle</th>
									<th>Registriert seit</th>
									<th>Bearbeiten</th>
								</tr>
							<?php 
							//while loop to fill table
							while ($User_list_saveset = $User_list_statement->fetch(PDO::FETCH_ASSOC)){
								$urlencodeDeleteUser = "a=d&o=user&id=".$User_list_saveset['id'];
								$urlencodePromoteUser = "a=a&o=user&id=".$User_list_saveset['id'];
								$urlencodeDemoteUser = "a=r&o=user&id=".$User_list_saveset['id'];
								$urlencodeResetUser = "a=e&o=user&id=".$User_list_saveset['id'];
								$Useradress = $User_list_saveset['street'] . ', ' . $User_list_saveset['hsnr'] . ' ' . $User_list_saveset['plz'] . ' ' . $User_list_saveset['city'];
						  		echo '<tr>';
						  		echo '<td>'.$User_list_saveset['id'].'</td>';
						  		echo '<td>'.$User_list_saveset['email'].'</td>';
						  		echo '<td>'.$User_list_saveset['vorname'].'</td>';
						  		echo '<td>'.$User_list_saveset['nachname'].'</td>';
						  		if($User_list_saveset['street'] == NULL){
						  			echo '<td>Der Nutzer hat keine Adresse festgelegt</td>';
						  		}else{
						  			echo "<td>".$Useradress."</td>";
						  		}
						  		if($User_list_saveset['admin']){
						  			echo '<td>Admin</td>';
						  		}else{
						  			echo '<td>Nutzer</td>';
						  		}
						  		echo '<td>'.$User_list_saveset['created_at'].'</td>';
						  		echo '<td>';
						  		echo '<a href="admin/edit.php?'.$urlencodeDeleteUser.'">Löschen</a><br>';
						  		if(!$User_list_saveset['admin']){
						  			echo '<a href="admin/edit.php?'.$urlencodePromoteUser.'">Zur Rolle Admin hinzufügen</a><br>';
						  		}else {
						  			echo '<a href="admin/edit.php?'.$urlencodeDemoteUser.'">Aus der Rolle Admin entfernen</a><br>';
						  		}
						  		echo '<a href="admin/edit.php?'.$urlencodeResetUser.'">Passwort zurückstzen</a>';
		  						echo '</td>';
						  		echo '</tr>';
						  	}
						  	?>
						  	</table>
						</div>
					</div>
					<div class="w3-container item" style="display: none" id="TeamList">
						<?php 
						//Database Query to get Table info from Team Table
						$Team_list_statement = $pdo->prepare("SELECT * FROM team");
						$Team_list_result = $Team_list_statement->execute();
						
						?>
						<div class="w3-responsive">
							<table class="w3-table-all" style="width: 100%">
								<tr class="w3-grey">
									<th>TeamNr.</th>
									<th>Vorname</th>
									<th>Nachname</th>
									<th>Geburtsdatum</th>
									<th>Beschreibung</th>
									<th>Bild</th>
									<th>Erstellungsdatum</th>
									<th>Bearbeiten</th>
								</tr>
							<?php 
							//while loop to fill table
							while ($Team_list_saveset = $Team_list_statement->fetch(PDO::FETCH_ASSOC)){
								$urlencodeDeleteTeam = "a=d&o=team&id=".$Team_list_saveset['id'];
								$urlencodeEditTeam = "a=e&o=team&id=".$Team_list_saveset['id'];
						  		echo '<tr>';
						  		echo '<td>'.$Team_list_saveset['id'].'</td>';
						  		echo '<td>'.$Team_list_saveset['Vorname'].'</td>';
						  		echo '<td>'.$Team_list_saveset['Nachname'].'</td>';
						  		echo '<td>'.$Team_list_saveset['Geburtsdatum'].'</td>';
						  		echo '<td>'.$Team_list_saveset['descr'].'</td>';
						  		if(isset($Team_list_saveset['image'])){
						  			echo '<td><img src="uploads/'.$Team_list_saveset['image'].'" style="width: 100%; height: auto;" ALT="Bild '.$Team_list_saveset['Vorname'].' '.$Team_list_saveset['Nachname'].'"></td>';
						  		}else{
						  			echo '<td>Es wurde kein Bild hochgeladen</td>';
						  		}
						  		echo '<td>'.$Team_list_saveset['created_at'].'</td>';
						  		echo '<td>';
						  		echo '<a href="admin/edit.php?'.$urlencodeDeleteTeam.'">Löschen</a><br>';
						  		echo '<a href="admin/edit.php?'.$urlencodeEditTeam.'">Bearbeiten</a>';
						  		echo '</td>';
						  		echo '</tr>';
						  	}
						  	?>
						  	</table>
					  	</div>
					</div>
					<div class="w3-container item" style="display: none" id="TeamCreate">
					<?php 
					if(isset($_GET['team'])){
						$teamVorname = $_POST['Vorname'];
						$teamNachname = $_POST['Nachname'];
						$teamBday = $_POST['bdaydate'];
						$teamdescr = $_POST['tdescr'];
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
								if (false === $teamext = array_search(
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
										$teamsha1 = sha1_file($_FILES['teamfile']['tmp_name']);
										
										if (!move_uploaded_file(
												$_FILES['teamfile']['tmp_name'],
												sprintf('./../uploads/%s.%s',
														sha1_file($_FILES['teamfile']['tmp_name']),
														$teamext
														)
												)) {
													throw new RuntimeException('Failed to move uploaded file.');
												}
												$teamImage = $teamsha1.'.'.$teamext;
												try {
												// insert into Team table
												$Team_create_statement = $pdo->prepare("INSERT INTO team (Vorname, Nachname, Geburtsdatum, descr, image) VALUES (:Vorname, :Nachname, :Geburtsdatum, :descr, :image)");
												$Team_create_result = $Team_create_statement->execute(array('Vorname' => $teamVorname, 'Nachname' => $teamNachname, 'Geburtsdatum' => $teamBday, 'descr' => $teamdescr, 'image' => $teamImage));
												if($Team_create_result){
												header('location: admin.php');
												}else {
													echo 'Beim Abspeichern ist ein Fehler aufgetreten';
												}
												}catch (PDOException $pdoE){
													echo $pdoE->getMessage();
												}
							} catch (RuntimeException $e) {
								
								echo $e->getMessage();
								
							}
						}
					}
						?>
						<div class="w3-row" style="margin-top:2%; margin-bottom: 2%;">
							<div class="w3-col" style="width:25%;">
								<p></p>
							</div>
							<div class="w3-col" style="width:50%;">
							<form action="admin/admin.php?team=1" method="post" enctype="multipart/form-data">
						  		<label>Vorname</label>
						  		<input class="w3-input w3-border" name="Vorname" type="text" placeholder="Max" required>
						  		<label>Nachname</label>
						  		<input class="w3-input w3-border" name="Nachname" type="text" placeholder="Mustermann" required>
						  		<label>Geburtsdatum</label>
						  		<input class="w3-input w3-border" id="datepicker2" type="text" name="bdaydate" placeholder="01.01.2000" required>
						  		<label>Beschreibung</label>
						  		<textarea rows="10" cols="50" name="tdescr" class="w3-input w3-border" required></textarea>
						  		<label>Bild (MAX 2MB)</label>
						  		<input type="hidden" name="MAX_FILE_SIZE" value="3000000">
						  		<input type="file" class="w3-input w3-border" name="teamfile" style="background-color: white">
						  		<br>
						  		<button class="w3-button w3-black" type="submit">Erstellen</button>
						  	</form>
						  	</div>
						  	<div class="w3-col" style="width:25%;">
								<p></p>
							</div>
						</div>
					</div>
				</div>
					
				<script>
				function openItem(evt, itemName) {
				  var i, x, tablinks;
				  x = document.getElementsByClassName("item");
				  for (i = 0; i < x.length; i++) {
					  x[i].style.display = "none";
				  }
				  tablinks = document.getElementsByClassName("tablink");
				  for (i = 0; i < x.length; i++) {
					  tablinks[i].className = tablinks[i].className.replace(" w3-grey", "");
				  }
				  document.getElementById(itemName).style.display = "block";
				  evt.currentTarget.className += " w3-grey";
				}
				</script>
			</div>
		</div>
		<?php }else{
			echo 'Sie sind kein Administrator';
		}
		}else{
			header('location: ../login/login.php');
		}?>
    </body>
</html>