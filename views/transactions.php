<?php
require_once("../config/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php");
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
    <link rel="stylesheet" href="../styles/transactions.css">
    <title>BITZEN | Transactions </title>
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>
<body>

<div class="dashboard">
    
    <div class="sidebar">
        <h2>Dashboard</h2>
        <div class="link-group">
            <a href="main.php"><img src="../assets/side-icons/dashboard.png" alt="Dashboard"> Dashboard</a>
            <a href="wallet.php"><img src="../assets/side-icons/wallet.png" alt="Wallet"> Wallet</a>
            <a href="transactions.php"><img src="../assets/side-icons/transactions.png" alt="Transactions"> Transactions</a>
        </div>
        <div class="bottom-links">
            <a href="logout.php"><img src="../assets/side-icons/logout.png" alt="Logout"> Logout</a>
        </div>
    </div>

    <div class="pagina-transactions">
    <h1>Transactions</h1>
    <div class="div-table">
        <div>
            <table class="transactions-table">
                <tr>
                    <th>Coin</th>
                    <th>Quantity</th>
                    <th>Action</th>
                    <th>Price</th>
                    <th>Timestamp</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['moneta'] . '</td>';
                    echo '<td>' . $row['quantita'] . '</td>';
                    if($row['tipologia'] == "buy"){
                        echo '<td style="color: #078f72;">' . $row['tipologia'] . '</td>';
                    } else {
                        echo '<td style="color: #ff4d4d;">' . $row['tipologia'] . '</td>';
                    }
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
