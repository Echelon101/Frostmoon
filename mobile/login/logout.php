<?php
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
    	<?php include '../php/smallnavigation.php';?>
        <?php
        header('location: ../index.php?logout=1');
        ?>
    </body>
</html>