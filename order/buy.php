<?php
session_start();
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Buy</title>
		<base href="../">
		<?php include '../php/headmeta.php';?>
		<link href="customcss/buy.css" type="text/css" rel="stylesheet">
		<style type="text/css">
		.npadding-r{
		padding-right: 0px!important;
		}
		.npadding-l{
		padding-left: 0px!important;
		}
		</style>
	</head>
	<body>
		<?php 
		/*
		 * DB Variables
		 * 	loggedin Order Placement:
		 * 		$Order_LIN_statement
		 * 		$Order_LIN_result
		 * 	loggedout Register/Order:
		 * 		$Reg_LOUT_fetchEmail_statment
		 * 		$Reg_LOUT_fetchEmail_result
		 * 		$Reg_LOUT_fetchEmail_user
		 * 		$Reg_LOUT_regUser_statement
		 * 		$Reg_LOUT_regUser_result
		 * 		$Order_LOUT_fetchUser_statement
		 * 		$Order_LOUT_fetchUser_result
		 * 		$Order_LOUT_fetchUser_user
		 * 		$Order_LOUT_placeOrder_statement
		 * 		$Order_LOUT_placeOrder_result
		 * 		$Order_LOUT_revertChanges_statement
		 * 		$Order_LOUT_revertChanges_result
		 */
		
		if(isset($_SESSION['userid'])){
			$loggedin=true;
			$Order_getUserInfo_statement = $pdo->prepare("SELECT * FROM users WHERE id = ?");
			$Order_getUserInfo_result = $Order_getUserInfo_statement->execute(array($_SESSION['userid']));
			$Order_getUserInfo_fetch = $Order_getUserInfo_statement->fetch(PDO::FETCH_ASSOC);
		}else{
			$loggedin=false;
		}
		if(isset($_GET['event'])){
			$Event_get_statement = $pdo->prepare("SELECT * FROM events WHERE id = :id");
			$Event_get_result = $Event_get_statement->execute(array('id' => $_GET['event']));
			$Event_get_fetch = $Event_get_statement->fetch(PDO::FETCH_ASSOC);
			$_SESSION['getEvent'] = $Event_get_fetch;
		}
		if(isset($_GET['order'])){
			
			$premium = "1.2";
			$defaultState = "offen";
			$street = $_POST['street'];
			$hsnr = $_POST['hsnr'];
			$plz = $_POST['plz'];
			$city = $_POST['city'];
			$ticket = $_POST['ticketType'];
			$tcount = $_POST['ticketCount'];
			$payvar = $_POST['payvar'];
			$event = $_SESSION['getEvent']['eventname'];
			//Switch statement to convert , to . and detecht which ticket was selected
			switch ($ticket){
				case 'Normal':
					$convPrice = str_replace(',', '.', $_SESSION['getEvent']['price']);
					$tprice = floatval($convPrice);
					$total = $tprice*$tcount;
				case 'Premium':
					$convPrice = str_replace(',', '.', $_SESSION['getEvent']['price']);
					$convPremium = floatval($premium);
					$tprice = floatval($convPrice);
					$total = $tprice*$convPremium*$tcount;
				default:
					$ticket = 'Normal';
					$convPrice = str_replace(',', '.', $_SESSION['getEvent']['price']);
					$tprice = floatval($convPrice);
					$total = $tprice*$tcount;
			}
			if($loggedin){
				$userid = $_SESSION['userid'];
				$username = $_SESSION['username'];
			}else{
				$name = $_POST['name'];
				$sname = $_POST['sname'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$password2 = $_POST['password2'];
			}
			if($loggedin){
				$Order_LIN_statement = $pdo->prepare("INSERT INTO orders (username, street, hsnr, plz, city, eventname, tickettype, ticketcount, price, payvar, state) VALUES (:username, :street, :hsnr, :plz, :city, :eventname, :tickettype, :ticketcount, :price, :payvar, :state)");
				$Order_LIN_result = $Order_LIN_statement->execute(array('username'=> $username, 'street'=> $street, 'hsnr'=> $hsnr, 'plz'=> $plz, 'city'=> $city, 'eventname' => $event, 'tickettype'=> $ticket, 'ticketcount'=> $tcount, 'price' => $total, 'payvar' => $payvar, 'state' => $defaultState));
				if($Order_LIN_result){
					header('location: ../login/order.php');
					die();
				}else{
					echo 'Beim Abspeichern ist ein Fehler aufgetreten <br />';
				}
			}else{
				$error = false;
				/*$email = $_POST['email'];
				$name = $_POST['name'];
				$surname = $_POST['sname'];
				$password = $_POST['password'];
				$password2= $_POST['password2'];*/
				
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					echo 'Die E-Mail Adresse ist ungültig <br />';
					$error = true;
				}
				if(strlen($password) == 0){
					echo 'Das Passwort Feld darf nicht Leer sein <br />';
					$error = true;
				}
				if($password != $password2){
					echo 'Die Passwörter müssen übereinstimmen';
				}
				//Email Valid?
				if(!$error){
					$Reg_LOUT_fetchEmail_statment= $pdo->prepare("SELECT * FROM users WHERE email = :email");
					$Reg_LOUT_fetchEmail_resultsult =$Reg_LOUT_fetchEmail_statment->execute(array('email' => $email));
					$Reg_LOUT_fetchEmail_user = $Reg_LOUT_fetchEmail_statment->fetch();
					
					if($Reg_LOUT_fetchEmail_user!== false){
						echo 'Die E-Mail Adresse ist bereits vergeben <br />';
						$error = true;
					}
				}
				if(!$error){
					$password_hash = password_hash($password, PASSWORD_DEFAULT);
					
					$Reg_LOUT_regUser_statement = $pdo->prepare("INSERT INTO users (email, password, vorname, nachname) VALUES (:email, :password, :vorname, :nachname)");
					$Reg_LOUT_regUser_result= $Reg_LOUT_regUser_statement->execute(array('email'=> $email, 'password'=> $password_hash, 'vorname'=>$name, 'nachname'=>$sname));
					if($Reg_LOUT_regUser_result){
						
						$Order_LOUT_fetchUser_statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
						$Order_LOUT_fetchUser_result = $Order_LOUT_fetchUser_statement->execute(array('email'=> $email));
						$Order_LOUT_fetchUser_user = $Order_LOUT_fetchUser_statement->fetch();
						
						if($Order_LOUT_fetchUser_result){
							$Order_LOUT_placeOrder_statement= $pdo->prepare("INSERT INTO orders (username, street, hsnr, plz, city, eventname, tickettype, ticketcount, price, payvar) VALUES (:username, :street, :hsnr, :plz, :city, :eventname, :tickettype, :ticketcount, :price, :payvar)");
							$Order_LOUT_placeOrder_result = $Order_LOUT_placeOrder_statement->execute(array('username'=> $email, 'street'=> $street, 'hsnr'=> $hsnr, 'plz'=> $plz, 'city'=> $city, 'eventname' => $event, 'tickettype'=> $ticket, 'ticketcount'=> $tcount, 'price' => $total, 'payvar' => $payvar));
							if($Order_LOUT_placeOrder_result){
								header('location: ../login/login.php');
								die();
							}else{
								echo 'Beim Abspeichern ist ein Fehler aufgetreten <br />';
								$OrderRevertUser = $Order_LOUT_fetchUser_user['userid'];
								$Order_LOUT_revertChanges_statement = $pdo->prepare("DELETE FROM users WHERE userid = :userid");
								$Order_LOUT_revertChanges_result = $Order_LOUT_revertChanges_statement->execute(array('userid' => $OrderRevertUser));
							}
						}
						
					}else{
						echo 'Beim Abspeichern ist ein Fehler aufgetreten <br />';
					}
				}
			}
		}
		?>
    	<?php include '../php/navigation.php';?>
		<div style="height: 20px;">
			<p></p>
		</div>
		<div class="w3-row">
    		<div class="w3-col" style="width:32.5%">
    			<p></p>
    		</div>
            <div class="w3-col" style="width:35%">
				<form action="order/buy.php?order=1" method="post" class="w3-container w3-center">
					<div class="w3-row-padding">
						<label class="w3-left">Vorname</label>
						<input type="text" name="name" maxlength="250" placeholder="Max" class="w3-input" <?php if($loggedin){echo 'disabled';}?> value="<?php if($loggedin){echo $Order_getUserInfo_fetch['vorname'];}?>">
					</div>
					<div id="nachname" class="w3-row-padding">
						<label class="w3-left">Nachname</label>
						<input type="text" name="sname" maxlength="250" placeholder="Mustermann" class="w3-input" <?php if($loggedin){echo 'disabled';}?> value="<?php if($loggedin){echo $Order_getUserInfo_fetch['nachname'];}?>">
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">E-Mail</label>
						<input type="email" name="email" maxlength="250" placeholder="example@example.com" required class="w3-input" <?php if($loggedin){echo 'disabled';}?> value="<?php if($loggedin){echo $Order_getUserInfo_fetch['email'];}?>">
					</div>
					<?php if(!$loggedin){?>
					<div class="w3-row-padding">
    					<label class="w3-left">Dein Passwort:</label>
    					<input type="password" size="40" maxlength="250" name="password" placeholder="*****" class="w3-input" <?php if($loggedin){echo 'disabled';}?>>
    				</div>
    				<div class="w3-row-padding">
    					<label class="w3-left">Passwort wiederholen:</label>
    					<input type="password" size="40" maxlength="250" name="password2" placeholder="*****" class="w3-input" <?php if($loggedin){echo 'disabled';}?>>
    				</div>
    				<?php }?>
					<div class="w3-row-padding">
					<label class="w3-left">Straße und Hausnr.</label><br>
						<div class="w3-threequarter divmobile npadding-l">
							<input type="text" name="street" placeholder="Straße" class="w3-input" value="<?php if($loggedin){echo $Order_getUserInfo_fetch['street'];}?>">
						</div>
						<div class="w3-quarter strmobile npadding-r">
							<input type="text" name="hsnr" placeholder="Nummer" class="w3-input mobile" value="<?php if($loggedin){echo $Order_getUserInfo_fetch['hsnr'];}?>">
						</div>
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">PLZ und Stadt</label><br>
						<div class="w3-quarter divmobile npadding-l">
							<input type="text" maxlength="5" name="plz" placeholder="PLZ" class="w3-input" value="<?php if($loggedin){echo $Order_getUserInfo_fetch['plz'];}?>"> 
						</div>
						<div class="w3-threequarter strmobile npadding-r">
							<input type="text" name="city" placeholder="Stadt" class="w3-input" value="<?php if($loggedin){echo $Order_getUserInfo_fetch['city'];}?>">
						</div>
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">Ticket</label><br>
						<div class="w3-threequarter npadding-l">
							<select name="ticketType" class="w3-select">
								<option value="" disabled selected>Wählen Sie ein Ticket aus:</option>
								<option value="Normal">Normal (<?php echo $_SESSION['getEvent']['price'].'€'?>)</option>
								<option value="Premium">Premium (<?php echo $_SESSION['getEvent']['price']*1.2.'€'?>)</option>
							</select>
						</div>
						<div class="w3-quarter npadding-r">
							<input type="number" name="ticketCount" min="1" max="5" class="w3-input" placeholder="Anzahl">
						</div>
					</div>
					<div class="w3-row-padding">
						<label class="w3-left">Bezahlmethode</label><br>
						<div>
							<select name="payvar" class="w3-select">
								<option value="" disabled selected>Wählen Sie ihre Bezahlmethode aus:</option>
								<option value="Rechnung">Rechnung</option>
								<option value="Bei Einlass">Bei Einlass</option>
							</select>
						</div>
					</div>
					Hinweis: Informaionen zu den Tickets erhalten Sie <a href="sites/tickets.php">hier</a>.
					<div style="height: 20px;">
						<p></p>
					</div>
					<button type="submit" class="w3-button w3-black">Bestellen</button>
				</form>
			</div>
    		<div class="w3-col" style="width:32.5%;">
    			<p></p>
    		</div>
		</div>
	</body>
</html>