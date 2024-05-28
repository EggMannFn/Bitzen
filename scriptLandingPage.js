document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#most-popular tbody');
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

    const formatPrice = (price) => {
        // Formatta il prezzo con la virgola ogni tre cifre delle unità e il simbolo della valuta
        return '$' + parseFloat(price).toLocaleString(undefined, {minimumFractionDigits: 2});
    };

    const updateTable = () => {
        Promise.all(popularCryptos.map(fetchCryptoData))
            .then(cryptosData => {
                cryptosData.forEach(asset => {
                    let row = document.querySelector(`tr[data-symbol="${asset.symbol}"]`);
                    
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

                        tableBody.appendChild(row);
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

                    // if (priceChangePercent > 0) {
                    //     priceChangeElement.style.color = rgba(0, 232, 182, 1); // Cambia il colore del testo in verde se priceChange è positivo
                    // } else if (priceChangePercent < 0) {
                    //     priceChangeElement.style.color = rgba(208, 89, 89, 1); // Cambia il colore del testo in rosso se priceChange è negativo
                    // }

                    const color = priceChangePercent >= 0 ? 'rgba(0, 232, 182, 1)' : 'rgba(208, 89, 89, 1)';
                    priceChangeElement.style.color = color;
                });
            })
            .catch(error => {
                console.error('Error fetching data from Binance API:', error);
            });
    };

    // Aggiorna la tabella immediatamente quando la pagina viene caricata
    updateTable();

    // Imposta un intervallo per aggiornare la tabella ogni 30 secondi
    setInterval(updateTable, 30000);
});
