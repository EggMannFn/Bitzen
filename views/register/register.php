<?php
require_once ("../../config/config.php");

if (isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["data_nascita"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["terms"])) {

    if (strlen($_POST["nome"]) < 5 || strlen($_POST["cognome"]) < 5) {
        header("Refresh:0;url=register.php?usernameMin5Lenght=false");
    } else if ($_POST["password"] !== $_POST["confirm_password"]) {
        header("Refresh:0;url=register.php?passwordErrate=true");
    } else {
        header("Refresh:0; url=scriptRegister.php");
    }
}

//precompilo il campo email con la mail inserita nella landingPage
$email = isset($_POST['email']) ? $_POST['email'] : '';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITZEN | Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="../../styles/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../assets/icons/logo.ico">
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
            <a href="../login/login.php" class="login">Accedi</a>
            <a href="../register/register.php" class="register">Registrati</a>
        </div>
    </div>
</header>
    <main>
        <h1>Crea ora il tuo account su Bitzen!</h1>
        <div class="form-container">
            <form action="scriptRegister.php" method="post" id="registrationForm">


            <div class="div-allinea">
            <div class="form-group-line">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" required placeholder="Andrea">
                    </div>
                    <div class="form-group-line" id="margin">
                        <label for="cognome">Cognome</label>
                        <input type="text" id="cognome" name="cognome" required placeholder="Maffi">
                    </div>
            </div>


            <div class="div-allinea">
            <div class="form-group-line">
                    <label for="data_nascita">Data di Nascita</label>
                    <input type="date" id="data_nascita" name="data_nascita" required>
                </div>
                <div class="form-group-line" id="margin">
                    <label for="telefono">Telefono</label>
                    <input type="text" id="telefono" name="telefono" required placeholder="3518736524">
                </div>

            </div>
                

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="latuamail@dominio.it" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Conferma Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <div class="form-group form-group-inline">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label class="cbx_content" for="terms">Creando un account, accetto i <a href="#">Termini di servizio</a> e l'<a href="#">Informativa sulla privacy</a> di Bitzen.</label>
                </div>


                <input type="submit" value="Crea account">
            </form>
        </div>
    </main>
    <script src="../../scripts/register.js" defer></script>
</body>
</html>
