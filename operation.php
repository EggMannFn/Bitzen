<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trading Platform UI</title>
    <link rel="stylesheet" href="operation.css">
</head>
<body>
    <div class="container">
        <!-- Immagine del grafico di mercato ottenuta dalla pagina precedente -->
        <img src="<?php echo htmlspecialchars($_GET['imageUrl'] ?? 'default_chart.png'); ?>" alt="Market Chart" class="market-chart">

        <div class="form-container">
            <?php
            require_once("processing/config.php");
            session_start();
            // if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
            //     header("Location: login/login.php");
            //     exit;
            // }

            $id_wallet = $_SESSION["wallet"]["id_wallet"];
            $coins = ['BTC', 'BNB', 'ETH', 'SOL', 'XRP'];
            $coinQuantities = ['qBTC', 'qBNB', 'qETH', 'qSOL', 'qXRP'];

            $selectedCoin = isset($_POST['coin']) ? $_POST['coin'] : $coins[0];
            $selectedCoinQuantity = $coinQuantities[array_search($selectedCoin, $coins)];

            $sql = "SELECT denaroDemo, {$selectedCoinQuantity} FROM wallet WHERE id_wallet = ?";
            $stmt = $connessione->prepare($sql);
            $stmt->execute([$id_wallet]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
                die("Error: Wallet non trovato.");
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
            $coinPrice = $data['price'] ?? 0;

            echo "<p>Prezzo di {$selectedCoin}: {$coinPrice} USD</p>";
            echo "<p>nel wallet hai: $currentBalance USD</p>";
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
                <input type="number" id="quantity" name="quantity" min="0.0001" step="0.0001" required><br>
                <input type="submit" name="buy" value="Compra">
                <input type="submit" name="sell" value="Vendi">
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
