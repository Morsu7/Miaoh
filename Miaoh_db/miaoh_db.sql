-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 26, 2025 alle 18:17
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
-- Struttura della tabella `acquisti`
--

CREATE TABLE `acquisti` (
  `id_utente` int(11) NOT NULL,
  `id_acquisto` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `stato_acquisto` enum('da_spedire','spedito','consegnato') NOT NULL DEFAULT 'da_spedire',
  `spesa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `acquisti`
--

INSERT INTO `acquisti` (`id_utente`, `id_acquisto`, `timestamp`, `stato_acquisto`, `spesa`) VALUES
(1, 19, '2025-01-20 22:36:39', 'da_spedire', '14.39'),
(1, 20, '2025-01-21 11:46:44', 'da_spedire', '393.85');

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `id_utente` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `carrello`
--
DELIMITER $$
CREATE TRIGGER `after_update_quantita` AFTER UPDATE ON `carrello` FOR EACH ROW BEGIN
    IF NEW.quantita <= 0 THEN
        DELETE FROM carrello
        WHERE id_utente = NEW.id_utente AND id_prodotto = NEW.id_prodotto;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `interazione`
--

CREATE TABLE `interazione` (
  `id` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `tipo` enum('visita','acquisto','carrello') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `interazione`
--

INSERT INTO `interazione` (`id`, `id_prodotto`, `tipo`, `timestamp`) VALUES
(74, 18, 'carrello', '2025-01-18 18:15:11'),
(75, 20, 'carrello', '2025-01-18 19:15:30'),
(76, 10, 'carrello', '2025-01-18 19:21:38'),
(77, 20, 'carrello', '2025-01-18 19:21:44'),
(78, 8, 'carrello', '2025-01-19 11:25:07'),
(79, 19, 'carrello', '2025-01-19 12:09:32'),
(80, 1, 'carrello', '2025-01-19 15:19:02'),
(81, 1, 'carrello', '2025-01-19 15:19:04'),
(82, 1, 'carrello', '2025-01-19 15:19:06'),
(83, 4, 'carrello', '2025-01-19 15:20:37'),
(84, 4, 'carrello', '2025-01-19 15:20:38'),
(85, 4, 'carrello', '2025-01-19 15:20:40'),
(86, 4, 'carrello', '2025-01-19 15:20:42'),
(87, 17, 'carrello', '2025-01-19 15:21:10'),
(88, 4, 'carrello', '2025-01-19 17:02:09'),
(89, 29, 'carrello', '2025-01-19 20:51:31'),
(90, 24, 'carrello', '2025-01-19 21:02:51'),
(91, 15, 'carrello', '2025-01-19 21:02:54'),
(92, 34, 'carrello', '2025-01-19 21:03:07'),
(93, 1, 'carrello', '2025-01-19 21:03:15'),
(94, 25, 'carrello', '2025-01-19 21:05:51'),
(95, 32, 'carrello', '2025-01-19 21:05:53'),
(96, 13, 'carrello', '2025-01-19 21:05:57'),
(97, 34, 'carrello', '2025-01-19 21:06:01'),
(98, 8, 'carrello', '2025-01-19 21:06:06'),
(99, 19, 'carrello', '2025-01-19 21:06:11'),
(100, 30, 'carrello', '2025-01-19 21:39:15'),
(101, 13, '', '2025-01-20 15:17:24'),
(102, 30, '', '2025-01-20 15:18:36'),
(103, 27, 'carrello', '2025-01-20 16:18:12'),
(104, 24, 'carrello', '2025-01-20 16:18:14'),
(105, 1, 'carrello', '2025-01-20 16:18:15'),
(106, 1, '', '2025-01-20 16:31:45'),
(107, 8, '', '2025-01-20 16:35:18'),
(108, 16, '', '2025-01-20 16:35:29'),
(110, 32, '', '2025-01-20 16:35:51'),
(111, 35, '', '2025-01-20 16:36:07'),
(112, 29, '', '2025-01-20 16:36:14'),
(113, 7, '', '2025-01-20 16:36:17'),
(115, 13, '', '2025-01-20 16:38:43'),
(116, 22, 'carrello', '2025-01-20 17:26:56'),
(117, 11, 'carrello', '2025-01-20 17:26:57'),
(118, 14, 'carrello', '2025-01-20 17:26:58'),
(119, 2, 'carrello', '2025-01-20 17:31:05'),
(120, 27, 'carrello', '2025-01-20 17:33:52'),
(121, 27, 'carrello', '2025-01-20 17:34:04'),
(122, 27, 'carrello', '2025-01-20 17:34:05'),
(123, 27, 'carrello', '2025-01-20 17:34:05'),
(124, 27, 'carrello', '2025-01-20 17:34:05'),
(125, 27, 'carrello', '2025-01-20 17:34:05'),
(126, 27, 'carrello', '2025-01-20 17:34:05'),
(127, 27, 'carrello', '2025-01-20 17:34:05'),
(128, 27, 'carrello', '2025-01-20 17:34:05'),
(129, 27, 'carrello', '2025-01-20 17:34:06'),
(130, 19, 'carrello', '2025-01-20 17:34:21'),
(131, 19, 'carrello', '2025-01-20 17:34:22'),
(132, 12, 'carrello', '2025-01-20 17:34:23'),
(133, 15, 'carrello', '2025-01-20 17:34:29'),
(134, 31, 'carrello', '2025-01-20 17:35:45'),
(135, 11, 'carrello', '2025-01-20 17:35:51'),
(136, 32, 'carrello', '2025-01-20 17:39:22'),
(137, 22, 'carrello', '2025-01-20 17:39:49'),
(138, 1, 'carrello', '2025-01-20 17:39:58'),
(139, 17, 'carrello', '2025-01-20 17:45:54'),
(140, 11, 'carrello', '2025-01-20 17:46:06'),
(141, 9, 'carrello', '2025-01-20 17:46:33'),
(142, 12, 'carrello', '2025-01-20 17:53:46'),
(143, 29, 'carrello', '2025-01-20 17:55:44'),
(144, 29, 'carrello', '2025-01-20 17:55:46'),
(145, 29, 'carrello', '2025-01-20 17:55:47'),
(146, 29, 'carrello', '2025-01-20 17:55:48'),
(147, 29, 'carrello', '2025-01-20 17:55:48'),
(148, 32, 'carrello', '2025-01-20 17:55:50'),
(149, 32, 'carrello', '2025-01-20 17:55:54'),
(150, 31, 'carrello', '2025-01-20 17:57:24'),
(151, 18, 'carrello', '2025-01-20 17:57:55'),
(152, 15, 'carrello', '2025-01-20 17:58:02'),
(153, 7, 'carrello', '2025-01-20 17:58:17'),
(154, 17, 'carrello', '2025-01-20 17:58:18'),
(155, 10, 'carrello', '2025-01-20 17:58:41'),
(156, 8, 'carrello', '2025-01-20 17:59:09'),
(157, 25, 'carrello', '2025-01-20 17:59:18'),
(158, 3, 'carrello', '2025-01-20 17:59:22'),
(159, 3, 'carrello', '2025-01-20 17:59:24'),
(160, 10, 'carrello', '2025-01-20 17:59:39'),
(161, 15, 'carrello', '2025-01-20 18:00:04'),
(162, 21, 'carrello', '2025-01-20 18:00:49'),
(163, 22, 'carrello', '2025-01-20 18:00:53'),
(164, 12, 'carrello', '2025-01-20 18:00:55'),
(165, 13, 'carrello', '2025-01-20 18:00:59'),
(166, 18, 'carrello', '2025-01-20 18:01:02'),
(167, 12, 'carrello', '2025-01-20 18:01:04'),
(168, 17, 'carrello', '2025-01-20 18:01:06'),
(169, 31, 'carrello', '2025-01-20 18:01:25'),
(170, 9, 'carrello', '2025-01-20 18:01:29'),
(171, 31, 'carrello', '2025-01-20 18:01:31'),
(172, 15, 'carrello', '2025-01-20 18:02:02'),
(173, 27, '', '2025-01-20 18:03:07'),
(174, 27, '', '2025-01-20 18:03:15'),
(175, 3, 'carrello', '2025-01-20 18:03:18'),
(176, 5, 'carrello', '2025-01-20 18:03:22'),
(177, 10, 'carrello', '2025-01-20 18:04:22'),
(178, 5, 'carrello', '2025-01-20 18:04:28'),
(179, 10, 'carrello', '2025-01-20 18:05:34'),
(180, 17, 'carrello', '2025-01-20 18:05:42'),
(181, 3, '', '2025-01-20 18:08:17'),
(182, 10, '', '2025-01-20 18:09:21'),
(183, 10, '', '2025-01-20 18:09:24'),
(184, 1, '', '2025-01-20 18:34:38'),
(185, 6, '', '2025-01-20 18:36:19'),
(186, 28, '', '2025-01-20 18:37:16'),
(187, 27, '', '2025-01-20 18:37:35'),
(188, 35, '', '2025-01-20 18:37:43'),
(189, 20, '', '2025-01-20 18:38:59'),
(190, 4, 'carrello', '2025-01-20 18:39:16'),
(191, 18, 'carrello', '2025-01-20 19:28:28'),
(192, 4, 'carrello', '2025-01-20 19:28:38'),
(193, 16, 'carrello', '2025-01-20 21:49:23'),
(194, 29, 'carrello', '2025-01-20 22:25:43'),
(195, 19, 'carrello', '2025-01-20 22:34:54'),
(196, 4, 'carrello', '2025-01-20 22:36:34'),
(197, 17, '', '2025-01-21 11:46:15'),
(198, 17, 'carrello', '2025-01-21 11:46:16'),
(199, 17, 'carrello', '2025-01-21 11:46:24'),
(200, 9, 'carrello', '2025-01-21 11:46:27'),
(201, 2, 'carrello', '2025-01-21 11:46:30');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_acquistati`
--

CREATE TABLE `prodotti_acquistati` (
  `id_acquisto` int(11) NOT NULL,
  `id_prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo_totale` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prodotti_acquistati`
--

INSERT INTO `prodotti_acquistati` (`id_acquisto`, `id_prodotto`, `quantita`, `prezzo_totale`) VALUES
(19, 4, 1, '14.39'),
(20, 2, 6, '117.54'),
(20, 4, 1, '14.39'),
(20, 9, 2, '21.98'),
(20, 17, 6, '239.94');

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
(1, 'Tiragraffi', 'Tiragraffi alto 1 metro per gatti di ogni età', 30, '49.99', '5.00', '2025-02-15', 'jpg', NULL, 1),
(2, '\0Croccantini', 'Croccantini premium per gatti adulti', 100, '19.99', '2.00', '2025-03-01', 'jpg', NULL, 2),
(3, 'Pallina con campanella', 'Gioco per gatti: pallina colorata con campanella', 200, '5.99', '1.00', '2025-01-31', 'jpg', NULL, 3),
(4, 'Collare per Gatto', 'Collare regolabile per gatti, disponibile in vari colori', 100, '15.99', '10.00', '2025-02-28', 'jpg', NULL, 1),
(5, 'Gioco a molla per Gatti', 'Gioco a molla con pallina per stimolare il gioco dei gatti', 200, '7.99', '5.00', '2025-03-15', 'jpg', NULL, 3),
(6, 'Cibo Secco per Gatti', 'Cibo secco completo per gatti adulti, con pollo e riso', 500, '25.99', '15.00', '2025-04-01', 'jpg', NULL, 2),
(7, 'Letto per Gatti', 'Letto morbido e confortevole per gatti', 150, '35.99', '20.00', '2025-02-20', 'jpg', NULL, 1),
(8, 'Tiragraffi per Gatti', 'Tiragraffi in sisal per gatti di tutte le età', 300, '19.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(9, 'Piatto per Gatti', 'Piatto in ceramica per cibo e acqua', 250, '10.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(10, 'Gioco Interattivo per Gatti', 'Gioco elettronico che stimola l\'interesse del gatto', 120, '45.99', '10.00', '2025-03-10', 'jpg', NULL, 3),
(11, 'Cibo Umido per Gatti', 'Cibo umido con tonno e salmone', 400, '22.99', '10.00', '2025-04-05', 'jpg', NULL, 2),
(12, 'Pettine per Gatti', 'Pettine per rimuovere i peli morti dal mantello del gatto', 100, '8.99', '5.00', '2025-02-25', 'jpg', NULL, 1),
(13, 'Fili per Gatti', 'Fili per il gioco dei gatti, facili da usare', 200, '4.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(14, 'Sacchetto di Letto per Gatti', 'Sacchetto riscaldante per letti di gatti', 80, '24.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(15, 'Albero per Gatti', 'Albero multi-livello per gatti, con giochi e letti', 50, '79.99', '15.00', '2025-03-30', 'jpg', NULL, 1),
(16, 'Rimedi per Gatti', 'Trattamenti naturali per la salute dei gatti', 60, '12.99', '5.00', '2025-05-01', 'jpeg', NULL, 2),
(17, 'Borsa per Gatti', 'Borsa da viaggio per trasportare il gatto in sicurezza', 120, '49.99', '20.00', '2025-06-10', 'jpg', NULL, 1),
(18, 'Spray Repellente per Gatti', 'Spray per evitare che i gatti si arrampichino su mobili', 80, '7.99', '10.00', '2025-03-05', 'jpg', NULL, 1),
(19, 'Ciotola Automatica per Gatti', 'Ciotola automatica che distribuisce cibo e acqua al gatto', 60, '59.99', '5.00', '2025-02-28', 'jpg', NULL, 1),
(20, 'Kit di Gioco per Gatti', 'Kit di giochi vari per stimolare il gatto', 150, '18.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(21, 'Pallina per Gatti', 'Pallina in gomma resistente per il gioco del gatto', 300, '5.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(22, 'Collare GPS per Gatti', 'Collare con GPS per monitorare i movimenti del gatto', 70, '89.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(23, 'Piatto Elettronico per Gatti', 'Piatto con bilancia elettronica per il cibo del gatto', 50, '55.99', '10.00', '2025-03-10', 'jpg', NULL, 1),
(24, 'Tappeto per Gatti', 'Tappeto antiscivolo per gatti', 100, '16.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(25, 'Letto Riscaldante per Gatti', 'Letto con funzione riscaldante per gatti', 30, '69.99', '10.00', '2025-03-15', 'jpg', NULL, 1),
(26, 'Zaino per Gatti', 'Zaino trasportino per gatti, comodo e sicuro', 120, '40.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(27, 'Gioco a Tunnel per Gatti', 'Tunnel gioco per gatti, facile da usare e pieghevole', 150, '19.99', '5.00', '2025-04-01', 'jpg', NULL, 3),
(28, 'Gioco con Piume per Gatti', 'Gioco con piume per stimolare il gatto', 200, '9.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(29, 'Spray per Gatti per Addestramento', 'Spray per educare il gatto a non graffiare', 90, '10.99', '5.00', '2025-05-01', 'jpg', NULL, 1),
(30, 'Collare Antipulci per Gatti', 'Collare antipulci per proteggere il gatto', 150, '14.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(31, 'Sabbia per Lettiera per Gatti', 'Sabbia agglomerante per lettiera per gatti', 200, '12.99', '10.00', '2025-04-05', 'jpg', NULL, 2),
(32, 'Cucina per Gatti', 'Piccola cucina completa per gatti, con alimenti freschi', 50, '99.99', '0.00', '0000-00-00', 'jpg', NULL, 2),
(33, 'Integratore per Gatti', 'Integratori alimentari per migliorare la salute del gatto', 70, '20.99', '5.00', '2025-05-10', 'jpg', NULL, 2),
(34, 'Filo da Corda per Gatti', 'Filo resistente per giochi da masticare per gatti', 250, '3.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(35, 'Panno Pulizia per Gatti', 'Panno per la pulizia e cura del pelo del gatto', 150, '6.99', '5.00', '2025-04-10', 'jpeg', NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `utente` int(11) NOT NULL,
  `prodotto_id` int(11) NOT NULL,
  `valutazione` int(11) NOT NULL CHECK (`valutazione` between 1 and 5),
  `descrizione` text CHARACTER SET utf8 NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`utente`, `prodotto_id`, `valutazione`, `descrizione`, `data`) VALUES
(1, 1, 5, 'PAZZESCOOOOOOOOOOOOOOOOOOOOOOOOOOOOO', '2025-01-20'),
(1, 2, 4, 'Croccantini di qualità, ma un po\' costosi rispetto alla media', '2025-01-20'),
(1, 3, 5, 'Gioco semplice ma il mio gatto si diverte tantissimo!', '2025-01-20'),
(1, 10, 3, 'dsdsd', '2025-01-20'),
(1, 30, 3, 'dasdsads', '2025-01-20'),
(13, 10, 1, 'non male', '2025-01-20'),
(21, 10, 4, 'beatiful', '2025-01-20'),
(21, 34, 3, 'bella bella bella', '2025-01-20');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `name`, `surname`, `image_file_type`) VALUES
(1, 'gattone33', 'a@iu.to', 0x24327924313024702f3178707859305158493331534557504f4b7679657043484e467238544c706a4344586e2e5a746142576143333959416d426579, 'Federico', 'Morsucci', 'jpg'),
(13, 'Tubone', 'paolofox@libero.it', 0x24327924313024743842666a4a304e374e63684a31515576766e782f4f314752504a447250325a443651467755696d70624e6f545544396769534865, 'Paolo', 'Fox', 'png'),
(21, 'JJMorbix', 'admin@miaoh.com', 0x243279243130247456652f6a65614d757a71596c53655a31314c796b756649484e6e6a534a524e54786862764b362f544554757766513442356a7647, 'Cristian', 'Morbidelli', 'png');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquisti`
--
ALTER TABLE `acquisti`
  ADD PRIMARY KEY (`id_acquisto`),
  ADD KEY `utente_acquisti` (`id_utente`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`id_utente`,`id_prodotto`),
  ADD KEY `carrello_prodotto` (`id_prodotto`);

--
-- Indici per le tabelle `interazione`
--
ALTER TABLE `interazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto_interazione` (`id_prodotto`);

--
-- Indici per le tabelle `prodotti_acquistati`
--
ALTER TABLE `prodotti_acquistati`
  ADD PRIMARY KEY (`id_acquisto`,`id_prodotto`),
  ADD KEY `prodotti` (`id_prodotto`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto_tipo` (`tipoProdotto_id`);
ALTER TABLE `prodotto` ADD FULLTEXT KEY `nome` (`nome`);
ALTER TABLE `prodotto` ADD FULLTEXT KEY `descrizione` (`descrizione`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`utente`,`prodotto_id`),
  ADD KEY `recensione_prodotto` (`prodotto_id`);

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
-- AUTO_INCREMENT per la tabella `acquisti`
--
ALTER TABLE `acquisti`
  MODIFY `id_acquisto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `interazione`
--
ALTER TABLE `interazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `acquisti`
--
ALTER TABLE `acquisti`
  ADD CONSTRAINT `utente_acquisti` FOREIGN KEY (`id_utente`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_prodotto` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrello_utente` FOREIGN KEY (`id_utente`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `interazione`
--
ALTER TABLE `interazione`
  ADD CONSTRAINT `prodotto_interazione` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotti_acquistati`
--
ALTER TABLE `prodotti_acquistati`
  ADD CONSTRAINT `prodotti` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotto` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `prodotti_acquistati` FOREIGN KEY (`id_acquisto`) REFERENCES `acquisti` (`id_acquisto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_tipo` FOREIGN KEY (`tipoProdotto_id`) REFERENCES `tipoprodotto` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_prodotto` FOREIGN KEY (`prodotto_id`) REFERENCES `prodotto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recensione_utente` FOREIGN KEY (`utente`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
