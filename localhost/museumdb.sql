-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 04:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `museumdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `date`, `time`, `user_id`, `content`) VALUES
(2, '2024-06-09', '23:01:37', 5, '123\r\n'),
(3, '2024-06-09', '23:01:45', 5, 'i like that'),
(4, '2024-06-09', '23:01:53', 5, 'what beuatilful'),
(7, '2024-06-09', '23:11:27', 5, 'dssuidsiufsaiufa ygadahds dsfaaaaaaaaaa f fdsafafds fda fdafda fd fdsa fdsa fdsa fd fdsa fds f fa afd fd fd f fas  fd fdsa f fsa fsa fdsa f fdsa fa re rea vr  rewa r re yv  v rehctclkq  rcrcqyire urc c cyrewyuctr ccr yucr orc ot t'),
(8, '2024-06-09', '23:12:13', 5, '123'),
(9, '2024-06-09', '23:12:17', 5, '22321'),
(10, '2024-06-09', '23:12:21', 5, 'eweww'),
(12, '2024-06-09', '23:14:50', 5, 'eeee'),
(13, '2024-06-09', '23:15:28', 40, 'test good');

-- --------------------------------------------------------

--
-- Table structure for table `parag`
--

CREATE TABLE `parag` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parag`
--

INSERT INTO `parag` (`id`, `description`) VALUES
(1, 'Our museum stands as a beacon of cultural heritage and artistic expression, nestled in the heart of Beirut. With a rich tapestry of exhibits spanning centuries, we invite visitors to embark on a journey through time and creativity. From ancient artifacts that whisper tales of civilizations past to contemporary masterpieces that challenge the boundaries of imagination, each corner of our museum resonates with stories waiting to be discovered. Whether you are a history enthusiast, an art aficionado, or simply curious minds seeking inspiration, our museum promises a captivating experience for all ages and interests.');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `description`, `link`) VALUES
(1, 'Ancient Egypt', 'https://th.bing.com/th/id/R.d13f612d4139435d47791974bf5ab332?rik=JZXmFpPp7ViCFA&riu=http%3a%2f%2fwww.mightymac.org%2flondon2010%2f10uk094.jpg&ehk=aMps8c5SP9fBH54DgiCcnFyzwwsYyj%2biKyHfBIl5hos%3d&risl=&pid=ImgRaw&r=0'),
(2, 'Medieval Europe a', 'https://p4.storage.canalblog.com/46/75/119589/104759811_o.jpg'),
(3, 'Modern Art', 'https://yourartpages.com/wp-content/uploads/2022/06/best-art-museums-in-the-us-new-york-museum-of-modern-art-1024x576.jpg'),
(15, 'Cour Khorsabad Taureau Androcephale Aile:', 'https://api-www.louvre.fr/sites/default/files/styles/w956_h1280_c1/public/2021-05/cour-khorsabad-taureau-androcephale-aile.jpg'),
(20, 'Tiziano Vecellio Portrait ', 'https://api-www.louvre.fr/sites/default/files/styles/w1035_h924_c1/public/2020-12/tiziano-vecellio-dit-titien-portrait-d-homme-dit-l-homme-au-gant.jpg'),
(21, 'Sculpture Anthropomorphe Trrou Korrou', 'https://api-www.louvre.fr/sites/default/files/styles/w822_h1101_c1/public/2021-02/sculpture-anthropomorphe-trrou-korrou-dite-l-homme-bleu.jpg'),
(22, 'New Photo Description', 'link that ends with jpeg'),
(24, 'New Photo Description', 'link that ends with jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `dater` date NOT NULL,
  `time1` time NOT NULL,
  `time2` time NOT NULL,
  `persons` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `section`, `dater`, `time1`, `time2`, `persons`, `payment`, `status`) VALUES
