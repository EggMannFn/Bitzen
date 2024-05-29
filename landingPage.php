<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitzen - Accumula le tue crypto</title>
    <link rel="stylesheet" href="landingPage.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
<header>
    <div class="container">
        <nav>
            <!-- manca il logo -->
            <div class="logo">BITZEN</div>
            <ul>
                <li class="btn_navbar"><a href="#">Compra Crypto</a></li>
                <li class="btn_navbar"><a href="#">Mercati</a></li>
                <li class="btn_navbar"><a href="#">Prezzi</a></li>
                <li class="btn_navbar"><a href="#">Trading</a></li>
                <li class="btn_navbar"><a href="#">Altro</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="./login/login.php" class="login">Accedi</a>
            <a href="./register/register.php" class="register">Registrati</a>
        </div>
    </div>
</header>

    <main>
        <div class="hero-section">
            <h1>Accumula le tue crypto in modo rapido e sicuro</h1>
            <p>Il metodo più veloce per convertire i tuoi soldi in criptovalute e conservare tutto in un unico posto sicuro.</p>
                <form action="./register/register.php" method="POST">
                    <input type="email" name="email" class="inp_email" placeholder="Indirizzo e-mail" required>
                    <input type="submit" value="Inizia ora" class="btn_iniziaOra">
                </form>
        </div>

        <div class="crypto-info">
            <div class="popular">
            <h2>Popolare</h2>
                <table class="crypto-table" id="most-popular">
                    <tbody>
                        <!-- Le righe saranno aggiunte dinamicamente qui -->
                    </tbody>
                </table>
            </div>

            <div class="new-listing">
                <h2>Nuovo listing</h2>
                <table class="crypto-table" id="new-listing">
                    <tbody>
                        <!-- Le righe saranno aggiunte dinamicamente qui -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="scriptLandingPage.js"></script>
</body>
</html>
