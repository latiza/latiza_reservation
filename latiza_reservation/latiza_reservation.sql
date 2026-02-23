-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Jan 28. 20:36
-- Kiszolgáló verziója: 10.4.27-MariaDB
-- PHP verzió: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `latiza_reservation`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `destination` varchar(100) NOT NULL,
  `notes` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `destination`, `notes`, `start_date`, `end_date`, `days`, `time_stamp`) VALUES
(1, 1, 'Velencei Karnevál', 'Velence non-stop', '2024-02-09', '2024-02-11', 3, '2024-01-28 17:45:23'),
(2, 2, 'Balti út', 'Riga, Tallinn, Helsinki', '2024-03-28', '2024-04-01', 5, '2024-01-28 17:26:11'),
(3, 1, 'Toszkána városai', 'Firenze', '2024-03-15', '2024-03-18', 4, '2024-01-28 17:29:38'),
(6, 2, 'Balti körút', 'https://1000ut.hu/europa/litvania/a-balti-tenger-kincsei/c-3560', '2024-05-20', '2024-05-25', 6, '2024-01-28 18:46:35'),
(7, 2, 'Balti körút', 'https://1000ut.hu/europa/litvania/a-balti-tenger-kincsei/c-3560', '2024-08-05', '2024-08-10', 6, '2024-01-28 19:01:50'),
(8, 2, 'Balti körút', 'https://1000ut.hu/europa/litvania/a-balti-tenger-kincsei/c-3560', '2024-09-09', '2024-09-14', 6, '2024-01-28 19:10:37'),
(9, 1, 'Prágai séták', 'https://groszutazas.hu/pragai-setak', '2024-03-23', '2024-01-24', 2, '2024-01-28 19:16:13'),
(10, 1, 'Barcelona', 'https://groszutazas.hu/barcelona', '2024-04-05', '2024-04-07', 3, '2024-01-28 19:28:44'),
(11, 1, 'Koperi nyaralás', 'https://groszutazas.hu/rovid-nyaralas-koperben-iii +Tamás ', '2024-07-07', '2024-07-11', 5, '2024-01-28 19:30:04'),
(12, 1, 'Bosznia', 'https://groszutazas.hu/nyaralas-bosznia-hercegovinaban', '2024-08-16', '2024-08-20', 5, '2024-01-28 19:31:23');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `travelusers` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;


INSERT INTO `travelusers` (`id`, `user_name`, `password`, `time_stamp`) VALUES
(1, 'GroszUtazas', 'Palma2025', '2024-01-28 19:12:58'),
(2, '1000ut', 'Jaroszlav2025', '2024-01-28 19:13:04'),
(3, 'Zita', 'Sirmi@ne022', '2025-01-20 19:12:58');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `travelusers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `travelusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `travelusers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
