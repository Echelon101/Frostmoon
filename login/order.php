<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orders</title>   
        <base href="../">
        <?php include '../php/headmeta.php';?>
    </head>
	<?php include '../php/cookiemodal.php';?>
    	<?php include '../php/navigation.php';?>
		<?php if(isset($_SESSION['userid'])){?>
        <div class="w3-row">
    		<div class="w3-col" style="width:10%">
    			<p></p>
    		</div>
            <div class="w3-col" style="width:80%;">
	            <div><p></p></div>
	    		<div id="Orders" class="w3-container-item w3-center">
						<?php 
						$Order_list_statement = $pdo->prepare("SELECT * FROM orders WHERE username = :username");
						$Order_list_result = $Order_list_statement->execute(array('username' => $_SESSION['username']));
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
									<th>Stornieren</th>
								</tr>
							<?php
							//while loop to fill the order Table
							while ($Order_list_fetch = $Order_list_statement->fetch(PDO::FETCH_ASSOC)){
								$adress = $Order_list_fetch['street'] . ', ' . $Order_list_fetch['hsnr'] . ' ' . $Order_list_fetch['plz'] . ' ' . $Order_list_fetch['city'];
								$urlencodeCancelOrder = "a=s&o=order&id=".$Order_list_fetch['id'];
								echo '<tr>';
								echo "<td>".$Order_list_fetch['id']."</td>";
								echo "<td>".$Order_list_fetch['username']."</td>";
								echo "<td>".$adress."</td>";
								echo "<td>".$Order_list_fetch['eventname']."</td>";
								echo "<td>".$Order_list_fetch['tickettype']."</td>";
								echo "<td>".$Order_list_fetch['ticketcount']."</td>";
								echo "<td>".$Order_list_fetch['price']."€</td>";
								echo "<td>".$Order_list_fetch['payvar']."</td>";
								echo "<td>".$Order_list_fetch['state']."</td>";
								echo "<td>".$Order_list_fetch['created_at']."</td>";
								echo "<td>";
								if($Order_list_fetch['state'] != "storniert"){
									echo '<a href="admin/edit.php?'.$urlencodeCancelOrder.'">Stornieren</a>';
								}else{
									echo 'Breits Storniert';
								}
		            			echo "</td>";
								echo '</tr>';
							}
							?>
						</table>
					</div>
				</div>
    		</div>
    		<div class="w3-col" style="width:20%;">
    			<p></p>
    		</div>
		</div> 
		<?php }else{
		echo 'Bitte Einloggen';
		}?>        
        <?php include '../php/footer.php';?>
    </body>
</html>
