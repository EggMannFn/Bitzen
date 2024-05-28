<?php
require_once("processing/config.php");


//CHECK DI QUANTO HAI DI BILANCIO
$sql = "SELECT denaroDemo FROM wallet WHERE id_wallet = 2";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die("Error: Wallet non trovato :(");
}
$currentBalance = $row['denaroDemo'];

$apiUrl = "https://api.binance.com/api/v3/ticker/price?symbol=BTCUSDT";

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
    $btcPrice = $data['price'];
    echo "Prezzo di bitcoin: $btcPrice USD";
}

$sql = "SELECT quantita, prezzoBuy FROM transazione WHERE id_wallet = 2 AND moneta = 'BTCUSDT'";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    die("Error: Transazione non trovata");
}
$quantityBought = $row['quantita'];
$buyPrice = $row['prezzoBuy'];

$gainLoss = ($btcPrice - $buyPrice) * $quantityBought;
echo "Guadagno/perdita di BTC: $gainLoss USD";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];

    $totalCost = $quantity * $btcPrice;

    // Check se è abbstanza
    if ($currentBalance < $totalCost) {
        die("Error: Non hai abbastanza soldi nel wallet per comprare $quantity BTC.");
    }

    // Sottrai il costo della transazione dal bilancio
    $newBalance = $currentBalance - $totalCost;

    // Aggiorna il bilancio
    $sql = "UPDATE wallet SET denaroDemo = $newBalance WHERE id_wallet = 2";
    if ($connessione->query($sql) != TRUE) {
        die("Error: " . $sql . "<br>" . $connessione->error);
    }

    // Inserisci la transazione
    $sql = "INSERT INTO transazione (id_transazione, id_wallet, moneta, quantita, prezzoBuy, timestamp) VALUES (null, 2, 'BTCUSDT', $quantity, $btcPrice, CURRENT_TIMESTAMP)";

    if ($connessione->query($sql) == TRUE) {
        header("Location: wallet.php");
        exit;
    }
    else{
        echo "Error: " . $sql . "<br>" . $connessione->error;
    }
}

echo "<h2>Acquista Bitcoin</h2>";
echo "<p>nel wallet hai: </p>";
echo "<p>$currentBalance USD</p>";
?>


<form method="post" action="">
    <label for="quantity">Quantità da comprare:</label><br>
    <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required><br>
    <input type="submit" value="Buy Bitcoin">
</form>