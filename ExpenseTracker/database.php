<?php
    $host = 'localhost';
    $user = 'root';
    $password = 'bcmchabruno0';
    $database = 'expense_tracker';
    $port = 3308;



    $connection = new mysqli($host, $user, $password, $database, $port);

    if($connection->connect_error){
        die();
        echo "alert('error connecting to database')";
    }


?>
