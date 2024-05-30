<?php
require_once "./processing/config.php";
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"]) && isset($_POST["data_di_nascita"])) {

    if(strlen($_POST["username"]) < 5){
        header("Refresh:0;url=register.php?usernameMin5Lenght=false");
    }
    else if($_POST["password"] !== $_POST["password2"])
        header("Refresh:0;url=register.php?passwordErrate=true");
    else {
        header("Refresh:0; url=./processing/scriptRegister.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
</head>
<body>
    <div class="formContainer">
        <form action="./processing/scriptRegister.php" method="post">
            <input type="text" name="username" placeholder="username">
            <input type="email" name="email" id="" placeholder="latuamail@dominio.it">
            <input type="password" name="password" id="" placeholder="password">
            <input type="password" name="password2" id="" placeholder=" conferma password">
            <input type="date" name="data_di_nascita" id="" placeholder="data di nascita">
            <input type="submit" value="Registrati">
        </form>
    </div>
</body>
</html>