<?php

// session_start();
// if
// session_destroy();

// header("Location: login.php");

?>
<?php
session_start();

//Distruggo la sessione
if(isset($_POST["logout"])) {
    session_destroy();

    $cookie_expiry = time()-1;

    setcookie("email", $email, $cookie_expiry);
    setcookie("password", $password, $cookie_expiry);

    header("Refresh:0;url=./login/login.php");
    exit;
}
?>
