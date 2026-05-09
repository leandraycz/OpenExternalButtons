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

        //Stisknutí napájecího tlačítka
        if(isset($_POST["powerpress"])){
            shell_exec("oeb --powerpress ". $_POST["powerpressname"]);
        }

        //Podržení napájecího tlačítka
        if(isset($_POST["powerhold"])){
            shell_exec("oeb --powerhold ". $_POST["powerholdname"]);
        }

        //Stisknutí resetovacího tlačítka
        if(isset($_POST["resetpress"])){
            shell_exec("oeb --resetpress ". $_POST["resetpressname"]);
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
                            print('<td><form sction="home.php" method="post"><input type="hidden" name="powerpressname" value="' . $computername["name"] . '"><input type="submit" name="powerpress" value="Stisknout"></form></td>');
                            print('<td><form action="home.php" method="post"><input type="hidden" name="powerholdname" value="' . $computername["name"] . '"><input type="submit" name="powerhold" value="Podržet"></form></td>');
                            print('<td><form action="home.php" method="post"><input type="hidden" name="resetpressname" value="' . $computername["name"] . '"><input type="submit" name="resetpress" value="Stisknout"></form></td>');
                        }
                        print("</tr>");
                    }
                ?>
            </table>    
        </div>
    </body>       
</html>    
