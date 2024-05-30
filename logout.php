
<?php
session_start();

    session_destroy();

    $cookie_expiry = time()-1;

    setcookie("email", $email, $cookie_expiry);
    setcookie("password", $password, $cookie_expiry);

    header("Refresh:0;url=./login/login.php");
    exit;
?>
