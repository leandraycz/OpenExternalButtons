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
    }
    else{
        die("Pro přístup je nutné se přihlásit");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="toppanel">
            <h1>Open External Buttons</h1>
        </div>
        <div class="sidebar">
            <a href="home.php">Domů</a>
            <a href="computers.php">Počítače</a>
            <a href="network.php">Síť</a>
            <a class="active">Systém</a>
            <a href="users.php">Uživatelé</a>
            <a href="logout.php">Odhlásit se</a>
        </div>
        <div class="content">
            <h1>Správce systému</h1>
            <hr>
            <form action="reboot.php" mathod="post">
                <input type="submit" name="rebootsubmit" value="Restartovat">
            </form> 
            <hr>
            <table>
                <tr>
                    <td width=50%><p>Verze softwaru: </p></td>
                    <td width=50%><p>1.0.0.0</p></td>
                </tr>
                <tr>
                    <td width=50%><p>Vývojář: </p></td>
                    <td width=50%><p>Radim Krejčiřík</p></td>
                </tr>
                <tr>
                    <td width=50%><p>Verze operačního systému: </p></td>
                    <td width=50%><p><?php print(php_uname());?></p></td>
                </tr>        
            </table> 
            <hr>
              
        </div>
    </body>       
</html>
