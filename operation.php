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
        <img src="chart.png" alt="Market Chart" class="market-chart">
        <div class="form-container">
            <form action="submit.php" method="post" class="order-form">
                <div class="buttons">
                    <button type="button" class="buy-button">Buy</button>
                    <button type="button" class="sell-button">Sell</button>
                </div>
                <div class="asset-info">
                    <p>Apple Computers Inc.</p>
                    <p>$93.00</p>
                </div>
                <div class="quantity-selector">
                    <label for="quantity">Select quantity</label>
                    <input type="number" id="quantity" name="quantity" value="100" min="1">
                </div>
                <div class="total-price">
                    Total price: $<span id="total-price">9300.00</span>
                </div>
                <button type="submit" class="buy-assets">Buy assets</button>
            </form>
        </div>
    </div>
</body>
</html>
