<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        $loggedusername = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM loggedusers WHERE userhash = '$userhash'"))["username"];
        if(mysqli_fetch_array(mysqli_query($conn, "SELECT permissions FROM users WHERE username = '$loggedusername'"))["permissions"] != "Administrator") {
            print("Pro přístup musíte být přihlášen jako administrátor");
            die('<br><a href="index.php">Zpět na prihlášení</a>');
        }

        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM loggedusers WHERE userhash = '$userhash'")) != 1){
            print("Pro přístup je nutné se přihlásit");
            die('<br><a href="index.php">Zpět na prihlášení</a>');
        }

        if(isset($_POST["remsubmit"])){
            $userid = $_POST["id"];
            
            if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE permissions = 'Administrator'")) == 1 or mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE permissions = 'User'")) == 1){
                echo '<script>alert("Posledního uživatele či administrátora nelze odstranit"); window.location.href = "users.php";</script>';
            }
            else{           
                mysqli_query($conn, "DELETE FROM users WHERE id = '$userid'");
            }
        }
    }
    else{
        print("Pro přístup je nutné se přihlásit");
        die('<br><a href="index.php">Zpět na prihlášení</a>');
    }
?>
