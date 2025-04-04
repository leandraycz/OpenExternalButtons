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

	$wifistatus = shell_exec("sudo /usr/bin/nmcli radio wifi");
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
            <a class="active">Síť</a>
            <a href="system.php">Systém</a>
            <a href="users.php">Uživatelé</a>
            <a href="logout.php">Odhlásit se</a>
        </div>
        <div class="content">
            <h1>Správce sítě</h1>
            <hr>
            <form action="networksave.php" method="post">
                <table>
                    <tr>
                        <td width=50%><p>Povolit bezdrátovou síť:</p></td>
                        <td width=50%><input name="allowwireless" type="checkbox" <?php if(trim($wifistatus) === "enabled"){print("checked");} ?>></td>
                    </tr>
                    <tr>
                        <td width=50%><p>Název sítě:</p></td>
                        <td width=50%><input name="wirelessname" type="text"></td>    
                    </tr>
                    <tr>
                        <td width=50%><p>Heslo:</p></td>
                        <td width=50%><input name="wirelesspassword" type="password"></td>    
                    </tr>   
                </table>
                <hr> 
                <input type="submit" name="submit" value="Uložit">
            </form>  
            <hr>
            <p>*IP bude nastavena přes DHCP server.</p>
        </div>
    </body>       
</html>
