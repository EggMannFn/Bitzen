<?php

require_once("processing/config.php");

session_start();
if(!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: login/login.php");
    exit;
}

$wallet = $_SESSION["wallet"]["id_wallet"];
$sql = "SELECT * FROM transazione where id_wallet = $wallet ORDER BY timestamp DESC";
$stmt = $connessione->query($sql);
$rows = $stmt->fetchAll();

echo '<table>';
echo '<tr><th>Moneta</th><th>Quantità</th><th>Azione</th><th>Prezzo</th><th>Timestamp</th></tr>';
foreach ($rows as $row) {
    echo '<tr>';
    echo '<td>' . $row['moneta'] . '</td>';
    echo '<td>' . $row['quantita'] . '</td>';
    echo '<td>' . $row['tipologia'] . '</td>';
    echo '<td>' . $row['prezzo'] . '</td>';
    echo '<td>' . $row['timestamp'] . '</td>';
    echo '</tr>';
}
echo '</table>';
?>