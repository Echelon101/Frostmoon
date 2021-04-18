<?php include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname;", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Team</title>
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
            <div class="snap-drawer snap-drawer-right"></div>
        </div>   
        <div id="content" class="snap-content">
            <div id="toolbar" style="margin-top: 1%;">
				<button id="MenueButton" class="material-icons w3-button" style="font-size:48px;">&#xe5d2;</button>
			</div>
            <?php 
	            function calcutateAge($dob){
	            	
	            	$dob = date("Y-m-d",strtotime($dob));
	            	
	            	$dobObject = new DateTime($dob);
	            	$nowObject = new DateTime();
	            	
	            	$diff = $dobObject->diff($nowObject);
	            	
	            	return $diff->y;
	            	
	            }
	            $team_view_statement = $pdo->prepare("SELECT * FROM team");
	            $team_view_result = $team_view_statement->execute();
	            while ($team_view_fetch = $team_view_statement->fetch(PDO::FETCH_ASSOC)){
				$age = calcutateAge($team_view_fetch['Geburtsdatum']);	            
	            ?>
	            <div>
	            <p></p>
	            </div>
				<div class="w3-card-2 w3-center" style="margin-left: 2%; margin-right: 2%">
	                <img src="../uploads/<?php echo $team_view_fetch['image'];?>" ALT="Bild <?php echo $team_view_fetch['Vorname'].' '.$team_view_fetch['Nachname'];?>" style="width: 50%; height: auto; margin-top: 1%">
	                <div class="w3-container w3-center">
	                	<p><?php echo $team_view_fetch['Vorname'].' '.$team_view_fetch['Nachname'].', '.$age.' Jahre'?></p>
	                	<p><?php echo $team_view_fetch['descr'];?></p>
	                </div>
            	</div>
            	<hr style="margin-left: 2%; margin-right: 2%">
				
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