<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione - Bitzen</title>
    <link rel="stylesheet" href="registratiTEO.css">
</head>
<body>
    <nav>
        <div class="logo">BITZEN</div>
        <ul>
            <li><a href="#">Compra Crypto</a></li>
            <li><a href="#">Mercati</a></li>
            <li><a href="#">Prezzi</a></li>
            <li><a href="#">Trading</a></li>
            <li><a href="#">Altro</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="#" class="login">Accedi</a>
            <a href="#" class="register">Registrati</a>
        </div>
    </nav>
    <main>
        <div class="form-container">
            <h1>Crea ora il tuo account su Bitzen!</h1>

            <form action="scriptRegistratiTEO.php" method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required placeholder="Andrea">
                </div>
                <div class="form-group">
                    <label for="cognome">Cognome</label>
                    <input type="text" id="cognome" name="cognome" required placeholder="Maffi">
                </div>
                <div class="form-group">
                    <label for="data_nascita">Data di Nascita</label>
                    <input type="date" id="data_nascita" name="data_nascita" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" id="telefono" name="telefono" required placeholder="3518736524">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="latuamail@dominio.it">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Conferma Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">Creando un account, accetto i <a href="#">Termini di servizio</a> e l'<a href="#">Informativa sulla privacy</a> di Bitzen.</label>
                </div>
                
                <!-- Display error messages based on URL parameters -->
                <p><?php if (isset($_GET["passwordMismatch"]) && $_GET["passwordMismatch"] == "true") echo "Le password inserite non coincidono! Riprovare!"; ?></p>
                <p><?php if (isset($_GET["alreadyRegistered"]) && $_GET["alreadyRegistered"] == "true") echo "Email già registrata! Riprovare!"; ?></p>
                <p><?php if (isset($_GET["registrationFailed"]) && $_GET["registrationFailed"] == "true") echo "Registrazione fallita! Riprovare!"; ?></p>
                <p><?php if (isset($_GET["missingFields"]) && $_GET["missingFields"] == "true") echo "Compila tutti i campi!"; ?></p>

                <input type="submit" value="Crea account">
            </form>
        </div>
    </main>
</body>

</html>
