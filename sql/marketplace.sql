-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 09:01 AM
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
-- Database: `marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` varchar(3) NOT NULL,
  `categoryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES
('bke', 'bike'),
('boo', 'boats'),
('cpu', 'computer'),
('cta', 'cars+trucks'),
('ela', 'electronics'),
('fua', 'furniture'),
('ppa', 'appliances'),
('sga', 'sporting goods'),
('tia', 'tickets'),
('vga', 'video gaming'),
('zip', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `uploadDate` datetime DEFAULT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `categoryID` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `userID`, `title`, `description`, `price`, `uploadDate`, `imageURL`, `categoryID`) VALUES
(1, 1, 'road bike', 'barely used', 500.00, '2024-04-30 00:00:00', '../images/roadbike.jpg', 'bke'),
(2, 3, 'mountain bike', 'used mountain bike \r\ngreat condition', 300.00, '2024-04-30 00:00:00', '../images/mountainbike.jpg', 'bke'),
(3, 3, '30ft boat', 'aluminum\r\n225hp\r\nthunderstruck 3', 45000.00, '2024-04-30 00:00:00', '../images/boat.jpg', 'boo'),
(4, 2, 'ryzen 3600', 'AMD ryzen 5 3600\r\nnever overclocked', 100.00, '2024-04-30 00:00:00', '../images/ryzen3600.jpg', 'cpu'),
(5, 2, 'Dell XPS 15', '16gb ram\r\n512gb ssd\r\nxps 15 9510', 1200.00, '2024-04-30 00:00:00', '../images/laptop.jpg', 'cpu');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `itemID` int(11) DEFAULT NULL,
  `messageID` int(11) NOT NULL,
  `receiverID` int(11) DEFAULT NULL,
  `senderID` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'seller = 1, buyer = 0',
  `messageContent` text DEFAULT NULL,
  `messageDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`itemID`, `messageID`, `receiverID`, `senderID`, `type`, `messageContent`, `messageDate`) VALUES
(2, 1, 3, 2, 0, 'I am interested', '2024-04-30 03:13:31'),
(2, 2, 3, 2, 1, 'When would you like to see this?', '2024-04-30 08:01:12'),
(1, 3, 1, 3, 0, 'hi, i am interested', '2024-04-30 08:12:12'),
(1, 4, 1, 3, 1, 'is it available', '2024-04-30 08:19:42'),
(1, 5, 1, 3, 1, 'when would you want to see it', '2024-04-30 08:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `registrationDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `email`, `password`, `phone`, `registrationDate`) VALUES
(1, 'jpham', 'jpham@example.com', 'sesame', '6045551234', '2024-04-30 00:00:00'),
(2, 'jdoe', 'jdoe@example.com', 'sesame', '1234567890', '2024-04-30 00:00:00'),
(3, 'mouse', 'mouse@example.com', 'sesame', '6041234567', '2024-04-30 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `UserID` (`userID`),
  ADD KEY `fk_categoryID` (`categoryID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `fk_itemID` (`itemID`),
  ADD KEY `receiverID` (`receiverID`) USING BTREE,
  ADD KEY `senderID` (`senderID`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_categoryID` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`),
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_itemID` FOREIGN KEY (`itemID`) REFERENCES `items` (`ItemID`),
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiverID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`senderID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
