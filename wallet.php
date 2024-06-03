<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BITZEN | Wallet</title>
    <link rel="stylesheet" href="wallet.css">
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
    <div class="container">
        <!-- Immagine del grafico di mercato ottenuta dalla pagina precedente -->
        <img src="logo.png" alt="Market Chart" class="market-chart">

        <div class="form-container">
<?php
require_once("processing/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login/login.php");
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
    echo "Prezzo di {$selectedCoin}: " . round($coinPrice, 2) . " USD";

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

echo "<br>Il tuo storico di guadagno e perdita per {$selectedCoin} è: ".round($gainLoss,2) ."USD";

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
echo "<p>nel wallet hai: $currentBalance$ </p>";
echo "<p>Hai $currentCoin {$selectedCoin}</p>";

            // Form per comprare e vendere criptovalute
            ?>
            <form method="post" action="">
                <label for="coin">Seleziona la moneta:</label><br>
                <select name="coin" id="coin" onchange="this.form.submit()">
                    <?php foreach ($coins as $coin) : ?>
                        <option value="<?php echo $coin; ?>" <?php echo $coin == $selectedCoin ? 'selected' : ''; ?>><?php echo $coin; ?></option>
                    <?php endforeach; ?>
                </select><br>
                <label for="quantity">Quantità:</label><br>
                <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required class="selectBox"><br>
                <div class="inputs">
                    <input type="submit" name="buy" value="Compra">
                    <input type="submit" name="sell" value="Vendi" class="sell-button" id="sell">
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
