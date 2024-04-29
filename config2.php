<?php
    define("HOSTNAME2", "localhost");
    define("USERNAME2", "root");
    define("PASSWORD2", "");
    define("DBNAME2", "orders");

    $con2 = mysqli_connect(HOSTNAME2,USERNAME2,PASSWORD2,DBNAME2) or die ("cannot connect to database.");

        //if($con) echo "You are connected." 

?>