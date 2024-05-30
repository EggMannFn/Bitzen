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
            <div class="crypto-info">
                <div class="crypto-name">${symbol}</div>
                <div class="crypto-price">$ ${price}</div>
            </div>
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

        const symbol = crypto.symbol.replace('USDT', '');
        const image = images.find(img => img.symbol.toLowerCase() === symbol.toLowerCase());
        symbolCell.innerHTML = image ? `<img src="${image.image}" alt="${symbol}" width="20"> ${symbol}` : symbol;
        priceCell.textContent = parseFloat(crypto.lastPrice).toFixed(2);
        priceChangeCell.textContent = `${parseFloat(crypto.priceChangePercent).toFixed(2)}%`;

        // Determine color based on price change
        const color = parseFloat(crypto.priceChangePercent) >= 0 ? 'rgba(0, 232, 182, 1)' : 'rgba(208, 89, 89, 1)';
        priceChangeCell.style.color = color;
        priceCell.style.color = color;

        volumeCell.textContent = parseFloat(crypto.volume).toLocaleString();
        marketCapCell.textContent = image ? image.market_cap.toLocaleString() : '-';

        row.appendChild(symbolCell);
        row.appendChild(priceCell);
        row.appendChild(priceChangeCell);
        row.appendChild(volumeCell);
        row.appendChild(marketCapCell);

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
    setInterval(updateAllTables, 30000);
});

document.addEventListener("DOMContentLoaded", function() {
    const apiKey = 'cb93be4a22cb6324dd1ff20de67e7302e17844fab9e3fef6441cd34d698d437c';
    const url = `https://min-api.cryptocompare.com/data/v2/histoday?fsym=BTC&tsym=USD&limit=30&api_key=${apiKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const btcData = data.Data.Data.map(day => ({
                time: new Date(day.time * 1000).toISOString().split('T')[0],
                price: day.close
            }));

            if (btcData.length === 0) {
                console.error('No data available');
                return;
            }

            const formattedData = btcData.map(point => ({
                x: new Date(point.time),
                y: point.price
            }));

            const ctx = document.getElementById('btcChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'BTC/USD',
                        data: formattedData,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Price (USD)'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

document.addEventListener('DOMContentLoaded', () => {
    const tables = document.querySelectorAll('.crypto-table');
    tables.forEach(table => {
        table.addEventListener('click', (event) => {
            let row = event.target.closest('tr');
            if (row && row.parentNode.nodeName === 'TBODY') {
                const imgElement = row.querySelector('img'); // Ottiene l'elemento <img>
                const asset = imgElement.alt.trim();
                const price = row.cells[1].textContent.trim();
                const imageUrl = imgElement.src.trim();

                // Reindirizza a operation.php con i parametri dell'URL
                window.location.href = `operation.php?asset=${encodeURIComponent(asset)}&price=${encodeURIComponent(price)}&imageUrl=${encodeURIComponent(imageUrl)}`;
            }
        });
    });
});

async function fetchChartData(currency) {
    const response = await fetch(`https://api.example.com/data/${currency}`);
    const data = await response.json();
    return data.map(point => ({
        x: new Date(point.timestamp),
        y: point.price
    }));
}

function updateChart(data, currencyLabel) {
    const ctx = document.getElementById('btcChart').getContext('2d');
    if (window.chart) {
        window.chart.data.datasets[0].data = data;
        window.chart.data.datasets[0].label = `${currencyLabel}/USD`;
        window.chart.update();
    } else {
        window.chart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: `${currencyLabel}/USD`,
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Price (USD)'
                        }
                    }
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const cryptoBoxes = document.querySelectorAll('.crypto-box');
    cryptoBoxes.forEach(box => {
        box.addEventListener('click', async () => {
            const currency = box.id; // L'ID del box è usato per identificare la valuta
            const data = await fetchChartData(currency);
            updateChart(data, currency.toUpperCase());
        });
    });
});
