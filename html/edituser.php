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

        if(isset($_POST["submit"])){
            $id = $_POST["id"];
            $username = $_POST["username"];
            $userpermission = $_POST["userpermission"];
            $password = $_POST["password"];
            $repeatedpassword = $_POST["repeatpassword"];

            if($password == $repeatedpassword){
                $hashedpassword = hash('sha256', $password);
                mysqli_query($conn, "UPDATE users SET username = '$username' , password = '$hashedpassword', permissions = '$userpermission' WHERE id = '$id'");
                header("Location: users.php");
            }
            else{
                echo '<script>alert("Hesla se musejí shodovat");</script>';
            }
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
            <h1>Upravit uživatele</h1>
            <hr>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Jméno</th>
                    <th>Oprávnění</th>
                    <th>Heslo</th>
                    <th>Heslo znovu</th>
                </tr>
                    <?php
                        $userid = $_POST["id"];
                        $result = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id = '$userid'"));
                        print("<tr>");
                        print("<td><p>" .$result["id"]. "</p></td>");
                        print('<form action="edituser.php" method="post">');
                        print('<td><input type="text" name="username" value="'.$result["username"].'" required></td>');
                        print("<td>");

                        print('<select name="userpermission">');
                        print('<option value="Administrator" ');
                        if($result["permissions"] == "Administrator"){print("selected");}
                        print('>Administrator</option>');

                        print('<option value="User" ');
                        if($result["permissions"] == "User"){print("selected");}
                        print('>User</option>');

                        print('</select>');
                        print("</td>");
                        print('<td><input type="password" name="password" required></td>');
                        print('<td><input type="password" name="repeatpassword" required></td>');              
                        print("</tr>");
                        print('<input type="hidden" name="id" value="'.$userid.'"><input type="submit" name="submit" value="Uložit">');
                        print("</form>");
                    ?>
            </table>    
        </div>
    </body>       
</html>