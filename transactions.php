<?php

require_once("processing/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login/login.php");
    exit;
}

$wallet = $_SESSION["wallet"]["id_wallet"];
$sql = "SELECT * FROM transazione where id_wallet = $wallet ORDER BY timestamp DESC";
$stmt = $connessione->query($sql);
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="transactions.css">
    <title>BITZEN | Trasactions </title>
</head>
<body>

    <div class="dashboard">
        
        <div class="sidebar">
            <h2>Dashboard</h2>
            <div class="link-group">
                <a href="main.php"><img src="side-icons/dashboard.png" alt="Dashboard"> Dashboard</a>
                <a href="wallet.php"><img src="side-icons/wallet.png" alt="Wallet"> Wallet</a>
                <!--<a href="#"><img src="side-icons/trading.png" alt="Trading"> Trading</a>-->
                <!--<a href="#"><img src="side-icons/security.png" alt="Security"> Security</a>-->
                <a href="transactions.php"><img src="side-icons/transactions.png" alt="Transactions"> Transactions</a>
            </div>
            <div class="bottom-links">
                <a href="#"><img src="side-icons/settings.png" alt="Settings"> Settings</a>
                <a href="logout.php"><img src="side-icons/logout.png" alt="Logout"> Logout</a>
            </div>
        </div>

    <div class="div-table">
        <h1>Transactions</h1>
        <div>
            <table class="transactions-table">
                <tr>
                    <th>Moneta</th>
                    <th>Quantità</th>
                    <th>Azione</th>
                    <th>Prezzo</th>
                    <th>Timestamp</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['moneta'] . '</td>';
                    echo '<td>' . $row['quantita'] . '</td>';
                    echo '<td>' . $row['tipologia'] . '</td>';
                    echo '<td>' . $row['prezzo'] . '</td>';
                    echo '<td>' . $row['timestamp'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
    </div>
</div>
</body>
</html>