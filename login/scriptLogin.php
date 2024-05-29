<?php
require_once ("../processing/config.php");

//controllo $_COOKIE
if(isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
    $email = $_COOKIE["email"];
    $password = $_COOKIE["password"];
}
//controllo $_POST
else if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
}

if(isset($email) && isset($password))
{
    $sql = "SELECT id_utente, email, password FROM utenti WHERE email = :email";
    $stmt = $connessione->prepare($sql);
    $stmt->execute([
        ":email"=> $email
    ]);
    $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($risultato) == 0){
        header("Refresh:0;url=login.php?utenteNonTrovato=true");
    }else{
        $id_utente = $risultato[0]["id_utente"];
        $password_db = $risultato[0]["password"];//[0] perché fetchall
        
        if(password_verify($password, $password_db)) {
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["email"] = $email;

            // Fetch wallet data
            $sql = "SELECT id_wallet, id_utente, denaroDemo, qBTC, qBNB, qETH, qSOL, qXRP FROM wallet WHERE id_utente = :id_utente";
            $stmt = $connessione->prepare($sql);
            $stmt->execute([
                ":id_utente"=> $id_utente
            ]);
            $wallet = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($wallet === false) {
                $sql = "INSERT INTO `wallet`(`id_wallet`, `id_utente`, `denaroDemo`, `qBTC`, `qBNB`, `qETH`, `qSOL`, `qXRP`) VALUES (null, :id_utente, '1000000', '0', '0', '0', '0', '0')";
                $stmt = $connessione->prepare($sql);
                $stmt->execute([
                    ":id_utente"=> $id_utente
                ]);

                $sql = "SELECT id_wallet, id_utente, denaroDemo, qBTC, qBNB, qETH, qSOL, qXRP FROM wallet WHERE id_utente = :id_utente";
                $stmt = $connessione->prepare($sql);
                $stmt->execute([
                    ":id_utente"=> $id_utente
                ]);
                $wallet = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($wallet === false) {
                    die("Error: Wallet non trovato dopo la creazione");
                }
            }

            $_SESSION["wallet"] = $wallet;

            if(isset($_POST["ricordami"])){
                setcookie("email", $email, time()+60*60*24*7*30, "/");
                setcookie("password", $password, time()+60*60*24*7*30, "/");
            }

            return header("Refresh:0;url=../main.php");

        }else{ 
            header("Refresh:0;url=login.php?passwordErrata=true");
        }
    }
}
else{
    header("Refresh:0;url=login.php?Errore=controllaScriptLogin");
}
?>