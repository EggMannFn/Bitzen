<?php
    require_once "config.php";

    if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];
    }
    else if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
    }

    if(isset($username) && isset($password))
    {
        $sql = "SELECT username, password FROM utenti WHERE username = :username";
        $stmt = $connessione->prepare($sql);
        $stmt->execute([
            ":username"=> $username
        ]);
        $risultato = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($risultato) == 0){
            header("Refresh:0; url=../login.php?utenteNonTrovato=true");
        }else{
            $password_db = $risultato[0]["password"];//[0] perché fetchall
            
            if(password_verify($password, $password_db)) {
                session_start();
                $_SESSION["Login"] = true;
                $_SESSION["username"] = $username;

                if(isset($_POST["ricordami"])){
                    setcookie("username", $username, time()+60*60*24*7*30, "/");
                    setcookie("password", $password, time()+60*60*24*7*30, "/");
                }

                return header("Refresh:0; url=../homepage.php");

            }else{ 
                header("Refresh:0; url =../login.php?passwordErrata=true");
            }
        }
    }
    else{
        header("Refresh:0; url=login.php?Errore=controllaScriptLogin");
    }
