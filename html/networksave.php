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

        if(isset($_POST["submit"])){
            if(isset($_POST["allowwireless"])){
                $wirelessname = $_POST["wirelessname"];
                $wirelesspassword = $_POST["wirelesspassword"];

                shell_exec("nmcli radio wifi on");
                shell_exec('nmcli dev wifi connect "' . $wirelessname . '" password "' . $wirelesspassword . '"');
            }
            else{
                shell_exec("nmcli radio wifi off");
            }
            
            header("Location: network.php");
        }
    }
    else{
        die("Pro přístup je nutné se přihlásit");
    }
?>
