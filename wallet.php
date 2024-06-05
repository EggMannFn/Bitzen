<?php
require_once("processing/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php");
    exit;
}

$id_wallet = $_SESSION["wallet"]["id_wallet"];

$coins = ['BTC', 'BNB', 'ETH', 'SOL', 'XRP'];
$coinQuantities = ['qBTC', 'qBNB', 'qETH', 'qSOL', 'qXRP'];

$selectedCoin = isset($_POST['coin']) ? $_POST['coin'] : $coins[0];
$selectedCoinQuantity = $coinQuantities[array_search($selectedCoin, $coins)];

//CHECK DI QUANTO HAI DI BILANCIO
$sql = "SELECT denaroDemo, {$selectedCoinQuantity} FROM wallet WHERE id_wallet = $id_wallet";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die("Error: Wallet non trovato :(");
}
$currentBalance = $row['denaroDemo'];
$currentCoin = $row[$selectedCoinQuantity];

$apiUrl = "https://api.binance.com/api/v3/ticker/price?symbol={$selectedCoin}USDT";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die("cURL Error: $error");
}    
curl_close($ch);
$data = json_decode($response, true);
$price = $data['price'];
if (isset($price)) {
    $coinPrice = $data['price'];
    // echo "Prezzo di {$selectedCoin}: " .      . " USD";

}
// Calcola il costo totale di acquisto di Coin
$sql = "SELECT SUM(quantita * prezzo) AS totalCost FROM transazione WHERE id_wallet = $id_wallet AND tipologia = 'buy' AND moneta = '{$selectedCoin}USDT'";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die("Error: Non riesco a calcolare il costo totale di acquisto di {$selectedCoin}.");
}
$totalPurchaseCost = $row['totalCost'];

// Calcola il totale delle vendite di Coin
$sql = "SELECT SUM(quantita * prezzo) AS totalSales FROM transazione WHERE id_wallet = $id_wallet AND tipologia = 'sell' AND moneta = '{$selectedCoin}USDT'";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die("Error: Non riesco a calcolare il totale delle vendite di {$selectedCoin}.");
}
$totalSales = $row['totalSales'];

// Calcola il valore attuale del Coin nel wallet
$currentValue = $currentCoin * $coinPrice;

// Calcola il guadagno o la perdita
$gainLoss = $currentValue - ($totalPurchaseCost - $totalSales);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buy'])) {
        $quantity = $_POST['quantity'];

        $totalCost = $quantity * $coinPrice;

        if ($currentBalance < $totalCost) {
            die("Non hai abbastanza soldi nel wallet per comprare $quantity {$selectedCoin}.");
        }
        $newBalance = $currentBalance - $totalCost;
        $newCoin = $currentCoin + $quantity;

        // Aggiorna il bilancio e la quantità di Coin
        $sql = "UPDATE wallet SET denaroDemo = $newBalance, {$selectedCoinQuantity} = $newCoin WHERE id_wallet = $id_wallet";
        if ($connessione->query($sql) != TRUE) {
            die("Error: " . $sql . "<br>" . $connessione->error);
        }

        // Inserisci la transazione
        $sql = "INSERT INTO transazione (id_transazione, id_wallet, moneta, quantita, tipologia, prezzo, timestamp) VALUES (null, $id_wallet, '{$selectedCoin}USDT', $quantity, 'buy', $coinPrice, CURRENT_TIMESTAMP)";

        if ($connessione->query($sql) == TRUE) {
            header("Location: wallet.php");
            exit;
        } 
        else{
            echo "Error: " . $sql . "<br>" . $connessione->error;
        }
    } else if (isset($_POST['sell'])) {
        $quantity = $_POST['quantity'];

        if ($currentCoin < $quantity) {
            die("Non hai abbastanza {$selectedCoin} nel wallet per vendere $quantity {$selectedCoin}.");
        }

        $totalRevenue = $quantity * $coinPrice;
        $newBalance = $currentBalance + $totalRevenue;
        $newCoin = $currentCoin - $quantity;

        // Aggiorna il bilancio e la quantità di Coin
        $sql = "UPDATE wallet SET denaroDemo = $newBalance, {$selectedCoinQuantity} = $newCoin WHERE id_wallet = $id_wallet";
        if ($connessione->query($sql) != TRUE) {
            die("Error: " . $sql . "<br>" . $connessione->error);
        }

        // Inserisci la transazione
        $sql = "INSERT INTO transazione (id_transazione, id_wallet, moneta, quantita, tipologia, prezzo, timestamp) VALUES (null, $id_wallet, '{$selectedCoin}USDT', $quantity, 'sell', $coinPrice, CURRENT_TIMESTAMP)";

        if ($connessione->query($sql) == TRUE) {
            header("Location: wallet.php");
            exit;
        }
        else{
            echo "Error: " . $sql . "<br>" . $connessione->error;
        }
    }
}
echo "";
// echo "<p>Hai $currentCoin {$selectedCoin}</p>";

            
            

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITZEN | Dashboard</title>
    <link rel="stylesheet" href="wallet.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>
