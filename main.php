<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITZEN | Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>
<body>
    <?php
require_once("processing/config.php");
    session_start();
    if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
        header("Location: ./login/login.php");
        exit;
    }
?>
    <div class="dashboard">
<div class="sidebar">
    <h2>Dashboard</h2>
    <div class="link-group">
        <a href="main.php"><img src="side-icons/dashboard.png" alt="Dashboard"> Dashboard</a>
        <a href="wallet.php"><img src="side-icons/wallet.png" alt="Wallet"> Wallet</a>
        <a href="transactions.php"><img src="side-icons/transactions.png" alt="Transactions"> Transactions</a>
    </div>
    <div class="bottom-links">
        <a href="logout.php"><img src="side-icons/logout.png" alt="Logout"> Logout</a>
    </div>
</div>
        <div class="main">
            <h1>Cryptocurrency Dashboard</h1>
            <div class="first">
                <div class="cryptoCanva">
                    <div class="crypto-container">
                        <div class="crypto-box" id="BTC"></div>
                        <div class="crypto-box" id="ETH"></div>
                        <div class="crypto-box" id="BNB"></div>
                    </div>
                    <div class="canvaChoose">
                        <canvas id="btcChart" width="400" height="200"></canvas>
                    </div>
                </div>
        </div>

<div class="second">
    <div class="section">
        <h2>Top Gainers</h2>
        <table class="crypto-table" id="top-gainers">
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Buy</th>
                    <th>Price Change</th>
                    <th>Volume</th>
                    <th>Market Cap</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aggiunta contentenuti -->
            </tbody>
        </table>
    </div>
    <div class="section">
        <h2>Top Losers</h2>
        <table class="crypto-table" id="top-losers">
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Buy</th>
                    <th>Price Change</th>
                    <th>Volume</th>
                    <th>Market Cap</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aggiunta contentenuti -->
            </tbody>
        </table>
    </div>


    </div>
        <div class="section">
                <h2>Most Traded</h2>
                <table class="crypto-table" id="most-traded">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Buy</th>
                            <th>Price Change</th>
                            <th>Volume</th>
                            <th>Market Cap</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aggiunta contentenuti -->
                    </tbody>
                </table>
            </div>
            <div class="rightFirst">
    <div class="exchange-container">
        <div class="exchange-box">
            <div class="sectionTrans">
                <h2>Recent Transactions</h2>
                <?php
                $wallet = $_SESSION["wallet"]["id_wallet"];
                $sql = "SELECT * FROM transazione where id_wallet = $wallet ORDER BY timestamp DESC LIMIT 5";
                $stmt = $connessione->query($sql);
                $rows = $stmt->fetchAll();
                ?>
                <table class="transactions-table" id="recentTransactions">
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
                        if($row['tipologia'] == "buy"){
                            echo '<td style="color: rgb(0, 232, 182);">' . $row['tipologia'] . '</td>';
                        } else {
                            echo '<td style="color: rgb(208, 89, 89);">' . $row['tipologia'] . '</td>';
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
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>