-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 26, 2025 alle 18:26
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
(1, 27, '2025-01-21 15:47:16', 'da_spedire', '86.37'),
(1, 28, '2025-01-01 11:31:22', 'da_spedire', '0.00'),
(1, 29, '2025-01-21 17:18:48', 'da_spedire', '104.93'),
(1, 30, '2025-01-24 17:39:08', 'da_spedire', '14.99'),
(1, 31, '2025-01-24 17:39:50', 'da_spedire', '9.99'),
(1, 32, '2025-01-24 17:41:29', 'da_spedire', '56.99'),
(1, 33, '2025-01-24 17:44:55', 'da_spedire', '9.99'),
(1, 34, '2025-01-24 17:47:28', 'da_spedire', '9.99'),
(1, 35, '2025-01-24 17:48:03', 'da_spedire', '9.99'),
(1, 36, '2025-01-24 17:49:12', 'da_spedire', '9.99'),
(1, 37, '2025-01-24 17:49:21', 'da_spedire', '9.99'),
(1, 38, '2025-01-24 17:49:37', 'da_spedire', '9.99'),
(1, 39, '2025-01-24 17:49:50', 'da_spedire', '9.99'),
(1, 40, '2025-01-24 17:51:59', 'da_spedire', '9.99'),
(1, 41, '2025-01-24 17:52:10', 'da_spedire', '29.97'),
(1, 42, '2025-01-24 17:52:51', 'da_spedire', '9.99'),
(1, 43, '2025-01-24 17:54:25', 'da_spedire', '9.99'),
(1, 44, '2025-01-24 17:56:47', 'da_spedire', '9.99'),
(1, 45, '2025-01-24 17:58:34', 'da_spedire', '9.99'),
(1, 46, '2025-01-24 17:59:34', 'da_spedire', '9.99'),
(1, 47, '2025-01-24 18:00:50', 'da_spedire', '9.99'),
(1, 48, '2025-01-24 18:02:31', 'da_spedire', '9.99'),
(1, 49, '2025-01-24 18:04:26', 'da_spedire', '9.99'),
(1, 50, '2025-01-24 18:06:07', 'da_spedire', '9.99'),
(1, 51, '2025-01-24 18:07:59', 'da_spedire', '9.99'),
(1, 52, '2025-01-24 18:10:32', 'da_spedire', '9.99'),
(1, 53, '2025-01-24 18:12:44', 'da_spedire', '9.99'),
(1, 54, '2025-01-25 14:57:39', 'da_spedire', '19.59'),
(1, 55, '2025-01-25 15:32:07', 'da_spedire', '9.99'),
(1, 56, '2025-01-25 15:39:01', 'da_spedire', '9.99'),
(1, 57, '2025-01-25 15:52:47', 'da_spedire', '9.99'),
(1, 58, '2025-01-25 15:57:05', 'consegnato', '47.49'),
(1, 59, '2025-01-25 16:51:40', 'consegnato', '57.48'),
(1, 60, '2025-01-25 18:12:27', 'da_spedire', '47.56'),
(1, 61, '2025-01-25 18:36:21', 'da_spedire', '9.99'),
(21, 62, '2025-01-25 18:36:44', 'consegnato', '139.86');

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
(248, 19, 'visita', '2025-01-21 13:09:18'),
(249, 19, 'visita', '2025-01-21 13:10:04'),
(250, 3, 'visita', '2025-01-21 13:24:54'),
(251, 27, 'visita', '2025-01-21 13:52:38'),
(252, 25, 'visita', '2025-01-21 14:01:51'),
(253, 19, 'visita', '2025-01-21 14:01:56'),
(254, 8, 'visita', '2025-01-21 14:02:04'),
(255, 7, 'visita', '2025-01-21 14:04:34'),
(256, 19, 'visita', '2025-01-21 14:04:37'),
(257, 3, 'visita', '2025-01-21 14:05:00'),
(258, 3, 'carrello', '2025-01-21 14:05:03'),
(259, 27, 'visita', '2025-01-21 15:13:18'),
(260, 9, 'visita', '2025-01-21 15:14:19'),
(261, 28, 'visita', '2025-01-21 15:17:04'),
(262, 28, 'carrello', '2025-01-21 15:17:07'),
(263, 28, 'visita', '2025-01-21 15:18:12'),
(264, 28, 'carrello', '2025-01-21 15:18:16'),
(265, 28, 'visita', '2025-01-21 15:18:37'),
(266, 28, 'carrello', '2025-01-21 15:18:40'),
(267, 13, 'visita', '2025-01-21 15:18:53'),
(268, 13, 'carrello', '2025-01-21 15:18:54'),
(269, 28, 'visita', '2025-01-21 15:20:29'),
(270, 28, 'carrello', '2025-01-21 15:20:30'),
(271, 28, 'visita', '2025-01-21 15:20:39'),
(272, 28, 'carrello', '2025-01-21 15:20:57'),
(273, 28, 'visita', '2025-01-21 15:21:03'),
(274, 7, 'visita', '2025-01-21 15:47:09'),
(275, 7, 'carrello', '2025-01-21 15:47:11'),
(276, 1, 'visita', '2025-01-21 15:59:11'),
(277, 9, 'visita', '2025-01-21 17:17:35'),
(278, 4, 'visita', '2025-01-21 17:17:37'),
(279, 30, 'carrello', '2025-01-21 17:18:28'),
(280, 30, 'carrello', '2025-01-22 17:26:13'),
(281, 2, 'visita', '2025-01-24 16:42:50'),
(283, 32, 'visita', '2025-01-24 16:43:20'),
(284, 13, 'visita', '2025-01-24 17:12:16'),
(285, 28, 'visita', '2025-01-24 17:39:45'),
(286, 28, 'carrello', '2025-01-24 17:39:46'),
(287, 19, 'visita', '2025-01-24 17:41:21'),
(288, 19, 'carrello', '2025-01-24 17:41:24'),
(289, 28, 'visita', '2025-01-24 17:44:50'),
(290, 28, 'carrello', '2025-01-24 17:44:51'),
(291, 28, 'visita', '2025-01-24 17:47:23'),
(292, 28, 'carrello', '2025-01-24 17:47:24'),
(293, 28, 'visita', '2025-01-24 17:47:58'),
(294, 28, 'carrello', '2025-01-24 17:47:59'),
(295, 28, 'visita', '2025-01-24 17:49:07'),
(296, 28, 'carrello', '2025-01-24 17:49:08'),
(297, 28, 'visita', '2025-01-24 17:49:16'),
(298, 28, 'carrello', '2025-01-24 17:49:17'),
(299, 28, 'visita', '2025-01-24 17:49:32'),
(300, 28, 'carrello', '2025-01-24 17:49:33'),
(301, 28, 'visita', '2025-01-24 17:49:45'),
(302, 28, 'carrello', '2025-01-24 17:49:46'),
(303, 28, 'visita', '2025-01-24 17:51:53'),
(304, 28, 'carrello', '2025-01-24 17:51:55'),
(305, 28, 'visita', '2025-01-24 17:52:03'),
(306, 28, 'carrello', '2025-01-24 17:52:04'),
(307, 28, 'carrello', '2025-01-24 17:52:05'),
(308, 28, 'carrello', '2025-01-24 17:52:06'),
(309, 28, 'visita', '2025-01-24 17:52:46'),
(310, 28, 'carrello', '2025-01-24 17:52:47'),
(311, 28, 'visita', '2025-01-24 17:54:19'),
(312, 28, 'carrello', '2025-01-24 17:54:20'),
(313, 28, 'visita', '2025-01-24 17:56:42'),
(314, 28, 'carrello', '2025-01-24 17:56:43'),
(315, 28, 'visita', '2025-01-24 17:57:48'),
(316, 28, 'carrello', '2025-01-24 17:57:50'),
(317, 28, 'visita', '2025-01-24 17:59:21'),
(318, 28, 'carrello', '2025-01-24 17:59:22'),
(319, 28, 'visita', '2025-01-24 18:00:44'),
(320, 28, 'carrello', '2025-01-24 18:00:46'),
(321, 28, 'visita', '2025-01-24 18:02:25'),
(322, 28, 'carrello', '2025-01-24 18:02:27'),
(323, 28, 'visita', '2025-01-24 18:03:48'),
(324, 28, 'carrello', '2025-01-24 18:03:49'),
(325, 28, 'visita', '2025-01-24 18:06:01'),
(326, 28, 'carrello', '2025-01-24 18:06:03'),
(327, 28, 'visita', '2025-01-24 18:07:54'),
(328, 28, 'carrello', '2025-01-24 18:07:55'),
(329, 28, 'visita', '2025-01-24 18:10:27'),
(330, 28, 'carrello', '2025-01-24 18:10:28'),
(331, 28, 'visita', '2025-01-24 18:12:38'),
(332, 28, 'carrello', '2025-01-24 18:12:39'),
(333, 2, 'visita', '2025-01-25 14:57:33'),
(334, 2, 'carrello', '2025-01-25 14:57:35'),
(335, 28, 'visita', '2025-01-25 15:32:02'),
(336, 28, 'carrello', '2025-01-25 15:32:03'),
(337, 28, 'visita', '2025-01-25 15:38:56'),
(338, 28, 'carrello', '2025-01-25 15:38:57'),
(339, 28, 'visita', '2025-01-25 15:52:42'),
(340, 28, 'carrello', '2025-01-25 15:52:44'),
(341, 1, 'carrello', '2025-01-25 15:57:02'),
(342, 28, 'visita', '2025-01-25 16:48:57'),
(343, 28, 'carrello', '2025-01-25 16:48:59'),
(344, 28, 'carrello', '2025-01-25 16:49:02'),
(345, 28, 'visita', '2025-01-25 16:50:57'),
(346, 28, 'carrello', '2025-01-25 16:50:58'),
(347, 1, 'visita', '2025-01-25 16:51:05'),
(348, 1, 'carrello', '2025-01-25 16:51:07'),
(349, 28, 'visita', '2025-01-25 16:51:32'),
(351, 18, 'visita', '2025-01-25 16:56:29'),
(352, 13, 'visita', '2025-01-25 17:00:08'),
(353, 6, 'visita', '2025-01-25 17:00:20'),
(354, 2, 'visita', '2025-01-25 17:01:20'),
(355, 34, 'visita', '2025-01-25 17:01:35'),
(356, 16, 'visita', '2025-01-25 17:01:47'),
(357, 2, 'visita', '2025-01-25 17:02:07'),
(358, 11, 'visita', '2025-01-25 17:02:08'),
(359, 2, 'visita', '2025-01-25 17:02:20'),
(360, 28, 'visita', '2025-01-25 17:02:27'),
(361, 5, 'visita', '2025-01-25 17:02:35'),
(362, 2, 'visita', '2025-01-25 17:03:51'),
(363, 4, 'visita', '2025-01-25 17:04:58'),
(364, 19, 'visita', '2025-01-25 17:05:13'),
(365, 19, 'visita', '2025-01-25 17:05:55'),
(366, 28, 'visita', '2025-01-25 17:07:21'),
(367, 28, 'carrello', '2025-01-25 17:07:22'),
(368, 5, 'visita', '2025-01-25 17:07:24'),
(369, 5, 'carrello', '2025-01-25 17:07:25'),
(370, 2, 'visita', '2025-01-25 17:18:59'),
(371, 11, 'visita', '2025-01-25 17:22:51'),
(372, 5, 'visita', '2025-01-25 17:22:55'),
(373, 1, 'visita', '2025-01-25 17:25:41'),
(374, 8, 'visita', '2025-01-25 17:25:45'),
(375, 30, 'visita', '2025-01-25 17:27:41'),
(376, 30, 'visita', '2025-01-25 17:28:48'),
(377, 30, 'carrello', '2025-01-25 17:28:55'),
(378, 28, 'visita', '2025-01-25 17:29:39'),
(379, 28, 'visita', '2025-01-25 18:32:10'),
(380, 28, 'carrello', '2025-01-25 18:32:11'),
(381, 28, 'carrello', '2025-01-25 18:32:14'),
(382, 28, 'carrello', '2025-01-25 18:32:15'),
(383, 28, 'carrello', '2025-01-25 18:32:16'),
(384, 28, 'carrello', '2025-01-25 18:32:16'),
(385, 28, 'carrello', '2025-01-25 18:32:16'),
(386, 28, 'carrello', '2025-01-25 18:32:17'),
(387, 28, 'carrello', '2025-01-25 18:32:17'),
(388, 28, 'carrello', '2025-01-25 18:32:17'),
(389, 28, 'carrello', '2025-01-25 18:32:17'),
(390, 28, 'carrello', '2025-01-25 18:32:25'),
(391, 28, 'carrello', '2025-01-25 18:32:25'),
(392, 28, 'carrello', '2025-01-25 18:32:25'),
(393, 28, 'visita', '2025-01-25 18:32:28'),
(394, 28, 'carrello', '2025-01-25 18:32:30'),
(395, 28, 'visita', '2025-01-25 18:32:36'),
(396, 28, 'carrello', '2025-01-25 18:32:37'),
(397, 28, 'carrello', '2025-01-25 18:32:38'),
(398, 28, 'carrello', '2025-01-25 18:32:38'),
(399, 28, 'carrello', '2025-01-25 18:35:10'),
(400, 28, 'carrello', '2025-01-25 18:35:11'),
(401, 28, 'carrello', '2025-01-25 18:35:15'),
(402, 28, 'carrello', '2025-01-25 18:35:15'),
(403, 28, 'carrello', '2025-01-25 18:35:15'),
(404, 28, 'carrello', '2025-01-25 18:35:16'),
(405, 28, 'carrello', '2025-01-25 18:35:16'),
(406, 28, 'carrello', '2025-01-25 18:35:31'),
(407, 28, 'visita', '2025-01-25 18:36:08'),
(408, 28, 'carrello', '2025-01-25 18:36:09'),
(409, 28, 'visita', '2025-01-25 18:36:40'),
(410, 28, 'carrello', '2025-01-25 18:36:41'),
(411, 28, 'visita', '2025-01-25 18:45:10');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `id_notifica` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `oggetto` varchar(64) NOT NULL,
  `messaggio` varchar(1024) NOT NULL,
  `letta` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`id_notifica`, `id_utente`, `timestamp`, `oggetto`, `messaggio`, `letta`) VALUES
