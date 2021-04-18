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
        <?php include '../php/snapheadmeta.php';?>
        <!--<link href="customcss/order_table.css" type="text/css" rel="stylesheet"> -->
    </head>
	<?php include '../php/cookiemodal.php';?>
    <div class="snap-drawers w3-black">
            <div class="snap-drawer snap-drawer-left w3-black">
                <div>
                    <h4 class="w3-center">Menü</h4>
						<?php include '../php/mnavigation.php';?>
                </div>
            </div>
        </div> 
        <div id="content" class="snap-content">
            <div id="toolbar" style="margin-top: 1%;">
				<button id="MenueButton" class="material-icons w3-button" style="font-size:48px;">&#xe5d2;</button>
			</div>
					<?php if(isset($_SESSION['userid'])){?>
	    		<div id="Orders" class="w3-container-item" style="margin:3%; overflow-x:auto; display: block;"> <!--overflow-x:auto; display: block;-->
						<?php 
						$Order_list_statement = $pdo->prepare("SELECT * FROM orders WHERE username = :username");
						$Order_list_result = $Order_list_statement->execute(array('username' => $_SESSION['username']));
						//Create table for each dataset custom for mobile sites
						$saveset = array();
            
						while ($Order_list_fetch = $Order_list_statement->fetch(PDO::FETCH_ASSOC)){
							echo '<table class="w3-table-all">';
							$adress = $Order_list_fetch['street'] . ', ' . $Order_list_fetch['hsnr'] . ' ' . $Order_list_fetch['plz'] . ' ' . $Order_list_fetch['city'];
							$urlencodeCancelOrder = "a=s&o=order&id=".$Order_list_fetch['id'];
							echo '<tr class="w3-grey"><th>OrderID</th></tr>';
                            
                            echo '<tr>';
							echo "<td>".$Order_list_fetch['id']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Nutzername</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['username']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Adresse</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$adress."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Eventname</th></tr>';
                            
                            echo '<tr>';
							echo "<td>".$Order_list_fetch['eventname']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>TicketTyp</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['tickettype']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Anzahl</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['ticketcount']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Preis</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['price']."€</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Bezahlmethode</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['payvar']."</td>";
                            echo "</tr>";
                            
                            echo '<tr class="w3-grey"><th>Erstellungsdatum</th></tr>';
                            
                            echo "<tr>";
							echo "<td>".$Order_list_fetch['created_at']."</td>";
							echo '</tr>';
							
							echo '<tr class="w3-grey"><th>Stornieren</th></tr>';
							
							echo "<tr>";
							echo "<td>";
							if($Order_list_fetch['state'] == "offen"){
								echo '<a href="admin/edit.php?'.$urlencodeCancelOrder.'">Stornieren</a>';
							}else{
								echo 'Breits Storniert';
							}
							echo "</td>";
							echo '</tr>';
							echo '</table>';
						}
						?>
				</div>
		<?php }else{
		echo 'Bitte Einloggen';
		}?> 
			<?php include '../php/mfooter.php';?>
        </div>
        <script type="text/javascript" src="../libs/snap/snap.js"></script>
        <script type="text/javascript">
            var snapper = new Snap({
                element: document.getElementById('content')
            });   
        </script>
        <script>
				MenueButton.addEventListener('click', function(){
				if( snapper.state().state=="left" ){
				snapper.close();
				} else {
					snapper.open('left');
				}
			});
		</script>
    </body>
</html>