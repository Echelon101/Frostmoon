<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname;", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Event</title>   
        <base href="../">
        <?php include '../php/headmeta.php';?>
    </head>
	<?php include '../php/cookiemodal.php';?>
    	<?php include '../php/navigation.php';?>
		<div class="w3-row">
		<div class="w3-col" style="width: 20%">
		<p>
		</p>
		</div>
		<div class="w3-col" style="width: 60%">     
		<?php 
			$Event_view_statement = $pdo->prepare("SELECT * FROM events");
			$Event_view_result = $Event_view_statement->execute();
			//whlie loop to create all events in database
			while ($Event_view_fetch = $Event_view_statement->fetch(PDO::FETCH_ASSOC)){
				?>
				<div class="w3-center">
					<p>
						<span style="font-weight: bold"><?php echo $Event_view_fetch['eventname'];?></span><br>
						Ort: <?php echo $Event_view_fetch['place'];?><br>
						Datum: <?php echo $Event_view_fetch['eventdate'];?><br>
						Zeit: Einlass <?php echo $Event_view_fetch['entrytime'];?> Uhr<br>
						Preis: <?php echo $Event_view_fetch['price'].'€';?><br>
						<br>
						<?php echo $Event_view_fetch['descr'];?><br>
						<?php if(isset($Event_view_fetch['imagepath'])){?>
						<br>
						<img src="uploads/<?php echo $Event_view_fetch['imagepath'];?>" style="width: 30%;height: auto;" ALT="Bild <?php echo $Event_view_fetch['eventname'];?>">
						<?php }?>
					</p>
					<a href="order/buy.php?event=<?php echo $Event_view_fetch['id'];?>" class="w3-button w3-black" style="margin-top: 1%;">Kaufe ab <?php echo $Event_view_fetch['price'].'€'?></a>
				</div>
				<hr>
				<?php 
			}
		?>
		</div>
		<div class="w3-col" style="width: 20%">
		<p>
		</p>
		</div>
		</div>
        <?php include '../php/footer.php';?>
    </body>
</html>