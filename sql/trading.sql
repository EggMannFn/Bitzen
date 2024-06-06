-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 06, 2024 alle 09:21
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trading`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `transazione`
--

CREATE TABLE `transazione` (
  `id_transazione` int(11) NOT NULL,
  `id_wallet` int(11) NOT NULL,
  `moneta` varchar(10) NOT NULL,
  `quantita` decimal(18,4) NOT NULL,
  `tipologia` varchar(10) NOT NULL,
  `prezzo` decimal(18,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `transazione`
--

INSERT INTO `transazione` (`id_transazione`, `id_wallet`, `moneta`, `quantita`, `tipologia`, `prezzo`, `timestamp`) VALUES
(1, 13, 'BTCUSDT', 1.0000, 'buy', 70955.99, '2024-06-06 07:19:45'),
(2, 13, 'BNBUSDT', 1.0000, 'buy', 699.80, '2024-06-06 07:19:56'),
(3, 13, 'ETHUSDT', 1.0000, 'buy', 3848.14, '2024-06-06 07:20:04'),
(4, 13, 'SOLUSDT', 1.0000, 'buy', 172.10, '2024-06-06 07:20:15'),
(5, 13, 'XRPUSDT', 1.0000, 'buy', 0.52, '2024-06-06 07:20:27');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(11) NOT NULL,
  `nome` varchar(25) NOT NULL,
  `cognome` varchar(25) NOT NULL,
  `data_nascita` date NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `data_nascita`, `telefono`, `email`, `password`) VALUES
(15, 'passwd', '12345678', '2001-11-11', '3528998191', 'email@email.com', '$2y$10$FQqHv2cVXaqVn0N8IHhUq.I7bClk448M1hAh0vZBXjKtAPiiNwmnq');

-- --------------------------------------------------------

--
-- Struttura della tabella `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `denaroDemo` decimal(18,2) DEFAULT 0.00,
  `qBTC` decimal(18,4) DEFAULT 0.0000,
  `qBNB` decimal(18,4) DEFAULT 0.0000,
  `qETH` decimal(18,4) DEFAULT 0.0000,
  `qSOL` decimal(18,4) DEFAULT 0.0000,
  `qXRP` decimal(18,4) DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `id_utente`, `denaroDemo`, `qBTC`, `qBNB`, `qETH`, `qSOL`, `qXRP`) VALUES
(13, 15, 924323.45, 1.0000, 1.0000, 1.0000, 1.0000, 1.0000);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `transazione`
--
ALTER TABLE `transazione`
  ADD PRIMARY KEY (`id_transazione`),
  ADD KEY `id_wallet` (`id_wallet`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`);

--
-- Indici per le tabelle `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_wallet`),
  ADD KEY `id_utente` (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `transazione`
--
ALTER TABLE `transazione`
  MODIFY `id_transazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `transazione`
--
ALTER TABLE `transazione`
  ADD CONSTRAINT `transazione_ibfk_1` FOREIGN KEY (`id_wallet`) REFERENCES `wallet` (`id_wallet`);

--
-- Limiti per la tabella `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
