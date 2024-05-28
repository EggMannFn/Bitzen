<?php
    $type = "mysql";
    $server = "localhost";
    $port=3306;
    $db="trading";
    $charset="utf8mb4";
    $username="root";
    $password="";
    
    $dsn="$type:host=$server;dbname=$db;port=$port;charset=$charset";
    try{
    $connessione = new PDO($dsn, $username, $password);
    }
    catch(PDOException $ex){
        print("Qualcosa è andato storto:");
        print($ex->getMessage());
    }
?>