-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 04, 2024 alle 09:42
-- Versione del server: 10.4.25-MariaDB
-- Versione PHP: 7.4.30

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `transazione`
--

INSERT INTO `transazione` (`id_transazione`, `id_wallet`, `moneta`, `quantita`, `tipologia`, `prezzo`, `timestamp`) VALUES
(50, 4, 'BTCUSDT', '1.0000', 'buy', '67444.00', '2024-05-29 17:24:52'),
(51, 4, 'BTCUSDT', '1.0000', 'sell', '67436.01', '2024-05-29 17:25:25'),
(52, 4, 'BNBUSDT', '10.0000', 'buy', '596.60', '2024-05-29 17:36:41'),
(53, 4, 'BNBUSDT', '10.0000', 'sell', '596.20', '2024-05-29 17:38:02'),
(54, 4, 'BTCUSDT', '1.0000', 'buy', '67587.99', '2024-05-29 17:38:52'),
(55, 4, 'SOLUSDT', '1.0000', 'buy', '170.36', '2024-05-29 17:39:01'),
(56, 4, 'SOLUSDT', '0.0200', 'sell', '170.43', '2024-05-29 17:39:15'),
(57, 4, 'BTCUSDT', '0.0020', 'sell', '67600.79', '2024-05-29 17:39:24'),
(58, 4, 'BTCUSDT', '0.9980', 'sell', '67570.17', '2024-05-29 17:39:47'),
(59, 4, 'XRPUSDT', '1000.0000', 'buy', '0.53', '2024-05-29 17:42:57'),
(60, 5, 'BTCUSDT', '5.0000', 'buy', '67426.84', '2024-05-29 17:46:23'),
(61, 5, 'BTCUSDT', '5.0000', 'sell', '67409.55', '2024-05-29 17:46:55'),
(62, 4, 'XRPUSDT', '1000.0000', 'sell', '0.53', '2024-05-29 18:00:22'),
(63, 7, 'BTCUSDT', '2.0000', 'buy', '67596.00', '2024-05-30 09:07:02'),
(64, 7, 'BTCUSDT', '2.0000', 'sell', '67601.37', '2024-05-30 09:07:29'),
(65, 7, 'ETHUSDT', '200.0000', 'buy', '3731.75', '2024-05-30 09:09:08'),
(66, 7, 'ETHUSDT', '200.0000', 'sell', '3732.60', '2024-05-30 09:09:41'),
(67, 8, 'BTCUSDT', '2.0000', 'buy', '68791.99', '2024-06-04 06:06:41'),
(68, 8, 'BTCUSDT', '2.0000', 'sell', '68820.01', '2024-06-04 06:13:17'),
(69, 8, 'ETHUSDT', '0.0001', 'buy', '3767.22', '2024-06-04 07:35:34'),
(70, 8, 'BTCUSDT', '4.5000', 'buy', '68966.59', '2024-06-04 07:37:02'),
(71, 8, 'BTCUSDT', '4.0500', 'buy', '68987.98', '2024-06-04 07:37:11'),
(72, 8, 'BTCUSDT', '8.5500', 'sell', '68983.39', '2024-06-04 07:38:57');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(8, 'Andrea', 'TPS', '1999-01-11', '0000000000', 'gmail@gmail.com', '$2y$10$qEst6wn891TJ092OBU/6KeTXW/me9aASj1x3emB.em.yukreX9FFm'),
(9, 'Nela', 'Alex', '2005-01-15', '3131313131', 'nela@alex.com', '$2y$10$sXdjC/Jei5RpCcH3MVjhi.DoH6bjPuB4YgAWmYE2R6iNkFJiz3KWS'),
(10, 'Nela', 'Alex', '2111-11-11', '1111111111', 'nela@nela.com', '$2y$10$SS0dfJjFrc1OO/Fto8myDustL.3QV56dbyhhlTA9UzsDlkVi8JMoy');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `id_utente`, `denaroDemo`, `qBTC`, `qBNB`, `qETH`, `qSOL`, `qXRP`) VALUES
(1, 2, '26782.30', '1.0000', '1.0000', '1.0000', '1.0000', '2.0000'),
(2, 3, '32425.31', '0.0000', '1.0000', '0.0000', '0.0000', '0.0000'),
(3, 5, '99324.70', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(4, 6, '1135008.40', '0.0000', '0.0000', '0.0000', '0.9800', '0.0000'),
(5, 7, '999913.55', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(6, 8, '1000000.00', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(7, 9, '1000180.74', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000'),
(8, 10, '1000112.67', '0.0000', '0.0000', '0.0001', '0.0000', '0.0000');

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
  MODIFY `id_transazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
