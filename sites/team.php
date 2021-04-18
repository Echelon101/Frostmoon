<?php 
include '../php/phpopening.php';
include '../config/config.php';
$pdo = new PDO("$driver:host=$hostname;dbname=$dbname;", "$dbuser", "$dbpassword");
?>
<!DOCTYPE html>
<html lang="de">

    <head>
        <title>Team</title>
        <base href="../">
        <?php include '../php/headmeta.php';?>
    </head>
	<?php include '../php/cookiemodal.php';?>
    	<?php include '../php/navigation.php';?>
        <div class="w3-row w3-center">
            <div class="w3-col" style="width:15%">
                <p></p>
            </div>
            <div class="w3-col" style="width:70%">
	            <div>
	            <p></p>
	            </div>
	            <?php 
	            //function to calculate the age
	            function calcutateAge($dob){
	            	
	            	$dob = date("Y-m-d",strtotime($dob));
	            	
	            	$dobObject = new DateTime($dob);
	            	$nowObject = new DateTime();
	            	
	            	$diff = $dobObject->diff($nowObject);
	            	
	            	return $diff->y;
	            	
	            }
	            $team_view_statement = $pdo->prepare("SELECT * FROM team");
	            $team_view_result = $team_view_statement->execute();
	            //while loop to view all team sets from datatbase
	            while ($team_view_fetch = $team_view_statement->fetch(PDO::FETCH_ASSOC)){
				$age = calcutateAge($team_view_fetch['Geburtsdatum']);	            
	            ?>
	            <div>
	            <p></p>
	            </div>
				<div class="w3-card-2 w3-center">
					<?php if(isset($team_view_fetch['image'])){?>
	                <img src="uploads/<?php echo $team_view_fetch['image'];?>" ALT="Bild <?php echo $team_view_fetch['Vorname'].' '.$team_view_fetch['Nachname'];?>" style="width: 20%; height: auto;">
	                <?php }?>
	                <div class="w3-container w3-center">
	                	<p><?php echo $team_view_fetch['Vorname'].' '.$team_view_fetch['Nachname'].', '.$age.' Jahre'?></p>
	                	<p><?php echo $team_view_fetch['descr'];?></p>
	                </div>
            	</div>
				<hr>
	            <?php 
				}
	            ?>       
            </div>
            <div class="w3-col" style="width:15%">
            	<p></p>
            </div>
        </div>      
        <?php include '../php/footer.php';?>
	</body> 
</html>