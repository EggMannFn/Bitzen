-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 29, 2024 alle 20:18
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
  `quantita` decimal(18,8) NOT NULL,
  `tipologia` varchar(10) NOT NULL,
  `prezzo` decimal(18,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `transazione`
--

INSERT INTO `transazione` (`id_transazione`, `id_wallet`, `moneta`, `quantita`, `tipologia`, `prezzo`, `timestamp`) VALUES
(50, 4, 'BTCUSDT', 1.00000000, 'buy', 67444.00, '2024-05-29 17:24:52'),
(51, 4, 'BTCUSDT', 1.00000000, 'sell', 67436.01, '2024-05-29 17:25:25'),
(52, 4, 'BNBUSDT', 10.00000000, 'buy', 596.60, '2024-05-29 17:36:41'),
(53, 4, 'BNBUSDT', 10.00000000, 'sell', 596.20, '2024-05-29 17:38:02'),
(54, 4, 'BTCUSDT', 1.00000000, 'buy', 67587.99, '2024-05-29 17:38:52'),
(55, 4, 'SOLUSDT', 1.00000000, 'buy', 170.36, '2024-05-29 17:39:01'),
(56, 4, 'SOLUSDT', 0.02000000, 'sell', 170.43, '2024-05-29 17:39:15'),
(57, 4, 'BTCUSDT', 0.00200000, 'sell', 67600.79, '2024-05-29 17:39:24'),
(58, 4, 'BTCUSDT', 0.99800000, 'sell', 67570.17, '2024-05-29 17:39:47'),
(59, 4, 'XRPUSDT', 1000.00000000, 'buy', 0.53, '2024-05-29 17:42:57'),
(60, 5, 'BTCUSDT', 5.00000000, 'buy', 67426.84, '2024-05-29 17:46:23'),
(61, 5, 'BTCUSDT', 5.00000000, 'sell', 67409.55, '2024-05-29 17:46:55'),
(62, 4, 'XRPUSDT', 1000.00000000, 'sell', 0.53, '2024-05-29 18:00:22');

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
(2, '', 'd', '2001-11-11', '6271827371', '', '$2y$10$tzueG8YD.VphemcG2dQKteGUoDZVzGJ32IzcFCxpmfqEw958Gytbu'),
(3, 'test', 'test', '2001-11-11', '1234567890', 'test@2.com', '$2y$10$VLzJflzHu7XnXvoV34wckOv6jzEPDRlVyLF53mnYER2svgnBe3W9.'),
(4, 'Francesco', 'Bianchi', '2001-11-11', '3528998191', 'mail@mail.com', '$2y$10$NJ.C4yGS2UW2.R7VHw0aXOmzKja4mL4bM.CiiuK4pRPQXwknrSYHi'),
(5, 'Test', '2', '2002-11-11', '1234567890', 'm@m.com', '$2y$10$.byPwX.azpbMiQTsm3ECDONG4/SbhD/qUMmcRZtAv0CEC1Lt4z4F2'),
(6, 'test2', 'cognome', '2000-01-11', '9191929394', 'f@f.com', '$2y$10$Z0eVMspENgDE4/tAZTHTTeZoWTn4MLSd7j13XsUVqexRLDxQLaSV2'),
(7, 'Nome', 'Cognome', '2001-11-11', '1234567890', 'email@email.com', '$2y$10$hctGbYD8jB1bcEZfzVVMSOkASEPj.1Q27yiyfoPkDjH10PYnT1TSC'),
(8, 'Andrea', 'TPS', '1999-01-11', '0000000000', 'gmail@gmail.com', '$2y$10$qEst6wn891TJ092OBU/6KeTXW/me9aASj1x3emB.em.yukreX9FFm');

-- --------------------------------------------------------

--
-- Struttura della tabella `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `denaroDemo` decimal(18,2) DEFAULT 0.00,
  `qBTC` decimal(18,8) DEFAULT 0.00000000,
  `qBNB` decimal(18,8) DEFAULT 0.00000000,
  `qETH` decimal(18,8) DEFAULT 0.00000000,
  `qSOL` decimal(18,8) DEFAULT 0.00000000,
  `qXRP` decimal(18,8) DEFAULT 0.00000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `id_utente`, `denaroDemo`, `qBTC`, `qBNB`, `qETH`, `qSOL`, `qXRP`) VALUES
(1, 2, 26782.30, 1.00000000, 1.00000000, 1.00000000, 1.00000000, 2.00000000),
(2, 3, 32425.31, 0.00000000, 1.00000000, 0.00000000, 0.00000000, 0.00000000),
(3, 5, 99324.70, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000),
(4, 6, 1135008.40, 0.00000000, 0.00000000, 0.00000000, 0.98000000, 0.00000000),
(5, 7, 999913.55, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000),
(6, 8, 1000000.00, 0.00000000, 0.00000000, 0.00000000, 0.00000000, 0.00000000);

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
  MODIFY `id_transazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
