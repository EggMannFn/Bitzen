<?php
    session_start();

    if(isset($_SESSION["Login"]) && $_SESSION["Login"] === true){
    }else{
        return header("refresh:0; url=login.php?UtenteNonLoggato=true");
    }
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
<h2>HOMEPAGE</h2>
<p>CIAO BELLO</p>
</body>
</html>