<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ("../processing/config.php");

if(isset($_POST["email"])){ //?

    $sql = "SELECT email FROM utenti where email = :email"; //controllo se nome utente esistono già nel database
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
        header("Refresh:0; url=./login.php");
    }
}
else {
   header("refresh:0; url=register.php?erroreInScriptRegister");
}
