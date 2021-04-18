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
        <?php include '../php/snapheadmeta.php';?>
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
			<?php 
			$Event_view_statement = $pdo->prepare("SELECT * FROM events");
			$Event_view_result = $Event_view_statement->execute();
			
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
						<img src="../uploads/<?php echo $Event_view_fetch['imagepath'];?>" style="width: 75%;height: auto;" ALT="Bild <?php echo $Event_view_fetch['eventname'];?>">
						<?php }?>
					</p>
					<a href="order/buy.php?event=<?php echo $Event_view_fetch['id'];?>" class="w3-button w3-black" style="margin-top: 1%;">Kaufe ab <?php echo $Event_view_fetch['price'].'€'?></a>
				</div>
				<hr>
				<?php 
			}
			?>
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