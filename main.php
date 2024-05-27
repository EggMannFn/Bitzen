
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cryptocurrency Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <a href="#">Dashboard</a>
            <a href="#">Wallet</a>
            <a href="#">Trading</a>
            <a href="#">Security</a>
            <a href="#">Transactions</a>
            <a href="#">Settings</a>
            <a href="#">Logout</a>
        </div>
        <div class="main">
            <h1>Cryptocurrency Dashboard</h1>
            <div class="crypto-container">
                <div class="crypto-box" id="BTC"></div>
                <div class="crypto-box" id="ETH"></div>
                <div class="crypto-box" id="BNB"></div>
            </div>
            
            <div class="section">
                <h2>Most Popular Cryptos</h2>
                <table class="crypto-table" id="most-popular">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Buy</th>
                            <th>Price Change</th>
                            <th>Volume</th>
                            <th>Market Cap</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Le righe saranno aggiunte dinamicamente qui -->
                    </tbody>
                </table>
            </div>
            
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here dynamically -->
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here dynamically -->
                    </tbody>
                </table>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here dynamically -->
                    </tbody>
                </table>
            </div>
            <div class="section">
                <h2>Meme Coins</h2>
                <table class="crypto-table" id="meme-coins">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Buy</th>
                            <th>Price Change</th>
                            <th>Volume</th>
                            <th>Market Cap</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
 