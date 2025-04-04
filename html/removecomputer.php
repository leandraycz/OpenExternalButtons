<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        $loggedusername = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM loggedusers WHERE userhash = '$userhash'"))["username"];
        if(mysqli_fetch_array(mysqli_query($conn, "SELECT permissions FROM users WHERE username = '$loggedusername'"))["permissions"] != "Administrator") {
            die("Pro přístup musíte být přihlášen jako administrátor");
        }

        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM loggedusers WHERE userhash = '$userhash'")) != 1){
            die("Pro přístup je nutné se přihlásit");
        }

        $name = $_POST["id"];        
        mysqli_query($conn, "DELETE FROM computers WHERE name = '$name'");
        header("Location: computers.php"); 
    }
    else{
        die("Pro přístup je nutné se přihlásit");
    }
?>