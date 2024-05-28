<?php
require_once("processing/config.php");

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
    echo "The current price of Bitcoin (BTC) is: $btcPrice USD";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];

    $totalCost = $quantity * $btcPrice;


    // Bilancio presente nel wallet
    $sql = "SELECT denaroDemo FROM wallet WHERE id_wallet = 2";
    $result = $connessione->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        die("Error: Wallet not found");
    }
    $currentBalance = $row['denaroDemo'];


    // Check se è abbstanza
    if ($currentBalance < $totalCost) {
        die("Error: Not enough money in wallet");
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
        echo "Transaction successful! You bought $quantity BTC for a total of $totalCost USD.";
    }
    else{
        echo "Error: " . $sql . "<br>" . $connessione->error;
    }
}
?>

<form method="post" action="">
    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required><br>
    <input type="submit" value="Buy Bitcoin">
</form>