<?php
require_once("processing/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login/login.php");
    exit;
}

$id_wallet = $_SESSION["wallet"]["id_wallet"];

//CHECK DI QUANTO HAI DI BILANCIO
$sql = "SELECT denaroDemo FROM wallet WHERE id_wallet = $id_wallet";
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

$sql = "SELECT quantita, prezzo FROM transazione WHERE id_wallet = $id_wallet AND moneta = 'BTCUSDT' AND tipologia = 'buy'";
$result = $connessione->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
    echo "<br> Transazioni non trovate, compra prima di sapere il guadagno/perdita.";
}
else {
    $quantityBought = $row['quantita'];
    $buyPrice = $row['prezzo'];
    if ($quantityBought > 0) {
        $gainLoss = ($btcPrice - $buyPrice) * $quantityBought;
        echo "Guadagno/perdita di BTC: $gainLoss USD";
    } else {
        echo "Non hai Bitcoin nel tuo wallet, quindi non c'è guadagno o perdita.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['buy'])) {
        $quantity = $_POST['quantity'];

        $totalCost = $quantity * $btcPrice;

        if ($currentBalance < $totalCost) {
            die("Non hai abbastanza soldi nel wallet per comprare $quantity BTC.");
        }
        $newBalance = $currentBalance - $totalCost;

        // Aggiorna il bilancio
        $sql = "UPDATE wallet SET denaroDemo = $newBalance WHERE id_wallet = $id_wallet";
        if ($connessione->query($sql) != TRUE) {
            die("Error: " . $sql . "<br>" . $connessione->error);
        }

        // Inserisci la transazione
        $sql = "INSERT INTO transazione (id_transazione, id_wallet, moneta, quantita, tipologia, prezzo, timestamp) VALUES (null, $id_wallet, 'BTCUSDT', $quantity, 'buy', $btcPrice, CURRENT_TIMESTAMP)";

        if ($connessione->query($sql) == TRUE) {
            header("Location: wallet.php");
            exit;
        }
        else{
            echo "Error: " . $sql . "<br>" . $connessione->error;
        }
    } elseif (isset($_POST['sell'])) {
        $quantity = $_POST['quantity'];

        // Verifica se l'utente ha abbastanza Bitcoin
        if ($quantityBought < $quantity) {
            die("Non hai abbastanza Bitcoin nel wallet per vendere $quantity BTC.");
        }

        $totalReturn = $quantity * $btcPrice;
        $newBalance = $currentBalance + $totalReturn;

        // Aggiorna il bilancio
        $sql = "UPDATE wallet SET denaroDemo = $newBalance WHERE id_wallet = $id_wallet";
        if ($connessione->query($sql) != TRUE) {
            die("Error: " . $sql . "<br>" . $connessione->error);
        }

        // Inserisci la transazione
        $sql = "INSERT INTO transazione (id_transazione, id_wallet, moneta, quantita, tipologia, prezzo, timestamp) VALUES (null, $id_wallet, 'BTCUSDT', $quantity, 'sell', $btcPrice, CURRENT_TIMESTAMP)";

        if ($connessione->query($sql) == TRUE) {
            header("Location: wallet.php");
            exit;
        }
        else{
            echo "Error: " . $sql . "<br>" . $connessione->error;
        }
    }
}

echo "<h2>Acquista o Vendi Bitcoin</h2>";
echo "<p>nel wallet hai: </p>";
echo "<p>$currentBalance USD</p>";
?>

<form method="post" action="">
    <label for="quantity">Quantità da comprare/vendere:</label><br>
    <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required><br>
    <input type="submit" name="buy" value="Compra">
    <input type="submit" name="sell" value="Vendi">
</form>