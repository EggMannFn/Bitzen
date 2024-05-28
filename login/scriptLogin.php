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
        $sql = "SELECT email, password FROM utenti WHERE email = :email";
        $stmt = $connessione->prepare($sql);
        $stmt->execute([
            ":email"=> $email
        ]);
        $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($risultato) == 0){
            header("Refresh:0;url=login.php?utenteNonTrovato=true");
        }else{
            $password_db = $risultato[0]["password"];//[0] perché fetchall
            
            if(password_verify($password, $password_db)) {
                session_start();
                $_SESSION["Login"] = true;
                $_SESSION["email"] = $email;

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
