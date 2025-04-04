<?php
    include("database.php");
    if(isset($_COOKIE["userhash"])){
        $userhash = $_COOKIE["userhash"];

        $loggedusername = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM loggedusers WHERE userhash = '$userhash'"))["username"];
        if(mysqli_fetch_array(mysqli_query($conn, "SELECT permissions FROM users WHERE username = '$loggedusername'"))["permissions"] == "Administrator") {
            $isadmin = true;
        }
        else{
            $isadmin = false;
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
            <?php
                if($isadmin == true){ 
                    print('<a class="active">Domů</a>');
                    print('<a href="computers.php">Počítače</a>');
                    print('<a href="network.php">Síť</a>');
                    print('<a href="system.php">Systém</a>');
                    print('<a href="users.php">Uživatelé</a>');
                    print('<a href="logout.php">Odhlásit se</a>');
                }
                else{
                    print('<a class="active">Domů</a>');
                    print('<a href="logout.php">Odhlásit se</a>');
                }
            ?>
        </div>
        <div class="content">
            <h1>Domovská stránka</h1>
            <hr>
            <table>
                <tr>
                    <th>Jméno</th>
                    <th>Power button</th>
                    <th>Power button</th>
                    <th>Reset button</th>
                </tr>
                <?php
                    $computersresult = mysqli_query($conn, "SELECT name FROM computers");
                    while($computername = mysqli_fetch_array($computersresult, MYSQLI_ASSOC)){
                        print("<tr>");
                        foreach($computername as $item){
                            print("<td><p>" . $computername["name"] . "</p></td>");
                            print('<td><form action="powerbuttonpress.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Stisknout"></form></td>');
                            print('<td><form action="powerbuttonhold.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Podržet"></form></td>');
                            print('<td><form action="resetbuttonpress.php" method="post"><input type="submit" name="'.$computername["name"].'" value="Stisknout"></form></td>');
                        }
                        print("</tr>");
                    }
                ?>
            </table>    
        </div>
    </body>       
</html>    