<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        mysqli_query($conn, "DELETE FROM loggedusers WHERE userhash = '$userhash'");
        header("Location: index.php");
    }
?>