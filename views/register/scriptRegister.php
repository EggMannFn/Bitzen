<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ("../../config/config.php");

if(isset($_POST["email"], $_POST["password"], $_POST["confirm_password"], $_POST["data_nascita"], $_POST["telefono"])){

    // Controllo se le password corrispondono
    if ($_POST["password"] !== $_POST["confirm_password"]) {
        header("refresh:0; url=register.php?passwordMismatch=true");
        exit;
    }

    // Controllo se l'utente è maggiorenne
    $dateOfBirth = new DateTime($_POST["data_nascita"]);
    $today = new DateTime();
    $diff = $today->diff($dateOfBirth);
    if ($diff->y < 18) {
        header("refresh:0; url=register.php?notAdult=true");
        exit;
    }

    // Controllo se il telefono ha 10 cifre
    if (strlen($_POST["telefono"]) !== 10) {
        header("refresh:0; url=register.php?invalidPhone=true");
        exit;
    }

    // Controllo se la mail è valida
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        header("refresh:0; url=register.php?invalidEmail=true");
        exit;
    }

    // Controllo se l'email esiste già nel database
    $sql = "SELECT email FROM utenti where email = :email";
    $stmt = $connessione->prepare($sql);
    $stmt->execute([
        ":email" => $_POST["email"]
    ]);
    $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($risultato) > 0) {
        header("refresh:0; url=register.php?alreadyRegistered=true");
    } else {
        $nome=$_POST["nome"];
        $cognome=$_POST["cognome"];
        $data_nascita=$_POST["data_nascita"];
        $telefono=$_POST["telefono"];
        $email = $_POST["email"];
        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $stmt = $connessione->prepare("INSERT INTO utenti VALUES (null, :nome, :cognome, :data_nascita, :telefono, :email, :pwd)");

        if($stmt->execute([
            ":nome" => $nome,
            ":cognome" => $cognome,
            ":data_nascita" => $data_nascita,
            ":telefono" => $telefono,
            ":email" => $email,
            ":pwd" => $passwordHash
        ]));
        header("Refresh:0;url=../login/login.php");
    }
}
else {
   header("refresh:0; url=register.php?erroreInScriptRegister");
}