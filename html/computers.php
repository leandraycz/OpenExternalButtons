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
            <a class="active">Počítače</a>
            <a href="network.php">Síť</a>
            <a href="system.php">Systém</a>
            <a href="users.php">Uživatelé</a>
            <a href="logout.php">Odhlásit se</a>
        </div>
        <div class="content">
            <h1>Správce počítačů</h1>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Power pin</th>
                    <th>Reset pin</th>
                    <th>Power button</th>
                    <th>Power button</th>
                    <th>Reset button</th>
                    <th>Upravit</th>
                    <th>Smazat</th>
                </tr>
                <?php
                    $computersresult = mysqli_query($conn, "SELECT * FROM computers");
                    while($computername = mysqli_fetch_assoc($computersresult)){
                        print("<tr>");
                        print("<td><p>" . $computername["id"] . "</p></td>");
                        print("<td><p>" . $computername["name"] . "</p></td>");
                        print("<td><p>" . $computername["powerpin"] . "</p></td>");
                        print("<td><p>" . $computername["resetpin"] . "</p></td>");
                        print('<td><form action="powerbuttonpress.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Stisknout"></form></td>');
                        print('<td><form action="powerbuttonhold.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Podržet"></form></td>');
                        print('<td><form action="resetbuttonpress.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Stisknout"></form></td>');
                        print('<td><form action="editcomputer.php" method="post"><input type="hidden" name="id" value="'.$computername["id"].'"><input type="submit" value="Upravit"></form></td>');
                        print('<td><form action="removecomputer.php" method="post"><input type="hidden" name="id" value="'.$computername["name"].'"><input type="submit" value="Smazat"></form></td>');
                        print("</tr>");
                    }
                ?>
            </table>
            <hr>
            <form action="addcomputer.php" method="post">
                <input type="submit" value="Přidat počítač">
            </form> 
        </div>
    </body>       
</html>