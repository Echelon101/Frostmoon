<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<base href="../">
		<?php include '../php/headmeta.php';?>
	</head>
	<?php include '../php/cookiemodal.php';?>
		<?php include '../php/smallnavigation.php';?>
		<?php if(isset($_GET['register'])){?>
			<div class="w3-panel w3-green w3-display-container">
				<span onclick="this.parentElement.style.display='none'"
				class="w3-button w3-green w3-large w3-display-topright">&times;</span>
				<h3>Erfolgreich!</h3>
				<p>Sie sind registriert</p>
			</div>
		<?php }?>
		<?php
		/*if(isset($redir)){
			header("location: ".$_SESSION['lastpage']);
			die();
		}*/
		if(isset($_GET['login'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
			$result = $statement->execute(array('email' => $email));
			$user = $statement->fetch();
			
			//Check Password
			if($user !== false && password_verify($password, $user['password'])){
				//Debug Code Begin
				$_SESSION['userid'] = $user['id'];
				$_SESSION['username'] = $user['email'];
				//Debug Code End
				//die('Login erfolgreich. Weiter zu <a href="login/backend.php">Backend</a>');
				if (isset($_SESSION['lastpage'])){
					header("location: ". $_SESSION['lastpage']);
					die();
				}else{	
					header("location: ../index.php");
					die();
				}
			}
			else{
				$errorMessage = "E-Mail oder Passowrt ungültig<br />";
			}
		}
		?>
		
		<?php 
		if(isset($errorMessage)){
			echo $errorMessage;
		}
		?>
		<div class="" style="width:100%">
			<form action="login/login.php?login=1" method="post" class="w3-container w3-center w3-responsive">
				E-Mail:<br />
				<input type="email" size="40" maxlength="250" name="email" placeholder="example@example.com" class="w3-input"><br /> <br />
				Dein Passwort:<br />
				<input type="password" size="40" maxlength="250" name="password" placeholder="*****" class="w3-input"><br />
				<button type="submit" class="w3-button w3-black">Login</button>
			</form>
			<div class="w3-center" style="margin-top: 2%;">
			   	<a href="login/register.php" class="w3-button w3-black">Noch nicht registriert?</a>
			</div>
	    </div>
	</body>
</html>