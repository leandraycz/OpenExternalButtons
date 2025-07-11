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
    }
    else{
        print("Pro přístup je nutné se přihlásit");
        die('<br><a href="index.php">Zpět na prihlášení</a>');
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
            <a href="system.php">Systém</a>
            <a class="active">Uživatelé</a>
            <a href="logout.php">Odhlásit se</a>
        </div>
        <div class="content">
            <h1>Správce uživatelů</h1>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Oprávnění</th>
                    <th>Upravit</th>
                    <th>Smazat</th>
                </tr>
                <?php
                    $usersresult = mysqli_query($conn, "SELECT * FROM users");
                    while($users = mysqli_fetch_array($usersresult, MYSQLI_ASSOC)){
                        print("<tr>");
                        print("<td><p>" . $users["id"] . "</p></td>");
                        print("<td><p>" . $users["username"] . "</p></td>");
                        print("<td><p>" . $users["permissions"] . "</p></td>");
                        print('<td><form action="edituser.php" method="post"><input type="hidden" name="id" value="'.$users["id"].'"><input type="submit" value="Upravit"></form></td>');
                        print('<td><form action="removeuser.php" method="post"><input type="hidden" name="id" value="'.$users["id"].'"><input type="submit" name="remsubmit" value="Smazat"></form></td>');
                        print("</tr>");        
                    }
                ?>    
            </table>
            <hr>
            <form action="adduser.php" method="post">
                <input type="submit" name="submit" value="Přidat uživatele">
            </form>
        </div>
    </body>       
</html>