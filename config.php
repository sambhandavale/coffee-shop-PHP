<?php 
    define("HOSTNAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DBNAME", "registration");

    $con = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DBNAME) or die ("cannot connect to database.");

        //if($con) echo "You are connected." 

?>