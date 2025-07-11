<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM loggedusers WHERE userhash = '$userhash'")) != 1){
            print("Pro přístup je nutné se přihlásit");
            die('<br><a href="index.php">Zpět na prihlášení</a>');
        }

        foreach($_POST as $name => $content) {
            shell_exec("./main -pr ". $name);
        }
        header("Location: home.php"); 
    }
    else{
        print("Pro přístup je nutné se přihlásit");
        die('<br><a href="index.php">Zpět na prihlášení</a>');
    }
?>