<body>
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
        <h1>Benvenuto nel tuo wallet, <?php echo $_SESSION["nome"] ; ?> <?php echo $_SESSION["cognome"] ; ?>!</h1>

<div class="second">
    <div class="section-balance">
        <?php echo " <h1>$ " . number_format($currentBalance, 2, '.', ' ') . " </h1>"; ?>
        <canvas id="myChartBalance"></canvas>
    </div>
    <div class="section-img">
    <?php
        $coinsImg = array(
            'BTC' => 'bitcoin',
            'BNB' => 'binancecoin',
            'ETH' => 'ethereum',
            'SOL' => 'solana',
            'XRP' => 'ripple'
            // Add more coins as needed
        );
        $coin_id = $coinsImg[$selectedCoin];
        $coin_data = file_get_contents('https://api.coingecko.com/api/v3/coins/' . $coin_id);
        $coin_data = json_decode($coin_data, true);
        $image_url = $coin_data['image']['large'];
        echo '<img class="coin-image" src="' . $image_url . '" alt="' . $coin_id . '">';
    ?>
    </div>
    <div class="section-buysell">
        <form method="post" action="">
            <select name="coin" id="coinSelect" onchange="this.form.submit()">
                <?php foreach ($coins as $coin) : ?>
                    <option value="<?php echo $coin; ?>" <?php echo $coin == $selectedCoin ? 'selected' : ''; ?>><?php echo $coin; ?></option>
                <?php endforeach; ?>
            </select><br>
            <label for="quantity">Quantità:</label><br>
            <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required class="selectBox"><br>
            <div class="inputs">
                <input type="submit" name="buy" id="buyButton" class="buy-button" value="Compra">
                <input type="submit" name="sell" class="sell-button" id="sellButton" value="Vendi">
            </div>
        </form>
    </div>
    


    </div>
        <div class="section">
                <table class="trade-table" id="most-traded">
                <?php

echo "
<thead>
    <tr>
        <th>Moneta</th>
        <th>Quantità</th>
        <th>Prezzo</th>
        <th>Storico di guadagno e perdita</th> <!-- New column -->
    </tr>
</thead>
<tbody>";

foreach ($coins as $coin) {
    $coinQuantity = $coinQuantities[array_search($coin, $coins)];

    $sql = "SELECT {$coinQuantity} FROM wallet WHERE id_wallet = $id_wallet";
    $result = $connessione->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        die("Error: Wallet non trovato :(");
    }
    $currentCoinQuantity = $row[$coinQuantity];

    $apiUrl = "https://api.binance.com/api/v3/ticker/price?symbol={$coin}USDT";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        die("cURL Error: $error");
    }    
    curl_close($ch);
    $data = json_decode($response, true);
    $coinPrice = $data['price'];

    $sql = "SELECT SUM(quantita * prezzo) AS totalCost FROM transazione WHERE id_wallet = $id_wallet AND tipologia = 'buy' AND moneta = '{$coin}USDT'";
    $result = $connessione->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        die("Error: Non riesco a calcolare il costo totale di acquisto di {$coin}.");
    }
    $totalPurchaseCost = $row['totalCost'];

    $sql = "SELECT SUM(quantita * prezzo) AS totalSales FROM transazione WHERE id_wallet = $id_wallet AND tipologia = 'sell' AND moneta = '{$coin}USDT'";
    $result = $connessione->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        die("Error: Non riesco a calcolare il totale delle vendite di {$coin}.");
    }
    $totalSales = $row['totalSales'];

    $currentValue = $currentCoinQuantity * $coinPrice;

    $gainLoss = $currentValue - ($totalPurchaseCost - $totalSales);

    echo "<tr>";
    echo "<td>{$coin}</td>";
    echo "<td>{$currentCoinQuantity}</td>";
    echo "<td>".round($coinPrice, 2)." $</td>"; 
    echo "<td>".round($gainLoss,2) ." USD</td>"; 
    echo "</tr>";
}
echo "</tbody>";
?>
                </table>
            </div>
    </div>
    
    <script src="wallet.js"></script>
</body>
</html>