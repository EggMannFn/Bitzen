<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    $email = "";
    $password = "";

    if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        $email = $_COOKIE["email"];
        $password = $_COOKIE["password"];

        header("refresh:0; url=scriptLogin.php");
    }
    ?>

    <div class="login">
        <form action="scriptLogin.php" method="post">
            <p><input type="text" name="email" id="id_email" value="<?=$email?>" placeholder="email"></p>
            <p><input type="password" name="password" id="id_password" value="<?=$password?>" placeholder="password"></p>
            <p><input type="checkbox" name="ricordami"></p>

            <p><input type="submit" value="Accedi" id="btn_accedi"></p>
        </form>
    </div>

    <h2>Oppure</h2>
    
    <form action="../register/register.php" method="post">
            <p><input type="submit" value="Registrati" id="btn_registrati"></p>
        </form>
</body>

</html>