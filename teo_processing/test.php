<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo" class="logo"> <!-- Assicurati di avere il logo corretto -->
        <nav>
            <a href="#">Compra Crypto</a>
            <a href="#">Mercati</a>
            <a href="#">Prezzi</a>
            <a href="#">Trading</a>
            <a href="#">Altro</a>
        </nav>
        <div class="auth-links">
            <a href="#">Accedi</a>
            <a href="#" class="register-btn">Registrati</a>
        </div>
    </header>
    
    <div class="login-container">
        <h1>Accedi</h1>
        <form action="./processing/scriptLogin.php" method="post">
            <label for="id_nome">Indirizzo Email</label>
            <input type="text" name="username" id="id_nome" placeholder="email@example.com">
            
            <div class="password-label-container">
                <label for="id_password">Password</label>
                <a href="#" class="forgot-password">Dimenticato la tua password?</a>
            </div>
            <input type="password" name="password" id="id_password" placeholder="password">
            
            <div class="remember-me">
                <input type="checkbox" name="ricordami" id="remember">
                <label for="remember">Ricorda le mie credenziali</label>
            </div>
            
            <input type="submit" value="Accedi" id="btn_accedi">
        </form>
        
        <p>Non hai ancora un conto? <a href="register.php">Iscriviti</a></p>
    </div>
</body>
</html>
