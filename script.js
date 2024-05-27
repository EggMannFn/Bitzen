const coingeckoApiUrl = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd';
const popularCryptos = ['BTCUSDT', 'ETHUSDT', 'BNBUSDT', 'SOLUSDT', 'XRPUSDT'];

async function fetchCryptoPrices() {
    try {
        const response = await fetch('https://api.binance.com/api/v3/ticker/24hr');
        const data = await response.json();
        return data.filter(crypto => popularCryptos.includes(crypto.symbol));
    } catch (error) {
        console.error('Error fetching crypto prices:', error);
        return [];
    }
}

async function fetchCryptoImages() {
    try {
        const response = await fetch(coingeckoApiUrl);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching crypto images:', error);
        return [];
    }
}

function updateCryptoBox(crypto, image, elementId) {
    const container = document.getElementById(elementId);

    if (!container) return;

    const symbol = crypto.symbol.replace('USDT', '').toUpperCase();
    const price = parseFloat(crypto.lastPrice).toFixed(2);

    if (image) {
        container.innerHTML = `
            <img src="${image.image}" alt="${symbol}">
            <div class="crypto-name">${symbol}</div>
            <div class="crypto-price">$ ${price}</div>
        `;
    } else {
        console.warn(`Image not found for ${symbol}`);
    }
}

async function updateAllCryptoBoxes() {
    try {
        const [binanceData, coingeckoData] = await Promise.all([fetchCryptoPrices(), fetchCryptoImages()]);

        binanceData.forEach(crypto => {
            const symbol = crypto.symbol.replace('USDT', '').toLowerCase();
            const image = coingeckoData.find(img => img.symbol.toLowerCase() === symbol);

            if (symbol === 'btc') {
                updateCryptoBox(crypto, image, 'BTC');
            } else if (symbol === 'eth') {
                updateCryptoBox(crypto, image, 'ETH');
            } else if (symbol === 'bnb') {
                updateCryptoBox(crypto, image, 'BNB');
            }
        });
    } catch (error) {
        console.error('Error updating crypto boxes:', error);
    }
}

function getTopGainersAndLosers(data) {
    const gainers = [...data].sort((a, b) => parseFloat(b.priceChangePercent) - parseFloat(a.priceChangePercent)).slice(0, 5);
    const losers = [...data].sort((a, b) => parseFloat(a.priceChangePercent) - parseFloat(b.priceChangePercent)).slice(0, 5);
    return { gainers, losers };
}

function getMostTraded(data) {
    return [...data].sort((a, b) => parseFloat(b.volume) - parseFloat(a.volume)).slice(0, 5);
}

function getMemeCoins(data) {
    const memeCoinSymbols = ['DOGEUSDT', 'SHIBUSDT']; // Example meme coins
    return data.filter(crypto => memeCoinSymbols.includes(crypto.symbol)).slice(0, 5);
}

function updateTable(data, images, tableId) {
    const tableBody = document.getElementById(tableId).querySelector('tbody');
    if (!tableBody) return;

    tableBody.innerHTML = '';

    data.forEach(crypto => {
        const row = document.createElement('tr');
        const symbolCell = document.createElement('td');
        const priceCell = document.createElement('td');
        const priceChangeCell = document.createElement('td');
        const volumeCell = document.createElement('td');
        const marketCapCell = document.createElement('td');
        const actionsCell = document.createElement('td');

        const symbol = crypto.symbol.replace('USDT', '');
        const image = images.find(img => img.symbol.toLowerCase() === symbol.toLowerCase());
        symbolCell.innerHTML = image ? `<img src="${image.image}" alt="${symbol}" width="20"> ${symbol}` : symbol;
        priceCell.textContent = parseFloat(crypto.lastPrice).toFixed(2);
        priceChangeCell.textContent = `${parseFloat(crypto.priceChangePercent).toFixed(2)}%`;
        volumeCell.textContent = parseFloat(crypto.volume).toLocaleString();
        marketCapCell.textContent = image ? image.market_cap.toLocaleString() : '-';
        actionsCell.innerHTML = '<button>Buy</button> <button>Sell</button>';

        row.appendChild(symbolCell);
        row.appendChild(priceCell);
        row.appendChild(priceChangeCell);
        row.appendChild(volumeCell);
        row.appendChild(marketCapCell);
        row.appendChild(actionsCell);

        tableBody.appendChild(row);
    });
}

async function updateAllTables() {
    try {
        const [binanceData, coingeckoData] = await Promise.all([fetchCryptoPrices(), fetchCryptoImages()]);
        const { gainers, losers } = getTopGainersAndLosers(binanceData);
        const mostTraded = getMostTraded(binanceData);
        const memeCoins = getMemeCoins(binanceData);
        const mostPopular = binanceData.filter(crypto => popularCryptos.includes(crypto.symbol));

        updateTable(gainers, coingeckoData, 'top-gainers');
        updateTable(losers, coingeckoData, 'top-losers');
        updateTable(mostTraded, coingeckoData, 'most-traded');
        updateTable(memeCoins, coingeckoData, 'meme-coins');
        updateTable(mostPopular, coingeckoData, 'most-popular');

        updateAllCryptoBoxes(); // Ensure crypto boxes are updated immediately
    } catch (error) {
        console.error('Error updating tables:', error);
    }
}

// Initial load and periodic updates
document.addEventListener('DOMContentLoaded', async () => {
    await updateAllTables();
    setInterval(updateAllTables, 30000 );
});
