const coingeckoApiUrl = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd';

async function fetchCryptoPrices() {
    try {
        const response = await fetch('https://api.binance.com/api/v3/ticker/24hr');
        const data = await response.json();
        return data;
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
        symbolCell.innerHTML = image ? `<img src="${image.image}" alt="${symbol}"> ${symbol}` : symbol;
        priceCell.textContent = parseFloat(crypto.lastPrice).toFixed(2);
        priceChangeCell.textContent = parseFloat(crypto.priceChange).toFixed(2);
        volumeCell.textContent = parseFloat(crypto.volume).toFixed(2);
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

async function updateCryptoPrices() {
    const [binanceData, coingeckoData] = await Promise.all([fetchCryptoPrices(), fetchCryptoImages()]);
    const { gainers, losers } = getTopGainersAndLosers(binanceData);
    const mostTraded = getMostTraded(binanceData);
    const memeCoins = getMemeCoins(binanceData);

    updateTable(gainers, coingeckoData, 'top-gainers');
    updateTable(losers, coingeckoData, 'top-losers');
    updateTable(mostTraded, coingeckoData, 'most-traded');
    updateTable(memeCoins, coingeckoData, 'meme-coins');
}

function getMostPopular(data) {
    // Assumendo che la popolarità possa essere misurata dal volume di mercato
    return [...data].sort((a, b) => b.market_cap - a.market_cap).slice(0, 5);
}

const mostPopular = getMostPopular(binanceData);
updateTable(mostPopular, coingeckoData, 'most-popular');

// Initial load
updateCryptoPrices();
// Refresh every 5 minutes
setInterval(updateCryptoPrices, 300000);
