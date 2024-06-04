document.addEventListener('DOMContentLoaded', function () {
    const tableBodyMostPopular = document.querySelector('#most-popular tbody');
    const tableBodyNewListings = document.querySelector('#new-listing tbody');

    const popularCryptos = ['BTCUSDT', 'ETHUSDT', 'BNBUSDT', 'SOLUSDT', 'XRPUSDT'];

    // Mappa di corrispondenza tra simboli e nomi completi delle criptovalute
    const cryptoNames = {
        'BTC': 'Bitcoin',
        'ETH': 'Ethereum',
        'BNB': 'Binance Coin',
        'SOL': 'Solana',
        'XRP': 'Ripple'
    };

    const fetchCryptoData = (crypto) => {
        return fetch(`https://api.binance.com/api/v3/ticker/price?symbol=${crypto}`)
            .then(response => response.json());
    };

    const fetchNewListings = () => {
        return fetch('https://api.binance.com/api/v1/exchangeInfo')
            .then(response => response.json())
            .then(data => {
                // Ottieni le ultime 5 criptovalute listate
                const newCryptos = data.symbols.slice(-5).reverse(); // Prendi le ultime 5 e inverti l'ordine per visualizzarle dalla più recente alla meno recente
                return newCryptos;
            });
    };

    const formatPrice = (price) => {
        // Formatta il prezzo con la virgola ogni tre cifre delle unità e il simbolo della valuta
        return '$' + parseFloat(price).toLocaleString(undefined, {minimumFractionDigits: 2});
    };

    const updateTableMostPopular = () => {
        Promise.all(popularCryptos.map(fetchCryptoData))
            .then(cryptosData => {
                cryptosData.forEach(asset => {
                    let row = document.querySelector(`#most-popular tr[data-symbol="${asset.symbol}"]`);
                    
                    if (!row) {
                        // Crea una nuova riga se non esiste
                        row = document.createElement('tr');
                        row.setAttribute('data-symbol', asset.symbol);

                        const assetCell = document.createElement('td');
                        assetCell.classList.add('asset');
                        row.appendChild(assetCell);

                        const priceCell = document.createElement('td');
                        priceCell.classList.add('price');
                        row.appendChild(priceCell);

                        const priceChangeCell = document.createElement('td');
                        priceChangeCell.classList.add('price-change');
                        row.appendChild(priceChangeCell);

                        tableBodyMostPopular.appendChild(row);
                    }

                    // Ottieni il nome esteso della criptovaluta
                    const symbolWithoutUSDT = asset.symbol.replace('USDT', '');
                    const cryptoName = cryptoNames[symbolWithoutUSDT] || symbolWithoutUSDT;

                    // Visualizza il nome esteso della criptovaluta dopo il simbolo e prima del prezzo
                    row.querySelector('.asset').textContent = `${symbolWithoutUSDT} ${cryptoName}`;
                    row.querySelector('.price').textContent = formatPrice(asset.price);

                    // Aggiungi classe CSS condizionale per cambiare il colore del testo in base a priceChange
                    const priceChangePercent = parseFloat(asset.priceChangePercent);
                    const priceChangeElement = row.querySelector('.price-change');
                    priceChangeElement.textContent = `${priceChangePercent.toFixed(2)}%`;

                    const color = priceChangePercent >= 0 ? 'green' : 'red';
                    priceChangeElement.style.color = color;
                });
            })
            .catch(error => {
                console.error('Error fetching data from Binance API:', error);
            });
    };

    const updateTableNewListings = () => {
        fetchNewListings()
            .then(newCryptos => {
                newCryptos.forEach(crypto => {
                    const row = document.createElement('tr');

                    const nameCell = document.createElement('td');
                    nameCell.textContent = crypto.baseAsset;
                    row.appendChild(nameCell);

                    const symbolCell = document.createElement('td');
                    symbolCell.textContent = crypto.symbol;
                    row.appendChild(symbolCell);

                    const priceCell = document.createElement('td');
                    priceCell.textContent = formatPrice(crypto.price);
                    row.appendChild(priceCell);

                    const statusCell = document.createElement('td');
                    statusCell.textContent = crypto.status;
                    row.appendChild(statusCell);

                    const listingDateCell = document.createElement('td');
                    listingDateCell.textContent = new Date(crypto.listingDate).toLocaleDateString();
                    row.appendChild(listingDateCell);

                    tableBodyNewListings.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching new listings from Binance API:', error);
            });
    };

    // Aggiorna la tabella immediatamente quando la pagina viene caricata
    updateTableMostPopular();
    updateTableNewListings();

    // Imposta un intervallo per aggiornare la tabella delle criptovalute più popolari ogni 30 secondi
    setInterval(updateTableMostPopular, 30000);
});
