<?php
require_once ("./processing/config.php");

if (isset($_POST["email"]) && isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["data_nascita"]) && isset($_POST["telefono"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $data_nascita = $_POST["data_nascita"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if email already exists
    $sql = "SELECT email FROM utenti WHERE email = :email";
    $stmt = $connessione->prepare($sql);
    $stmt->execute([":email" => $email]);
    $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($risultato) > 0) {
        header("Location: ./registratiTEO.php?alreadyRegistered=true");
        exit;
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: ./registratiTEO.php?passwordMismatch=true");
        exit;
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $connessione->prepare("INSERT INTO utenti (nome, cognome, data_nascita, telefono, email, password) VALUES (:nome, :cognome, :data_nascita, :telefono, :email, :password)");
    if ($stmt->execute([
        ":nome" => $nome,
        ":cognome" => $cognome,
        ":data_nascita" => $data_nascita,
        ":telefono" => $telefono,
        ":email" => $email,
        ":password" => $passwordHash
    ])) {
        header("Location: ./login.php");
        exit;
    } else {
        header("Location: ./registratiTEO.php?registrationFailed=true");
        exit;
    }
} else {
    header("Location: ./registratiTEO.php?missingFields=true");
    exit;
}
?>
