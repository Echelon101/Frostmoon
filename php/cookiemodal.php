    <?php
	    if(isset($_SESSION['CookieJar'])){
	    echo '<body>';
	    }else{
	    echo'<body onload="JsCookieJar()">';
	    }
    ?>
	<?php include '../php/CookieJar.php';?>  