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
            $computerid = ($_POST["id"]);
            $newname = $_POST["name"];
            $newpowerpin = $_POST["powerpin"];
            $newresetpin = $_POST["resetpin"];
            mysqli_query($conn, "UPDATE computers SET name = '$newname' , powerpin = '$newpowerpin' , resetpin = '$newresetpin' WHERE id = '$computerid'");
            header("Location: computers.php");
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
            <a class="active">Počítače</a>
            <a href="network.php">Síť</a>
            <a href="system.php">Systém</a>
            <a href="users.php">Uživatelé</a>
            <a href="logout.php">Odhlásit se</a>
        </div>
        <div class="content">
            <h1>Upravit počítač</h1>
            <hr>
            <?php
                $id = $_POST["id"];
                $computersresult = mysqli_query($conn, "SELECT * FROM computers WHERE id = '$id'");
                $computers_assoc = mysqli_fetch_assoc($computersresult);
                print('<form action="editcomputer.php" method="post">');
                print("<table>");
                print("<tr>"); 
                print("<th>ID</th>");
                print("<th>Název</th>");
                print("<th>Power pin</th>");
                print("<th>Reset pin</th>");
                print("</tr>");
                print("<tr>");
                print("<td><p>".$computers_assoc["id"]."</p></td>");
                print('<td><input type="text" name="name" value="'.$computers_assoc["name"].'" required></td>');
                print('<td>');
                print('<select name="powerpin">');
                for($i = 0; $i <= 27; $i++){
                    print('<option value="'.$i.'"');
                    if($computers_assoc["powerpin"] == $i){print("selected");} 
                    print(' required>'.$i.'</option>');
                }
                print('</select>');
                print("</td>");
                print("<td>");
                print('<select name="resetpin">');
                for($i = 0; $i <= 27; $i++){
                    print('<option value="'.$i.'"');
                    if($computers_assoc["resetpin"] == $i){print("selected");} 
                    print(' required>'.$i.'</option>');
                }
                print('</select>');
                print("</td>");
                print("</table>");
                print("<hr>");
                print('<input type="hidden" value="'.$computers_assoc["id"].'" name="id">'); 
                print('<input type="submit" name="submit" value="Uložit">');
                print("</form>");
            ?>
        </div>
    </body>       
</html>