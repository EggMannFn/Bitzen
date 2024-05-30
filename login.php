<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    $username = "";
    $password = "";

    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];
        header("refresh:0; url=./processing/scriptLogin.php");
    }
    ?>

    <div class="login">
        <form action="./processing/scriptLogin.php" method="post">
            <p><input type="text" name="username" id="id_nome" value="<?=$username?>" placeholder="username"></p>
            <p><input type="password" name="password" id="id_password" value="<?=$password?>" placeholder="password"></p>
            <p><input type="checkbox" name="ricordami"></p>
            <p><input type="submit" value="Accedi" id="btn_accedi"></p>
        </form>
    </div>
    <h2>Oppure</h2>
    <form action="register.php" method="post">
            <p><input type="submit" value="Registrati" id="btn_registrati"></p>
        </form>
</body>

</html>