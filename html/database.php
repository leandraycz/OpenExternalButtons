<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "openexternalbuttons";
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Připojení k databázi selhalo: " . $conn->connect_error);
    }
?>