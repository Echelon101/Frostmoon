<?php
include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<base href="../">
		<?php include '../php/headmeta.php';?>
		<link href="customcss/buy.css" type="text/css" rel="stylesheet">
	</head>
	<?php include '../php/cookiemodal.php';?>
		<?php include '../php/navigation.php';?>
		<?php 
		$showFormular= true;
		if(isset($_GET['register'])){
			$error = false;
			$email = $_POST['email'];
			$name = $_POST['name'];
			$surname = $_POST['sname'];
			$password = $_POST['password'];
			$password2= $_POST['password2'];
			//Password correct?
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
				$error = true;
			}
			//Email Valid?
			if(!$error){
				$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
				$result =$statement->execute(array('email' => $email));
				$user = $statement->fetch();
				
				if($user !== false){
					echo 'Die E-Mail Adresse ist bereits vergeben <br />';
					$error = true;
				}
			}
			if(!$error){
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				
				$statement = $pdo->prepare("INSERT INTO users (email, password, vorname, nachname) VALUES (:email, :password, :vorname, :nachname)");
				$result = $statement->execute(array('email'=> $email, 'password'=> $password_hash, 'vorname'=>$name, 'nachname'=>$surname));
				if($result){
					header('location: login.php?register=1');
					$showFormular = false;
					die();
				}else{
					echo 'Beim Abspeichern ist ein Fehler aufgetreten <br />';
				}
			}
		}
		if($showFormular){
			?>
		<div class="w3-row">
    		<div class="w3-col" style="width:32.5%">
    			<p></p>
    		</div>
            <div class="w3-col" style="width:35%">
    			<form action="login/register.php?register=1" method="post" class="w3-container w3-center">
    				<label class="w3-left">Vorname:</label>
    				<input type="text" size="40" maxlength="250" name="name" placeholder="Max" class="w3-input" required><br />
    				<label class="w3-left">Nachname:</label>
    				<input type="text" size="40" maxlength="250" name="sname" placeholder="Mustermann" class="w3-input" required><br />
    				<label class="w3-left">E-Mail:</label>
    				<input type="email" size="40" maxlength="250" name="email" placeholder="example@example.com" class="w3-input" required><br /><br />
    				<label class="w3-left">Dein Passwort:</label>
    				<input type="password" size="40" maxlength="250" name="password" placeholder="*****" class="w3-input" required><br />
    				<label class="w3-left">Passwort wiederholen:</label>
    				<input type="password" size="40" maxlength="250" name="password2" placeholder="*****" class="w3-input" required><br />
    				<button type="submit" class="w3-button w3-black">Registrieren</button>
    			</form>
    			<div class="w3-center" style="margin-top: 2%;">
                	<a href="login/login.php" class="w3-button w3-black">Bereits Registriert? Zum Login</a>
                </div>
    		</div>
    		<div class="w3-col" style="width:32.5%">
    			<p></p>
    		</div>
		</div>
		<?php
		}
		?>
        <?php include '../php/footer.php';?>
	</body>
</html>