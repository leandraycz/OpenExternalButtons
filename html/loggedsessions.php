<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        $loggedusername = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM loggedusers WHERE userhash = '$userhash'"))["username"];
        $loggeduserid = mysqli_fetch_array(mysqli_query($conn, "SELECT id FROM loggedusers WHERE userhash = '$userhash'"))["id"];
        if(mysqli_fetch_array(mysqli_query($conn, "SELECT permissions FROM users WHERE username = '$loggedusername'"))["permissions"] != "Administrator") {
            print("Pro přístup musíte být přihlášen jako administrátor");
            die('<br><a href="index.php">Zpět na prihlášení</a>');
        } else {
            if(isset($_POST["logoutuser"])){
                if($_POST["id"] == $loggeduserid){
                    echo '<script>alert("Aktuální relaci zde nelze odhlásit, použijte tlačítko odhlášení na bočním panelu.");</script>';
                } else {
                    mysqli_query($conn, 'DELETE FROM loggedusers WHERE id = '.$_POST["id"]);
                }
            }

            if(isset($_POST["logoutall"])){
                mysqli_query($conn, "DELETE FROM loggedusers");
                header("Location: index.php");
            }
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
                    <th></th>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Čas přihlášení</th>
                    <th>Odhlásit</th>
                </tr>
                <?php
                    $usersresult = mysqli_query($conn, "SELECT * FROM loggedusers");
                    while($users = mysqli_fetch_array($usersresult, MYSQLI_ASSOC)){
                        print("<tr>");
                        if($users["id"] == $loggeduserid){
                            print("<td><p>Aktuální</p></td>");
                        }
                        else{
                            print("<td><p></p></td>");
                        }
                        print("<td><p>" . $users["id"] . "</p></td>");
                        print("<td><p>" . $users["username"] . "</p></td>");
                        print("<td><p>" . $users["loggedtime"] . "</p></td>");
                        print('<td><form action="loggedsessions.php" method="post"><input type="hidden" name="id" value="'.$users["id"].'"><input type="submit" name="logoutuser" value="Odhlásit"></form></td>');
                        print("</tr>");        
                    }
                ?>    
            </table>
            <hr>
            <form action="loggedsessions.php" method="post">
                <input type="submit" name="logoutall" value="Odhlásit vše">
            </form>
            <hr>
            <p>UPOZORNĚNÍ: Kliknutím na "Odhlásit vše" dojde k odhlášení všech příhlášených uživatelů včetně aktuální relace.</p>
        </div>
    </body>       
</html>