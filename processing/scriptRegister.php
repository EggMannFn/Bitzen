<?php
require_once "config.php";

if(isset($_POST["username"]) && isset($_POST["email"])){ //?

    $sql = "SELECT username, email FROM utenti where username = :username AND email = :email"; //controllo se email/nome utente esistono già nel database
    $stmt = $connessione->prepare($sql);
    $stmt->execute([
        ":username" => $_POST["username"],
        ":email" => $_POST["email"]
    ]);
    $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($risultato) > 0) {
        header("refresh:0; url=../register.php?alreadyRegistered=true");
    } else {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $data_di_nascita = $_POST["data_di_nascita"];

        $stmt = $connessione->prepare("INSERT INTO utenti VALUES (null, :email, :username, :pwd, :data_di_nascita, null);");
        if ($stmt->execute([
            "email" => $email,
            "username" => $username,
            "pwd" => $passwordHash,
            "data_di_nascita" => $data_di_nascita
        ]));
        header("Refresh:0; url=../login.php");
    }
}
else {
   header("refresh:0; url=register.php?erroreInScriptRegister");
}
