<?php
// Chiave API di CryptoCompare
$apiKey = 'cb93be4a22cb6324dd1ff20de67e7302e17844fab9e3fef6441cd34d698d437c'; // Sostituisci con la tua chiave API

// URL dell'API di CryptoCompare
$url = 'https://min-api.cryptocompare.com/data/v2/histoday?fsym=BTC&tsym=USD&limit=30&api_key=' . $apiKey;

// Inizializza una sessione cURL
$ch = curl_init();

// Imposta le opzioni cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Esegui la richiesta e decodifica la risposta JSON
$response = curl_exec($ch);

// Controlla se ci sono errori nella richiesta cURL
if (curl_errno($ch)) {
    echo 'Errore cURL: ' . curl_error($ch);
    exit;
}

$data = json_decode($response, true);

// Chiudi la sessione cURL
curl_close($ch);

// Verifica se la risposta contiene dati
if (isset($data['Data']['Data'])) {
    // Prepara i dati per il grafico
    $prices = [];
    foreach ($data['Data']['Data'] as $day) {
        $prices[] = [
            'time' => date('Y-m-d', $day['time']),
            'price' => $day['close']
        ];
    }
    // Converti i dati in formato JSON
    $pricesJson = json_encode($prices);
} else {
    // Se la risposta non contiene dati, imposta un array vuoto e stampa un messaggio di errore
    $pricesJson = json_encode([]);
    echo 'Errore nella risposta dell\'API: ';
    var_dump($data);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitcoin Price Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>
    <canvas id="btcChart" width="400" height="200"></canvas>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Recupera i dati PHP in formato JSON
            const btcData = <?php echo $pricesJson; ?>;
            console.log('BTC Data:', btcData); // Debug: stampa i dati sulla console

            if (btcData.length === 0) {
                console.error('No data available');
                return;
            }

            const formattedData = btcData.map(point => ({
                x: new Date(point.time),
                y: point.price
            }));

            // Crea il grafico
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
        });
    </script>
</body>
</html>