(1, 1, 'Ancient Egypt', '2024-06-05', '16:20:00', '17:20:00', 1, 'VisaCard', 'cancelled'),
(2, 1, 'Medieval Europe', '2024-06-19', '16:37:00', '17:37:00', 2, 'VisaCard', 'cancelled'),
(3, 1, 'Ancient Egypt', '2024-06-19', '13:44:00', '14:44:00', 5, 'Cash', 'cancelled'),
(4, 1, 'Medieval Europe', '2024-06-16', '13:43:00', '14:43:00', 5, 'VisaCard', 'cancelled'),
(5, 5, 'Ancient Egypt', '2024-06-05', '14:22:00', '15:22:00', 43, 'VisaCard', 'cancelled'),
(6, 5, 'Medieval Europe', '2024-06-11', '13:41:00', '14:41:00', 4, 'VisaCard', 'cancelled'),
(7, 1, 'Medieval Europe', '2024-06-26', '16:59:00', '17:59:00', 13, 'VisaCard', 'cancelled'),
(8, 5, 'Ancient Egypt', '2024-06-10', '11:00:00', '12:00:00', 5, 'Cash', 'cancelled'),
(9, 1, 'Ancient Egypt', '2024-06-10', '11:00:00', '12:00:00', 6, 'VisaCard', 'cancelled'),
(10, 1, 'Ancient Egypt', '2024-06-10', '14:00:00', '15:00:00', 5, 'Cash', 'cancelled'),
(11, 40, 'Ancient Egypt', '2024-06-10', '16:00:00', '17:00:00', 2, 'VisaCard', 'cancelled'),
(12, 5, 'Medieval Europe', '2024-06-16', '11:00:00', '12:00:00', 3, '0', 'cancelled'),
(13, 5, 'Modern Art', '2024-06-16', '16:00:00', '17:00:00', 77, '0', 'cancelled'),
(14, 5, 'Medieval Europe', '2024-06-16', '16:00:00', '17:00:00', 2, '0', 'cancelled'),
(15, 5, 'Ancient Egypt', '2024-06-16', '13:00:00', '14:00:00', 4, '0', 'cancelled'),
(16, 40, 'Medieval Europe', '2024-06-17', '10:00:00', '11:00:00', 6, '0', 'active'),
(17, 5, 'Medieval Europe', '2024-06-16', '11:00:00', '12:00:00', 2, '0', 'cancelled'),
(18, 5, 'Ancient Egypt', '2024-06-15', '09:00:00', '10:00:00', 4, 'VisaCard', 'cancelled'),
(19, 5, 'Ancient Egypt', '2024-07-15', '11:00:00', '12:00:00', 33, 'VisaCard', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE `timer` (
  `openTime` text NOT NULL,
  `closeTime` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`openTime`, `closeTime`) VALUES
('07:00', '17:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, '1qq', 'pipo1@gmail.com', '$2y$10$Kq8D3rAgDYFxImmeLzeBg.b6aWJAwy68zjUKvBuLVxSU.S9VYXGVC'),
(3, 'pipo', 'pipo2@gmail.com', '$2y$10$1G46cJJ0kD7WaV3FqrXF3uqy9pfh4eaOxBD0X0fxHNEFVeJPFb1y6'),
(4, '1q23', 'pipo@gmail.com', '$2y$10$8TpiiVbEG8jM3Uk2duphOOkFPnqhMBAmEV5bbm6ASem/0bvMxf.fe'),
(5, 'admin', 'pierrehajjmoussa2@gmail.com', '$2y$10$lEqdGHiP9GYhBBbDuHHIdOtSUkekmWjw2QwPHxQQ0KF9Lldg1Yd96'),
(6, 'user1', 'user1@sssssssample.com', '$2y$10$HfbDdnYpt9K4oZ2ZSnxzcOyDUWC1A5gF22zsZ1I/T1rx0YI90Z54e'),
(7, 'user2', 'user2@example.com', 'hashed_password'),
(8, 'user3', 'user3@example.com', 'hashed_password'),
(9, 'user4', 'user4@example.com', 'hashed_password'),
(10, 'user5', 'user5@example.com', 'hashed_password'),
(11, 'user6', 'user6@example.com', 'hashed_password'),
(12, 'user7', 'user7@example.com', 'hashed_password'),
(13, 'user8', 'user8@example.com', 'hashed_password'),
(14, 'user9', 'user9@example.com', 'hashed_password'),
(15, 'user10', 'user10@example.com', 'hashed_password'),
(17, 'user12', 'user12@example.com', 'hashed_password'),
(18, 'user13', 'user13@example.com', 'hashed_password'),
(19, 'user14', 'user14@example.com', 'hashed_password'),
(20, 'user15', 'user15@example.com', 'hashed_password'),
(21, 'user16', 'user16@example.com', 'hashed_password'),
(22, 'user17', 'user17@example.com', 'hashed_password'),
(23, 'user18', 'user18@example.com', 'hashed_password'),
(24, 'user19', 'user19@example.com', 'hashed_password'),
(25, 'user20', 'user20@example.com', 'hashed_password'),
(26, 'user21', 'user21@example.com', 'hashed_password'),
(27, 'user22', 'user22@example.com', 'hashed_password'),
(28, 'user23', 'user23@example.com', 'hashed_password'),
(29, 'user24', 'user24@example.com', 'hashed_password'),
(30, 'user25', 'user25@example.com', 'hashed_password'),
(31, 'user26', 'user26@example.com', 'hashed_password'),
(32, 'user27', 'user27@example.com', 'hashed_password'),
(33, 'user28', 'user28@example.com', 'hashed_password'),
(34, 'user29', 'user29@example.com', 'hashed_password'),
(35, 'user30', 'user30@example.com', 'hashed_password'),
(36, 'admin', 'admin@example.com', 'adminpassword'),
(37, 'user1', 'user1@example.com', 'user1password'),
(38, '1234', '12@gmailcom', '$2y$10$lwup4HbJXVU6YUvjKJMiTOUUrN179l4uB54P/jl/WVTanr6TfeGeu'),
(39, 'pierre hajj', '12345@gmail.com', '$2y$10$Pm1rCWStc9Wz73VkuYuX9u6vUSwHISX56ZxwK4ZUxtNod3Zi7kiri'),
(40, '12333', '1233@gmail.com', '$2y$10$UFSKFhD.gNuyohYubrbk0u5DARW4/nLghqxP0TRHCmlqcAhgB4tqW'),
(41, 'pierrehajjmoussa2@gmail.com', 'pipo111@gmail.com', '$2y$10$EvVwRwPsYM.8tbG5PQYzCujFZpctjph3njomBJDs9KW.g/sNh7uce');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parag`
--
ALTER TABLE `parag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `parag`
--
ALTER TABLE `parag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