(13, 1, '2025-01-24 18:12:44', 'ORDINE 53 INVIATO', 'Il tuo ordine [ID: #53] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(14, 1, '2025-01-25 14:57:39', 'ORDINE 54 INVIATO', 'Il tuo ordine [ID: #54] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(15, 1, '2025-01-25 15:32:07', 'ORDINE 55 INVIATO', 'Il tuo ordine [ID: #55] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(16, 1, '2025-01-25 15:39:01', 'ORDINE 56 INVIATO', 'Il tuo ordine [ID: #56] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(18, 1, '2025-01-25 15:52:47', 'ORDINE 57 INVIATO', 'Il tuo ordine [ID: #57] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(19, 1, '2025-01-25 15:57:05', 'ORDINE 58 INVIATO', 'Il tuo ordine [ID: #58] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(20, 1, '2025-01-25 16:51:40', 'ORDINE 59 INVIATO', 'Il tuo ordine [ID: #59] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(21, 1, '2025-01-25 18:09:58', 'ORDINE 58 SPEDITO', 'Il tuo ordine [ID: #58] è stato spedito!\r\nTi invieremo una notifica appena sarà consegnato.\r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(22, 1, '2025-01-25 18:12:27', 'ORDINE 60 INVIATO', 'Il tuo ordine [ID: #60] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(23, 1, '2025-01-25 18:36:21', 'ORDINE 61 INVIATO', 'Il tuo ordine [ID: #61] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(24, 21, '2025-01-25 18:36:44', 'ORDINE 62 INVIATO', 'Il tuo ordine [ID: #62] è stato preso in carico con successo!\r\nTi invieremo una notifica appena sarà spedito. \r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(25, 21, '2025-01-25 18:39:32', 'ORDINE 62 SPEDITO', 'Il tuo ordine [ID: #62] è stato spedito!\r\nTi invieremo una notifica appena sarà consegnato.\r\n\r\nGrazie per aver scelto il nostro servizio!', 1),
(26, 21, '2025-01-25 18:40:11', 'ORDINE 62 CONSEGNATO', 'Il tuo ordine [ID: #62] è stato consegnato!\r\nGrazie per aver scelto il nostro servizio!', 1),
(27, 1, '2025-01-25 18:43:40', 'ORDINE 58 CONSEGNATO', 'Il tuo ordine [ID: #58] è stato consegnato!\r\nGrazie per aver scelto il nostro servizio!', 1);

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
(27, 7, 3, '86.37'),
(28, 15, 1, '1212.00'),
(28, 33, 1, '12.00'),
(29, 30, 7, '104.93'),
(30, 30, 1, '14.99'),
(31, 28, 1, '9.99'),
(32, 19, 1, '56.99'),
(33, 28, 1, '9.99'),
(34, 28, 1, '9.99'),
(35, 28, 1, '9.99'),
(36, 28, 1, '9.99'),
(37, 28, 1, '9.99'),
(38, 28, 1, '9.99'),
(39, 28, 1, '9.99'),
(40, 28, 1, '9.99'),
(41, 28, 3, '29.97'),
(42, 28, 1, '9.99'),
(43, 28, 1, '9.99'),
(44, 28, 1, '9.99'),
(45, 28, 1, '9.99'),
(46, 28, 1, '9.99'),
(47, 28, 1, '9.99'),
(48, 28, 1, '9.99'),
(49, 28, 1, '9.99'),
(50, 28, 1, '9.99'),
(51, 28, 1, '9.99'),
(52, 28, 1, '9.99'),
(53, 28, 1, '9.99'),
(54, 2, 1, '19.59'),
(55, 28, 1, '9.99'),
(56, 28, 1, '9.99'),
(57, 28, 1, '9.99'),
(58, 1, 1, '47.49'),
(59, 1, 1, '47.49'),
(59, 28, 1, '9.99'),
(60, 5, 1, '7.59'),
(60, 28, 1, '9.99'),
(60, 30, 2, '29.98'),
(61, 28, 1, '9.99'),
(62, 28, 14, '139.86');

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
(1, 'Tiragraffi', 'Tiragraffi alto 1 metro per gatti di ogni età', 27, '49.99', '5.00', '2025-02-15', 'jpg', NULL, 1),
(2, 'Croccantini', 'Croccantini premium per gatti adulti', 99, '19.99', '2.00', '2025-03-01', 'jpg', NULL, 2),
(3, 'Pallina con campanella', 'Gioco per gatti: pallina colorata con campanella', 199, '5.99', '1.00', '2025-01-31', 'jpg', NULL, 3),
(4, 'Collare per Gatto', 'Collare regolabile per gatti, disponibile in vari colori', 100, '15.99', '10.00', '2025-02-28', 'jpg', NULL, 1),
(5, 'Gioco a molla per Gatti', 'Gioco a molla con pallina per stimolare il gioco dei gatti', 199, '7.99', '5.00', '2025-03-15', 'jpg', NULL, 3),
(6, 'Cibo Secco per Gatti', 'Cibo secco completo per gatti adulti, con pollo e riso', 500, '25.99', '15.00', '2025-04-01', 'jpg', NULL, 2),
(7, 'Letto per Gatti', 'Letto morbido e confortevole per gatti', 147, '35.99', '20.00', '2025-02-20', 'jpg', NULL, 1),
(8, 'Tiragraffi per Gatti', 'Tiragraffi in sisal per gatti di tutte le età', 300, '19.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(9, 'Piatto per Gatti', 'Piatto in ceramica per cibo e acqua', 250, '10.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(10, 'Gioco Interattivo per Gatti', 'Gioco elettronico che stimola l\'interesse del gatto', 120, '45.99', '10.00', '2025-03-10', 'jpg', NULL, 3),
(11, 'Cibo Umido per Gatti', 'Cibo umido con tonno e salmone', 400, '22.99', '10.00', '2025-04-05', 'jpg', NULL, 2),
(12, 'Pettine per Gatti', 'Pettine per rimuovere i peli morti dal mantello del gatto', 100, '8.99', '5.00', '2025-02-25', 'jpg', NULL, 1),
(13, 'Fili per Gatti', 'Fili per il gioco dei gatti, facili da usare', 196, '4.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(14, 'Sacchetto di Letto per Gatti', 'Sacchetto riscaldante per letti di gatti', 80, '24.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(15, 'Albero per Gatti', 'Albero multi-livello per gatti, con giochi e letti', 50, '79.99', '15.00', '2025-03-30', 'jpg', NULL, 1),
(16, 'Rimedi per Gatti', 'Trattamenti naturali per la salute dei gatti', 60, '12.99', '5.00', '2025-05-01', 'jpeg', NULL, 2),
(17, 'Borsa per Gatti', 'Borsa da viaggio per trasportare il gatto in sicurezza', 120, '49.99', '20.00', '2025-06-10', 'jpg', NULL, 1),
(18, 'Spray Repellente per Gatti', 'Spray per evitare che i gatti si arrampichino su mobili', 80, '7.99', '10.00', '2025-03-05', 'jpg', NULL, 1),
(19, 'Ciotola Automatica per Gatti', 'Ciotola automatica che distribuisce cibo e acqua al gatto', 59, '59.99', '5.00', '2025-02-28', 'jpg', NULL, 1),
(20, 'Kit di Gioco per Gatti', 'Kit di giochi vari per stimolare il gatto', 150, '18.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(21, 'Pallina per Gatti', 'Pallina in gomma resistente per il gioco del gatto', 300, '5.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(22, 'Collare GPS per Gatti', 'Collare con GPS per monitorare i movimenti del gatto', 70, '89.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(23, 'Piatto Elettronico per Gatti', 'Piatto con bilancia elettronica per il cibo del gatto', 50, '55.99', '10.00', '2025-03-10', 'jpg', NULL, 1),
(24, 'Tappeto per Gatti', 'Tappeto antiscivolo per gatti', 100, '16.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(25, 'Letto Riscaldante per Gatti', 'Letto con funzione riscaldante per gatti', 30, '69.99', '10.00', '2025-03-15', 'jpg', NULL, 1),
(26, 'Zaino per Gatti', 'Zaino trasportino per gatti, comodo e sicuro', 120, '40.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
(27, 'Gioco a Tunnel per Gatti', 'Tunnel gioco per gatti, facile da usare e pieghevole', 150, '19.99', '5.00', '2025-04-01', 'jpg', NULL, 3),
(28, 'Gioco con Piume per Gatti', 'Gioco con piume per stimolare il gatto', 151, '9.99', '0.00', '0000-00-00', 'jpg', NULL, 3),
(29, 'Spray per Gatti per Addestramento', 'Spray per educare il gatto a non graffiare', 90, '10.99', '5.00', '2025-05-01', 'jpg', NULL, 1),
(30, 'Collare Antipulci per Gatti', 'Collare antipulci per proteggere il gatto', 140, '14.99', '0.00', '0000-00-00', 'jpg', NULL, 1),
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
(1, 19, 5, 'Incredibile caspita', '2025-01-21'),
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
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`id_notifica`),
  ADD KEY `notifica_utente` (`id_utente`);

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
  MODIFY `id_acquisto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT per la tabella `interazione`
--
ALTER TABLE `interazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `id_notifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `notifica_utente` FOREIGN KEY (`id_utente`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
