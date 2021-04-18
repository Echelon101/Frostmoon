<?php
$release = false; //Wenn der Wert auf True steht werden die Zugangsdaten des Schulservers verwendet!
if($release){
	$driver = 'mysql';
	$hostname = 'localhost';
	$dbname = 'projekte_its16_t4';
	$dbuser = 'its16_t4';
	$dbpassword = 'cC1f9!e0';
}else{
	$driver = 'mysql';
	$hostname = 'localhost';
	$dbname = 'users';
	$dbuser = 'root';
	$dbpassword = '';
}