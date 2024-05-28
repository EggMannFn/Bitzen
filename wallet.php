<?php
    session_start();

    if(isset($_SESSION["Login"]) && $_SESSION["Login"] === true){
    }else{
        return header("refresh:0; url=login.php?UtenteNonLoggato=true");
    }

    $id_utente = 1;
?> 