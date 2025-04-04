<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM loggedusers WHERE userhash = '$userhash'")) != 1){
            die("Pro přístup je nutné se přihlásit");
        }

        foreach($_POST as $name => $content) { // Most people refer to $key => $value
            shell_exec("./main -pp ". $name);
        }
        header("Location: home.php"); 
    }
    else{
        die("Pro přístup je nutné se přihlásit");
    }
?>