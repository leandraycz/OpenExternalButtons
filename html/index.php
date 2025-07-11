<?php
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $hash = hash('sha256', $password);

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hash'";

        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $loggedUserHash = bin2hex(random_bytes(10));
            mysqli_query($conn, "INSERT INTO loggedusers (username, userhash) VALUES ('$username', '$loggedUserHash')");
            setcookie("userhash", $loggedUserHash);
            header("Location: home.php");
        }
        else{
            echo '<script>alert("Špatné uživatelské jméno nebo heslo");</script>';
        }
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
        <div class="loginscreen">
            <h1>Přihlásit se</h1>
            <form action="index.php" method="post">
                <input type="text" placeholder="Uživatelské jméno" name="username" required>
                <br>
                <input type="password" placeholder="Heslo" name="password" required>
                <br>
                <input type="submit" value="Přihlásit se">
            </form>
        </div>
    </body>
</html>