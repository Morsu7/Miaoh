-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 17, 2025 alle 19:15
-- Versione del server: 10.4.19-MariaDB
-- Versione PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miaoh_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text CHARACTER SET utf8mb4 NOT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `sconto` decimal(5,2) NOT NULL,
  `fine_sconto` date NOT NULL,
  `img1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `img2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tipoProdotto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`id`, `nome`, `descrizione`, `quantita`, `prezzo`, `sconto`, `fine_sconto`, `img1`, `img2`, `tipoProdotto_id`) VALUES
(1, 'Tiragraffi', 'Tiragraffi alto 1 metro per gatti di ogni età', 30, '49.99', '5.00', '2025-02-15', 'tiragraffi.jpg', NULL, 1),
(2, '\0Croccantini', 'Croccantini premium per gatti adulti', 100, '19.99', '2.00', '2025-03-01', 'croccantini.jpg', NULL, 2),
(3, 'Pallina con campanella', 'Gioco per gatti: pallina colorata con campanella', 200, '5.99', '1.00', '2025-01-31', 'pallina.jpg', NULL, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `utente` int(11) NOT NULL,
  `prodotto_id` int(11) NOT NULL,
  `valutazione` int(11) NOT NULL CHECK (`valutazione` between 1 and 5),
  `descrizione` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`utente`, `prodotto_id`, `valutazione`, `descrizione`) VALUES
(1, 1, 5, 'Il mio gatto lo adora, robusto e facile da montare!'),
(2, 2, 4, 'Croccantini di qualit?, ma un po? costosi rispetto alla media'),
(3, 3, 5, 'Gioco semplice ma il mio gatto si diverte tantissimo!');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipoprodotto`
--

CREATE TABLE `tipoprodotto` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `tipoprodotto`
--

INSERT INTO `tipoprodotto` (`id`, `descrizione`) VALUES
(1, 'Accessori per Gatti'),
(2, 'Cibo per Gatti'),
(3, 'Giochi per Gatti');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password_hash` blob NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `image_file_type` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `name`, `surname`, `image_file_type`) VALUES
(1, 'gattone33', 'a@iu.to', 0x24327924313024702f3178707859305158493331534557504f4b7679657043484e467238544c706a4344586e2e5a746142576143333959416d426579, 'Federico', 'Morsucci', 'jpg'),
(11, 'Ciao', 'a2@iu.to', 0x2432792431302476617956575a6d6f4a6a79392f726d6c627354504765774f6e55646867696e4b5351686237436731646d593239696862654e475179, '', '', 'png'),
(13, 'Tubone', 'paolofox@libero.it', 0x24327924313024743842666a4a304e374e63684a31515576766e782f4f314752504a447250325a443651467755696d70624e6f545544396769534865, 'Paolo', 'Fox', 'png');


--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipoProdotto_id` (`tipoProdotto_id`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`utente`,`prodotto_id`),
  ADD KEY `prodotto_id` (`prodotto_id`);

--
-- Indici per le tabelle `tipoprodotto`
--
ALTER TABLE `tipoprodotto`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tipoprodotto`
--
ALTER TABLE `tipoprodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`tipoProdotto_id`) REFERENCES `tipoprodotto` (`id`);

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`id`),
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
