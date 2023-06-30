-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2023 at 12:58 PM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1315684_cypride`
--

-- --------------------------------------------------------

--
-- Table structure for table `carinformation`
--

CREATE TABLE `carinformation` (
  `user_id` int(11) NOT NULL,
  `plate` varchar(20) NOT NULL,
  `brand` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `year` int(4) NOT NULL,
  `carpicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `carinformation`
--

INSERT INTO `carinformation` (`user_id`, `plate`, `brand`, `model`, `year`, `carpicture`) VALUES
(12, 'UU555', 'Chevrolet', 'Camaro', 2019, 'car_pictures/2019-chevrolet-camaross-004.jpg'),
(11, 'AA007', 'Audi', 'TT', 2012, 'car_pictures/audi.jpg'),
(30, 'afdsaf', 'sadf', 'asdf', 2019, 'car_pictures/pexels-mike-bird-1335077.jpg'),
(31, 'adfdsf', 'sadf', 'dsa', 2324, 'car_pictures/pexels-mike-bird-1335077.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `carsharetrips`
--

CREATE TABLE `carsharetrips` (
  `trip_id` int(4) NOT NULL,
  `user_id` int(4) DEFAULT NULL,
  `departure` char(30) DEFAULT NULL,
  `departureLongitude` float NOT NULL,
  `departureLatitude` float NOT NULL,
  `destination` char(30) DEFAULT NULL,
  `destinationLongitude` float NOT NULL,
  `destinationLatitude` float NOT NULL,
  `price` char(10) DEFAULT NULL,
  `seatsavailable` int(4) DEFAULT NULL,
  `date` char(20) DEFAULT NULL,
  `time` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `carsharetrips`
--

INSERT INTO `carsharetrips` (`trip_id`, `user_id`, `departure`, `departureLongitude`, `departureLatitude`, `destination`, `destinationLongitude`, `destinationLatitude`, `price`, `seatsavailable`, `date`, `time`) VALUES
(4, 12, 'Famagusta', 33.9192, 35.1149, 'Nicosia, Cyprus', 33.3823, 35.1856, '15', 9, 'Fri 21 Jun, 2023', '16:00'),
(6, 12, 'Girne', 33.2363, 35.2992, 'Nicosia, Cyprus', 33.3823, 35.1856, '14', 0, 'Fri 30 Jun, 2023', '20:20'),
(8, 11, 'Famagusta', 33.9192, 35.1149, 'Nicosia, Cyprus', 33.3823, 35.1856, '35', 2, 'Wed 28 Jun, 2023', '10:30'),
(9, 11, 'Famagusta', 33.9192, 35.1149, 'Nicosia, Cyprus', 33.3823, 35.1856, '35', 3, 'Fri 30 Jun, 2023', '20:00'),
(10, 11, 'Iskele', 33.8969, 35.2972, 'Famagusta', 33.9192, 35.1149, '50', 4, 'Tue 27 Jun, 2023', '08:30'),
(11, 11, 'Famagusta', 33.9192, 35.1149, 'Karpasia', 34.25, 35.5, '50', 3, 'Mon 26 Jun, 2023', '09:30'),
(12, 31, 'Ä°skele, KÄ±brÄ±s', 33.8969, 35.2972, 'Girne', 33.2363, 35.2992, '23', 2, 'Fri 30 Jun, 2023', '20:20'),
(13, 12, 'Famagusta, KÄ±brÄ±s', 33.9192, 35.1149, 'Nicosia, KÄ±brÄ±s', 33.3823, 35.1856, '14', 2, 'Fri 30 Jun, 2023', '20:20');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `trip_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `trip_id`) VALUES
(4, 4),
(6, 6),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `message_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`message_id`, `chat_id`, `user_id`, `message`, `timestamp`) VALUES
(1, 4, 12, 'hfghgf', '2023-06-21 13:20:54'),
(12, 4, 12, 'Selam', '2023-06-22 12:19:45'),
(13, 4, 12, 'Selam', '2023-06-22 12:19:49'),
(14, 4, 12, '5', '2023-06-22 12:39:17'),
(15, 4, 12, '5', '2023-06-22 12:39:18'),
(16, 4, 11, 'hkj', '2023-06-22 14:16:31'),
(44, 6, 12, 'Trip id 6', '2023-06-22 16:10:35'),
(45, 4, 11, 'hello', '2023-06-23 04:11:05'),
(46, 4, 11, 'My current location is: Latitude 35.1180632, Longitude 33.929311', '2023-06-23 04:57:42'),
(47, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1180632,33.929311\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 04:58:42'),
(48, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1180632,33.929311\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 05:34:55'),
(49, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1180628,33.9293121\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 05:41:32'),
(50, 4, 11, 'why', '2023-06-23 05:46:41'),
(51, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1180523,33.9293095\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 05:46:57'),
(52, 4, 11, 'hi', '2023-06-23 06:23:23'),
(53, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1410343,33.9115153\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 08:12:36'),
(54, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1410283,33.9115114\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 08:20:11'),
(55, 4, 11, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1410171,33.9115132\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 08:25:35'),
(56, 4, 11, 'asd', '2023-06-23 08:28:24'),
(57, 4, 12, 'Hi!', '2023-06-23 08:28:36'),
(58, 4, 12, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.141021,33.9115088\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 08:28:42'),
(59, 4, 11, 'asd', '2023-06-23 08:30:03'),
(60, 4, 11, 'hi', '2023-06-23 08:30:31'),
(61, 4, 12, 'Hi!', '2023-06-23 08:30:43'),
(62, 4, 12, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1410105,33.9114893\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 08:30:59'),
(63, 4, 12, 'Im on my way', '2023-06-23 08:31:19'),
(64, 12, 31, 'Hi', '2023-06-23 10:03:29'),
(65, 12, 31, 'Here is my current location: <a href=\"https://www.google.com/maps?q=35.1460598,33.9087163\" target=\"_blank\">Open in Google Maps</a>', '2023-06-23 10:03:47'),
(66, 4, 12, 'Hi', '2023-06-23 10:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `chat_participants`
--

CREATE TABLE `chat_participants` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_participants`
--

INSERT INTO `chat_participants` (`chat_id`, `user_id`) VALUES
(4, 11),
(4, 12);

-- --------------------------------------------------------

--
-- Table structure for table `forgotpassword`
--

CREATE TABLE `forgotpassword` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rkey` char(32) NOT NULL,
  `time` int(11) NOT NULL,
  `status` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `forgotpassword`
--

INSERT INTO `forgotpassword` (`id`, `user_id`, `rkey`, `time`, `status`) VALUES
(1, 11, 'c5dc310b3639e39cefb73374e941b152', 1687366816, 'pending'),
(2, 12, '3612511bf910367fae1af13f4f12d509', 1687451341, 'used'),
(3, 12, '89a0ec3d10732631c060d7678dade189', 1687456525, 'pending'),
(4, 12, 'c51733e5ea604b4e79ad7543da654812', 1687456679, 'used');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_type` enum('join','leave') DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `trip_id`, `user_id`, `notification_type`, `message`, `created_at`) VALUES
(1, 4, 12, 'leave', 'Jam Artykov has left your Famagusta to Nicosia, Cyprus trip!', '2023-06-22 18:51:18'),
(2, 4, 12, 'leave', 'Jam Artykov has left your Famagusta to Nicosia, Cyprus trip!', '2023-06-22 18:52:28'),
(3, 4, 12, 'join', 'Jam Artykov has joined your Famagusta to Nicosia, Cyprus trip!', '2023-06-22 18:52:30'),
(4, 4, 12, 'leave', 'Jam Artykov has left your Famagusta to Nicosia, Cyprus trip!', '2023-06-22 18:56:52'),
(7, 4, 12, 'join', 'Jam Artykov has joined your Famagusta to Nicosia, Cyprus trip!', '2023-06-23 07:14:34'),
(8, 4, 12, 'leave', 'Jam Artykov has left your Famagusta to Nicosia, Cyprus trip!', '2023-06-23 07:14:55'),
(9, 4, 12, 'join', 'Jam Artykov has joined your Famagusta to Nicosia, Cyprus trip!', '2023-06-23 07:51:18'),
(10, 4, 12, 'leave', 'Jam Artykov has left your Famagusta to Nicosia, Cyprus trip!', '2023-06-23 07:51:20'),
(11, 4, 12, 'join', 'Jam Artykov has joined your Famagusta to Nicosia, Cyprus trip!', '2023-06-23 07:51:23'),
(16, 4, 12, 'join', 'You have been awarded 15 for your trip from Famagusta to Nicosia, Cyprus!', '2023-06-23 08:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `rememberme`
--

CREATE TABLE `rememberme` (
  `id` int(11) NOT NULL,
  `authentificator1` char(20) DEFAULT NULL,
  `f2authentificator2` char(64) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rememberme`
--

INSERT INTO `rememberme` (`id`, `authentificator1`, `f2authentificator2`, `user_id`, `expires`) VALUES
(1, '43010a41bf950505c0f3', 'f9e15ea3e768b982259a72e22d7c84b26b6a3e29c36f52944586a795f3f115a5', 11, '2023-07-06 06:13:30'),
(2, 'b9cc6a52b6b160ab1cda', 'ddc7ecac55a4619e7786fc7c5748e57a85af61de417bc859e34b5faa4329ff76', 12, '2023-07-06 15:08:03'),
(3, '2455dc7de788933743be', '45de8cca3491d673232add2383fc375934ececcd465add6580a51b3e4283dff2', 0, '2023-07-06 15:44:39'),
(4, 'a8e0a85460b058479ac3', 'f7f04bc085a78f91ce2f90f794fd32937002ac234ef3ffe22e50da34c33fdfee', 12, '2023-07-06 15:45:43'),
(5, 'dc759a9b429cb30f1812', '0ffde4ab05c26a2cd3c2a6c28623927a0d9a97df1d5efe3866b62df822c7a594', 0, '2023-07-06 15:51:41'),
(6, 'c5746723156c36c87ce4', '5abf914227afbe3b839d76950637a5bb9fa2a1dc168802f8b2c4a2a67f1e4711', 14, '2023-07-06 18:00:38'),
(7, '9d1cba0fb43e6869eded', 'f3d14a4f67ef4543fa9ddfbadaa3717a9db7a05fa70c2f31a467f3cb022fd409', 0, '2023-07-06 18:00:38'),
(8, '361f475ee43abc94f396', '1c068389a878eea5e1026147ff358f71640c4733b7dfb3a47fb8314c3f4c03a6', 0, '2023-07-06 18:00:39'),
(9, '4922a4e28614e2f0ebc0', 'e87ebf35a26bd96f11059bf4f3a026f2279fe4593148ed4c61798435c0a06c8c', 0, '2023-07-06 18:00:39'),
(10, 'a238528630e3f1ed2685', '1508f420a3b35dbc507ed2a1d8641f5305350c2f9981569737128ea5773875dd', 0, '2023-07-06 18:00:39'),
(11, '33dc901f8d0c48316c6d', '43d21e198ff2cec7215ba3bc8a11ff3b4da05bd1059fe7f1d59e5026269e2555', 0, '2023-07-06 18:00:39'),
(12, 'c3b7308e38c2ea071508', '598c2ccee148d2fbb35334dd7c60f0c1d1fe3445ba94fc1381fdf1566c794cb4', 0, '2023-07-06 18:00:40'),
(13, 'feac05033c2e68d2ef34', '5a4e40a75e05a3786c3a51e1b571b71db1a01afeff41b0243e538b746448d2e8', 0, '2023-07-06 18:00:40'),
(14, '8b0e9a12ccfa579409e6', '9d2570f29d42612b647d0e31e3efa06fe78b68fd105bf37dbf6b345b4c84e912', 0, '2023-07-06 18:00:40'),
(15, 'f54f07c0a22122ddf94b', '98b5a88c7c9c2b0f812836a56e199a67a4d5463e87e0822abf04223754dbfdac', 0, '2023-07-06 18:00:40'),
(16, '87a0d8b753f18090b14b', 'a956f3bb444aa0ec88b493512b67c140b444d94ed638ea12f16fd08ef106d447', 0, '2023-07-06 18:00:40'),
(17, '92bb5f945aa53ad0b4c4', 'fdaa69a519220db195e06df632042b72a6fd702b0eee30e7e7aa961fb69aea98', 0, '2023-07-06 18:00:40'),
(18, 'eec7ae005bd364f2fa65', 'c3b264c30c5c3f261bd39da6624c500759b5659bc734cf29460e219382aa12c4', 0, '2023-07-06 18:00:49'),
(19, 'b3e0abc687fde71e1838', '37baad5405b1509fcd5404279f60c8270caca775d789b8328a7fde0d527b5e09', 0, '2023-07-06 18:00:49'),
(20, '03aa7bff30701512b823', '73576d9beec53c5007ea9d8b116d8486d9d07a51e54a5ca61074e601d3d5f031', 0, '2023-07-06 18:00:50'),
(21, '825bfe90bb843b646079', 'c83721452bcee2cb4355976e0cad03d3f9a1381407ba34f3790fcbe067df2f38', 0, '2023-07-06 18:00:50'),
(22, '6f0e0ca14b597aa85e5b', '8785f3fea93bc2df0b9a4265f44964f1025e338d700407aefb1e02899939fed2', 0, '2023-07-06 18:00:50'),
(23, 'a59ed25d507449a9b99c', '93d196b65ecd78f0cecc39ad48db46b09a2162a0e1c776e5bc30de921b721e9c', 0, '2023-07-06 18:00:50'),
(24, 'a20cc1b45720b0159d81', '7d4f8b2eddae06ccdd188342c3f91a76e8ef02131fc3cc3f51f2cba66b774078', 0, '2023-07-06 18:00:51'),
(25, 'd9d20957d32b5479de1e', 'b709573f0bd18b081796f2e2d0ad097f28c25030b002eb351a0eff700fdc448a', 0, '2023-07-06 18:00:51'),
(26, '9727c1270ffe915e77c4', '58c39be5b74cccf25a4ba9652c276d06a42fd8342a0c8050340db1fa0b93084f', 0, '2023-07-06 18:00:51'),
(27, '4336920725620080b3f6', 'e84972c95b47db1942a9906e0e703f635315a356c2c35392fb580c1ad6ea3b96', 0, '2023-07-06 18:00:51'),
(28, '9234e2ceba40704790b0', '0356b985da887fb49d9d59d0192fc41ad0277ba80631b21b5030c1d4da6aa08b', 0, '2023-07-06 18:00:52'),
(29, '25330a419e7baf8b0f88', '668883af0fa57284125b470cda99412904166999c8f7dc0a53156f7760c1a0a1', 0, '2023-07-06 18:00:57'),
(30, '5e247fd06fdf92498bca', 'd11bdacc6064132583f5f07d9edd2169253fccf3b99cd545a74b36a63a81ac11', 0, '2023-07-06 18:00:57'),
(31, 'defe6a64968f6afaca88', 'e55ff1361b5b867c84d1970814660934b58204fa2b7ad187d832db1fc69f90fc', 0, '2023-07-06 18:00:58'),
(32, '15416c3e0b5e442f95ed', '7896411a6b0ab93114e19df65b05a9a7d971cb370696972cf0033f1701654491', 0, '2023-07-06 18:00:58'),
(33, '7ded9bce256106b3db00', '42a50c9ab6681bb5888ef1a353d5d5c432d2943906da10857facae1783bf1b75', 0, '2023-07-06 18:00:58'),
(34, '2716fde9673cebdb0c94', 'a7c7a8d89996f6e34eb2905e4bcb6777667299ad2529d70941dd7cb64f838ca1', 0, '2023-07-06 18:00:59'),
(35, 'ca4a1addd6a62d3c7702', 'a080bbcf97016d36e7248316efdf39ea0d39629261a2808376443b397de18ec2', 0, '2023-07-06 18:00:59'),
(36, '6886b5709d8bd7b0321c', '23c9e64b825ce9fa8bea8b4b6d5240f7e91d11e9fdd1728f1aed5c720c638e10', 0, '2023-07-06 18:00:59'),
(37, '70044fbd754efb024624', '6cebde079f89b347d7c8eb75452f26dde1d1519b5b196efeed39d8a328b03359', 0, '2023-07-06 18:00:59'),
(38, '24cf045dc344f84b24e6', '794d4559bc60e44dd7fc368d00a182bbba618222b2232b19d9859d070c844f2c', 0, '2023-07-06 18:01:00'),
(39, 'f57c703f939b58aab46d', 'd1e9045e3820e3ba93f6b1b3aca01c4ff4d525db1f4333f2d3f5121edae93fda', 0, '2023-07-06 18:01:00'),
(40, 'a19d1f3b3fb9084b84af', 'bc847126401a81ff5076325ee749b55c17f4862e4ab5e93e548dea578c9a8773', 0, '2023-07-06 18:01:04'),
(41, '00eba5c9b8f805ca6d66', 'ea053713d6c366eb57f27f06bcec7a3d5aba6fa1b8d2f4095e6a7526d5beffc5', 12, '2023-07-06 19:28:28'),
(42, '0cb077c39a2189dd3acd', '20a0cf12f88451eb002cddbef6fcbec3613c7be5ec0e74f81bcb1d22ef5bdcf3', 0, '2023-07-06 19:43:07'),
(43, 'b77f94c8e45c740796f7', 'dd84a6626b9009830c6f3a07d5135aa26269362863fe161274a017d41c7399e4', 0, '2023-07-06 20:05:27'),
(44, 'b74bede59e382cd15442', '5ff06fcb1ba903f95327cd0733d64769122ed6d704c8b0404e645fe60049adca', 0, '2023-07-06 20:26:29'),
(45, '775e98d4f0bab766af22', 'dd045201d72ce107f2efc4934a8be034909b779901aa83766a98597afbf45949', 12, '2023-07-06 20:34:38'),
(46, '4a4b9ae345d3af493c61', '711329e541f01519eacba12431cb53c502ce2a1f16a59116e6667c5a907ba62c', 12, '2023-07-06 20:52:26'),
(47, 'd1dbb35366a381905501', 'c46c6c5afa701e6c80b278c0264a92a40e26b9071c63ff89861115413137247b', 0, '2023-07-06 20:59:11'),
(48, 'd192fde99f8f38766f03', 'dd6ec402c480af08a591eae7b687660ad29d6fe97f57e68c647038579b7a97c2', 12, '2023-07-06 20:59:21'),
(49, '1b1b90d3d57c359f053b', 'f31ac00696d4e2b84d33ea4f49bdc12c1db06304f9369fb9fe8ef63937bc40e0', 0, '2023-07-06 20:59:33'),
(50, '87aff9ad3540eaa628cf', '6ec5a9e0b1de99e11b4ca628d31b8d28a9ca576f9b49bb52280040886ee7413c', 0, '2023-07-07 10:32:30'),
(51, '215445fb8e769225cb7b', 'a433e0b75f571a951c01493720015b0f99e6341ec7b058d454df6975d6001bc4', 0, '2023-07-07 10:32:41'),
(52, '564ce27889ed5ca9bd61', 'a7b13c22b23d1a086a6386158e877b9a85a7a84ab2d271a8250cdd06cd8ac13d', 0, '2023-07-07 10:32:41'),
(53, 'f43922b4495c01197a70', '46fe58dd52697c6e269ea70b1eeab3ec5db5fc6347f47a0ff86bf644b2b3df0c', 0, '2023-07-07 10:32:44'),
(54, '61ef745a463d90875614', 'b99a2fcfe77bd3cf0b746ec2756849823b3ae9b7b9b670344c8c423b18b88cc5', 0, '2023-07-07 10:32:44'),
(55, 'a08d12d5417bac139647', '1fe2e3fc9b96a5046bc5e5dc38cc4fa88707a69087e42a0eb7f16a6ec29e93e1', 0, '2023-07-07 10:33:03'),
(56, 'b5e54383edc97b09258d', '24888de43df0a06aa5464e4d306869761d993a014dc518c7733640cdc1246306', 0, '2023-07-07 10:33:04'),
(57, 'f20521875a68f72c5b8b', 'afa0fe9a72471e30fbe140a647b039f1e5b65c09e1ff00211e6f74bd762ddcb9', 11, '2023-07-07 10:33:39'),
(58, '0135a86b897a999ac78b', '7a012271bb41ea74b06fb885579b4df249cc6a5949a05555cddd49d23006f2ef', 0, '2023-07-07 12:40:09'),
(59, 'a562cee757466163c05e', '43ebc3f47c638c86ab10c367427781fd2f5eb502c0d05f63ef147fd6e470540d', 0, '2023-07-07 15:41:48'),
(60, 'f3d6e3e01d0737ab8d8b', 'bf2688a1d1a443724858432ef5ec946f2aa5f3670e9e749a1185238f8123812f', 0, '2023-07-07 15:41:53'),
(61, '58ae250f284638eeac16', '291f873b639ae925a4ec7eff45491afb54d54774147c6fdb8f4a1afd12d31e6d', 0, '2023-07-07 15:41:53'),
(62, '94df95cad66d1d7d92af', '9cb3f84b8da38086b2ed516130c2c538213d23b98d43d056032d9288d41f5f22', 12, '2023-07-07 18:03:03'),
(63, 'fa2265f4824d46cd1419', 'ec27cdbcbf4a7c6fb068117160692993f887bcac2910406de0356497a45f7980', 0, '2023-07-07 18:55:06'),
(64, 'ba1855952868bd3900e7', '0f83c87b6b11f975d45bffbf19c055a441a5b9a9a4f0811922d349bd460515af', 0, '2023-07-07 18:55:06'),
(65, '14bae9cdda3d625d2a2a', '4091cacdc9e0520192b61f54610b117c2f2a4ece5baa72343a1eb0c0ab2e199a', 0, '2023-07-07 18:55:14'),
(66, 'a026d3a79c5e35d6eacb', 'a2f277cc909055df0aa49b111b910ced00535349b4c534d612789147a0b9ef2c', 0, '2023-07-07 18:55:15'),
(67, 'b4fb5c1e9b30265233e8', '813452e011c4e55795aa7332e5c0050bd8725d6a8383e3d925315e4d26f2ac6b', 11, '2023-07-08 06:13:58'),
(68, '758ec5cd427a9fccee15', '0d9d5014346db598b248ca34f281270b0966190f1f36dc007dfe7b78fed84593', 0, '2023-07-08 08:34:35'),
(69, '6f3d7aec0a1a6ed4dd5d', '81c3703a15d12d471c3c03ccf1dad81a7552d23c413cf089994c7c9b00cd1275', 12, '2023-07-08 11:27:44'),
(70, '108230f1cc80da2d038a', 'f55ca2f537347cbd6c70fda7d8890acccbf43e12e3a539b0f449e24e94dc7331', 0, '2023-07-08 11:31:44'),
(71, '86dffbc3bbe1660ea208', '509cfcfc7f3d4a6c398199e3d5d7cc1daf1efeb195ecadf1968b7078cf0560d5', 0, '2023-07-08 11:40:51'),
(72, 'c54f92585c72252515fe', 'cb68866a8aa38b0d4b663ec61fa36469e07def906ef3485a119224b35c1dc01b', 0, '2023-07-08 12:58:37'),
(73, '9de64600558a778f8012', '4a7cb394ee69b7b23951671a43f309695762072b525b8afbefe377de4accbd3e', 0, '2023-07-08 12:58:38'),
(74, 'bc23413b77de64f8a63e', 'd2a5b96eba7c9f315d703dc7a63785f6f65194ab9d6810e5f27aba623e7ed09a', 0, '2023-07-08 12:58:39'),
(75, '90f782b53625a5f00d2f', 'd332be602acd56431936c3e4b422906014c506d88494e96ce10d22affbf8b2e1', 0, '2023-07-08 12:58:40'),
(76, 'f1b772a68df0c445f9ae', '99a19d2598933238b2343fa1b3f8eeaf39d063335832b32b17bcd81105e6fd7d', 0, '2023-07-08 12:58:40'),
(77, 'b7dadf860cd0d7877cfc', 'ad94c292a7cc163e839422e10f90acfe2b5e9a75da473b342bb5bd7a1c6b25a2', 0, '2023-07-08 12:58:41'),
(78, 'f4615974a49b62518aec', '38d3e4846962ff2580264d64c327969f000be2cf2147e8d31ede718fa2105eb6', 0, '2023-07-08 12:58:41'),
(79, 'fcf809102652ab81f4bf', '0904deb0d5287663c323614d593e0d561e7be56767f8b31b8a213e3946f89af6', 0, '2023-07-08 12:58:41'),
(80, '93bf1eb2deb4adaafe98', 'da3847cb45e663f8f23557210710e8cf1f428ef63645275a11edd74fe4d08338', 0, '2023-07-08 12:58:41'),
(81, '4bcc232b31eae996b4d7', '1df7db1ebe973fa72643de0883fdfe0868d43b0ca02807e55076d6a1e1711a96', 0, '2023-07-08 12:58:42'),
(82, 'deef23efecae0eef8650', '1ee7e6661b8cda481e813eac807fb275821f1b54572e709aecb60ac21d075470', 0, '2023-07-08 12:58:43'),
(83, 'f0666f820943a2df6e35', '81be221c627620ac7a2da72ff35bdde6f1e603c8a0c03982afb861e802c507f3', 0, '2023-07-08 12:58:43'),
(84, '8adad8d84b8ff542b7f3', 'aa2a4c25d4a08879c46747e03f24e52028a22becdbdf5de0d2f589ff28a1d1c2', 0, '2023-07-08 12:58:44'),
(85, '3e5cbd1149dbf33d00a5', '8a50a7c3181c87031eb2e6a7a26ff11e5951dd682adae2c05ae3414224e8a021', 0, '2023-07-08 12:58:45'),
(86, 'cbe0c2fed109f70a2d86', '974c7a6c348ad9eb83ef3d5cc513e7f42a08c22aa8e9b859a1f65bf370080b91', 0, '2023-07-08 12:58:47'),
(87, 'd050732d2aff1b76ff21', '990d578cc3d45bedba52b090334b69a75e9f10daa16f0f23769e0c3bbef20207', 0, '2023-07-08 12:58:48'),
(88, 'b968b7412d87c8c35652', '267207037ea1eb5922ce8e1afb088307ac9ee8517a389472e3e739e81bc34cb6', 0, '2023-07-08 12:58:49'),
(89, '99092faebd16b56b552f', '1c9ab3915b9c2b3e1aa876831058baa4c42b740db0d9adc6af83b42d14612aa8', 0, '2023-07-08 12:58:50'),
(90, '4e994b0a96f84e4d4607', 'f577b492e86a4fdf2a0c6eb32bd99c547dd34dd1434d85197b362d8b45f78e09', 0, '2023-07-08 12:58:51'),
(91, '08ff733a6b4c2a87f394', 'effa7409b67d8028efffa5e9cf75fe96db700fe2f86a75fbe44177f9cc86c32d', 0, '2023-07-08 12:58:52'),
(92, 'b0c079bd2249f178281e', 'f2233bfee6565711b78dccb1d38ef8c3af3aad279ce75086db0e2c24ea849452', 0, '2023-07-08 12:58:54'),
(93, '5faec4cab07763c83b5c', '025a9d2c43d0466b75cd490e61bf515247f3b369a8633f0df6849c6d66711ac3', 0, '2023-07-08 12:58:54'),
(94, 'e7d4d3c338e9f8945a5b', '6cd6db8e4d8afdc433152fb7ed947f318d049e1e58523fc39e12e94eb8197ba7', 0, '2023-07-08 12:58:54'),
(95, '78790a9cdac8476720b4', '678d5bb7a284e83867f39fb06f2d4399ac27d129fe797c55667066fdc2def121', 0, '2023-07-08 12:58:55'),
(96, '7c7bf974282e8d6fd4f2', '3f54615501badb2dde9d4c7d785d16dccf03c4fb81750a7cf9864f9d03948def', 0, '2023-07-08 12:58:55'),
(97, '9d91a3bd438e66858b69', 'e47821b96dfe14d7623ae60c48e040e1e5c2e806c13e30b3228a7bd66c139e41', 0, '2023-07-08 12:58:56'),
(98, '83bfd1ee71723b6eea72', '634582552251893037be0d2cfad9c4a70d004ed6f8b9caebc9294cf526e756a6', 0, '2023-07-08 12:58:57');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `type` enum('deposit','withdrawal','earnings','expenses') NOT NULL,
  `amount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `trip_id`, `type`, `amount`, `timestamp`) VALUES
(1, 11, NULL, 'deposit', 66666, '2023-06-22 14:17:08'),
(2, 12, NULL, 'withdrawal', 1000, '2023-06-22 16:16:12'),
(3, 12, NULL, 'deposit', 1000, '2023-06-22 16:19:03'),
(4, 12, NULL, 'deposit', 10000, '2023-06-22 16:19:15'),
(5, 12, NULL, 'withdrawal', 9569, '2023-06-22 17:34:24'),
(6, 11, NULL, 'withdrawal', 66636, '2023-06-22 18:57:08'),
(7, 11, NULL, 'deposit', 16, '2023-06-22 18:58:16'),
(8, 11, NULL, 'withdrawal', 16, '2023-06-22 19:00:07'),
(9, 11, NULL, 'deposit', 1000, '2023-06-22 19:07:03'),
(10, 11, NULL, 'withdrawal', 1200, '2023-06-22 19:16:30'),
(11, 11, NULL, 'deposit', 250, '2023-06-22 19:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `trip_participants`
--

CREATE TABLE `trip_participants` (
  `trip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_driver` tinyint(1) NOT NULL,
  `payment_amount` int(11) NOT NULL DEFAULT 0,
  `pickup_status` enum('pending','picked_up','not_picked_up') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `trip_participants`
--

INSERT INTO `trip_participants` (`trip_id`, `user_id`, `is_driver`, `payment_amount`, `pickup_status`) VALUES
(4, 11, 0, 15, 'picked_up'),
(4, 12, 1, 0, 'pending'),
(8, 11, 1, 0, 'pending'),
(9, 11, 1, 0, 'pending'),
(10, 11, 1, 0, 'pending'),
(11, 11, 1, 0, 'pending'),
(12, 31, 1, 0, 'pending'),
(13, 12, 1, 0, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` char(30) NOT NULL,
  `last_name` char(30) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `activation` char(32) DEFAULT NULL,
  `activation2` char(32) DEFAULT NULL,
  `gender` char(6) DEFAULT NULL,
  `phonenumber` char(15) DEFAULT NULL,
  `moreinformation` varchar(300) DEFAULT NULL,
  `profilepicture` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `activation`, `activation2`, `gender`, `phonenumber`, `moreinformation`, `profilepicture`) VALUES
(11, 'Jam', 'Artykov', 'mewmewmeowling', 'arty.jj3@gmail.com', '08b757a2e5dfad19df84b37d0cae03da807f4507e4519f31083fe5789139fc48', 'activated', NULL, 'male', '05428894264', 'Hello', 'profilepicture/44c9581985b2af8cfc1e09976c233369.'),
(12, 'Seyit Ahmet', 'Inci', 'seyitahmetinci', 'seyitahmetinci1@gmail.com', '4e76d0c32ef9673c394b9d5418d53a9df489b21e9566f546b0af9a209deef085', 'activated', NULL, 'male', '905488610166', 'I&#34;m happy to meet new people', 'profilepicture/7c8e9e39ab8a356b090cd3925326cdcb.'),
(13, 'Filiz', 'inci', 'filizinci', 'vq8bv70tcx@sfolkar.com', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', 'ce633d1bd7e6f2409352d6a32917bbb2', NULL, 'female', '5338652020', 'Looking forward to join ride', NULL),
(14, 'Filiz', 'inci', 'filizinci2', 'terdezemle@gufum.com', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', 'activated', NULL, 'female', '5338652020', 'Looking forward to join ride', NULL),
(15, 'Birkan', 'Son', 'birkanson', 'yabahi7852@camplvad.com', '3f05ada709fe63f1282fbebf7b2a5e46e0761add727c2005ea4a4c48bcf6a6c2', 'activated', NULL, 'male', '56562626222', 'I liked the theme.', NULL),
(16, 'Birkan', 'Ä°lk', 'birkanilk2', 'mekkuhikni@gufum.com', '3f05ada709fe63f1282fbebf7b2a5e46e0761add727c2005ea4a4c48bcf6a6c2', 'activated', NULL, 'male', '56562626222', 'I liked the theme too.', NULL),
(17, 'Birkan', 'Ã¼c', 'birkanilk3', 'gyvyhoto@socam.me', '3f05ada709fe63f1282fbebf7b2a5e46e0761add727c2005ea4a4c48bcf6a6c2', '171f1b09067b574e45ea34fb90726f78', NULL, 'male', '56562626222', 'I liked the theme too 3.', NULL),
(18, 'Birkan', 'Ã¼c', 'birkanilk34', 'uesgzlgn@exelica.com', '3f05ada709fe63f1282fbebf7b2a5e46e0761add727c2005ea4a4c48bcf6a6c2', 'activated', NULL, 'male', '56562626222', 'I liked the theme too 3.', NULL),
(19, 'Birkan', 'Ã¼c', 'birkanilk345', 'headcsdogyhvrr@exelica.com', '3f05ada709fe63f1282fbebf7b2a5e46e0761add727c2005ea4a4c48bcf6a6c2', 'activated', NULL, 'male', '56562626222', 'I liked the theme too 3.', NULL),
(20, 'Cem', 'Art', 'wutdafuqmeow@gmail.com', 'wutdafuqmeow@gmail.com', '08b757a2e5dfad19df84b37d0cae03da807f4507e4519f31083fe5789139fc48', 'activated', NULL, 'male', '05428894264', 'sad', NULL),
(21, 'Ahmad', 'Al Houri', 'ahmad', 'ahmedalhouri3@gmail.com', '08b757a2e5dfad19df84b37d0cae03da807f4507e4519f31083fe5789139fc48', '8f2edcd9b52af46e79e9e9415e44ba5d', NULL, 'male', '705428894264', 'sadasda', NULL),
(22, 'cme', 'art', 'dafuqq', 'wutdafuqmeow@hotmail.com', '08b757a2e5dfad19df84b37d0cae03da807f4507e4519f31083fe5789139fc48', '90358f07597a4f0be8dedf5a5a425a51', NULL, 'male', '3512512', '123', NULL),
(23, 'Seyit', 'Ä°nci', 'seyitahmetinci01', 'irodhbkfbdpjc@exelica.com', '3aca55eafece4a4cb28f87ecaf4d6109217f71f9e0c4505cd22c854c5637ceda', 'aee85c1929040c91a2f042b4bdb78d5f', NULL, 'male', '5488610166', 'Hi!', NULL),
(24, 'Seyit', 'Ä°nci', 'seyitahmetinci012', 'itqimt@exelica.com', '3aca55eafece4a4cb28f87ecaf4d6109217f71f9e0c4505cd22c854c5637ceda', '9adf9de3e3c06b723e160b39771ae452', NULL, 'male', '5488610166', 'Hi!', NULL),
(25, 'Seyit', 'Ä°nci', 'seyitahmetinci01234', 'uddsbizxhxw@exelica.com', '3aca55eafece4a4cb28f87ecaf4d6109217f71f9e0c4505cd22c854c5637ceda', 'b9323281fa218449d5e70d91163321db', NULL, 'male', '5488610166', 'Hi!', NULL),
(26, 'Seyit', 'Ä°nci', 'seyitahmetinci012345', 'batommquekvvc@exelica.com', '3aca55eafece4a4cb28f87ecaf4d6109217f71f9e0c4505cd22c854c5637ceda', '758bf32685de0ba75e0b49042523bb6c', NULL, 'male', '5488610166', 'Hi!', NULL),
(27, 'Seyit', 'Ä°nci', 'seyitahmetinci0123456', 'weltwzc@exelica.com', '3aca55eafece4a4cb28f87ecaf4d6109217f71f9e0c4505cd22c854c5637ceda', 'activated', NULL, 'male', '5488610166', 'Hi!', NULL),
(28, 'asds', 'asfdasd', 'deneme1', 'n644bk9fcvia@ezztt.com', '4bd29b620db0f7e8a09525eaf4cff16182729165b7e5e850ef9ac352ae1ba4b6', 'activated', NULL, 'male', '5488610166', 'Hi!', NULL),
(29, 'asdfasd', 'adsfasdf', 'denemehesap', '2y2592vhb8@zipcatfish.com', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', 'e29574a8c6e04823a181e2d915565543', NULL, 'male', '5488610166', 'g', NULL),
(30, 'asdfasd', 'adsfasdf', 'denemehesap2', 'mobazuz@mailto.plus', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', 'activated', NULL, 'male', '5488610166', 'g', NULL),
(31, 'dsafas', 'dfasdf', 'denemeh23', 'senofet257@aramask.com', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', 'activated', NULL, 'male', '5656165154', 'asdf', NULL),
(32, 'Name', 'Surname', 'username1', 'tedymasi@socam.me', '47469db0513b0eb417a17122636ecf3e266379c8500a1dab5adb9d96ac69234e', '5f7a9079143714f68b788c7764e3a291', NULL, 'male', '5488610166', 'Hi cmse238', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `user_id` int(11) NOT NULL,
  `balance` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`user_id`, `balance`) VALUES
(11, 35),
(12, 447),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(18, 0),
(19, 0),
(20, 0),
(21, 0),
(22, 0),
(23, 0),
(24, 0),
(25, 0),
(26, 0),
(27, 0),
(28, 0),
(29, 0),
(30, 0),
(31, 0),
(32, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carinformation`
--
ALTER TABLE `carinformation`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `carsharetrips`
--
ALTER TABLE `carsharetrips`
  ADD PRIMARY KEY (`trip_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD PRIMARY KEY (`chat_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rememberme`
--
ALTER TABLE `rememberme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `trip_participants`
--
ALTER TABLE `trip_participants`
  ADD PRIMARY KEY (`trip_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carsharetrips`
--
ALTER TABLE `carsharetrips`
  MODIFY `trip_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `forgotpassword`
--
ALTER TABLE `forgotpassword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rememberme`
--
ALTER TABLE `rememberme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carinformation`
--
ALTER TABLE `carinformation`
  ADD CONSTRAINT `carinformation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `carsharetrips` (`trip_id`);

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`),
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `chat_participants`
--
ALTER TABLE `chat_participants`
  ADD CONSTRAINT `chat_participants_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`),
  ADD CONSTRAINT `chat_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `carsharetrips` (`trip_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `carsharetrips` (`trip_id`);

--
-- Constraints for table `trip_participants`
--
ALTER TABLE `trip_participants`
  ADD CONSTRAINT `trip_participants_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `carsharetrips` (`trip_id`),
  ADD CONSTRAINT `trip_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
