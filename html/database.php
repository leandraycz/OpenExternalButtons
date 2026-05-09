<?php
    //$db_pass_file = fopen("/etc/OEB/dbpassword.txt", "r");
    //$db_pass = fread($db_pass_file, filesize("/etc/OEB/dbpassword.txt"));

    $servername = "localhost";
    $username = "root";
    $password = ""; //str_replace(PHP_EOL, "", $db_pass);
    $database = "openexternalbuttons";
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Připojení k databázi selhalo: " . $conn->connect_error);
    }
?>
