<?php
//PHP Session beenden
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logout</title>
        <base href="../">
        <?php include '../php/headmeta.php';?>
    </head>
    <body>
    	<?php include '../php/navigation.php';?>
        <?php
        if(isset($_GET['resetPW'])){
        	header('location: ../index.php?reset=1');
        }else{
        	header('location: ../index.php?logout=1');
        }
        ?>
    </body>
</html>