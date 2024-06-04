<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITZEN | Login</title>
    <link rel="stylesheet" href="../navbar.css">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" type="image/x-icon" href="../logo.ico">
</head>
<body>
<header>
    <div class="container">
        <nav>
            <!-- manca il logo -->
            <div><a class="logo" href="../index.php">BITZEN</a></div>
            <ul>
                <li class="btn_navbar"><a href="#">Compra Crypto</a></li>
                <li class="btn_navbar"><a href="#">Mercati</a></li>
                <li class="btn_navbar"><a href="#">Prezzi</a></li>
                <li class="btn_navbar"><a href="#">Trading</a></li>
                <li class="btn_navbar"><a href="#">Altro</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="../login/login.php" class="button-nav login">Accedi</a>
            <a href="../register/register.php" class="button-nav register">Registrati</a>
        </div>
        
    </div>
</header>
    <?php
    $email = "";
    $password = "";

    if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        $email = $_COOKIE["email"];
        $password = $_COOKIE["password"];

        header("refresh:0; url=scriptLogin.php");
    }
    ?>

    <h1>Accedi al tuo account di Bitzen!</h1>

    <div class="login">
        <form action="scriptLogin.php" method="post">
            <div class="form_group">
                <label for="email">Email</label>
            <input type="text" name="email" id="id_email" value="<?=$email?>" placeholder="email">
            </div>
            <div class="form_group">
                <label for="password">Password</label>
                <input type="password" name="password" id="id_password" value="<?=$password?>" placeholder="password">
            </div>
            <div class="form_groupRicordami">
                <input type="checkbox" name="ricordami">
                <label for="ricordami" class="ricordaLabel">Ricorda le mie credenziali</label>
            </div>

            <input type="submit" value="Accedi" id="btn_accedi">
        </form>
    </div>

    <!-- <h2>Oppure</h2>
    
    <form action="../register/register.php" method="post">
            <p><input type="submit" value="Registrati" id="btn_registrati"></p>
        </form> -->
</body>

</html>