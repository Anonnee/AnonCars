-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 06:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `car_dealership`


-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `CarID` varchar(10) NOT NULL,
  `CarName` varchar(50) NOT NULL,
  `CarDescription` text NOT NULL,
  `QuantityAvailable` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `ProductAddedBy` varchar(50) NOT NULL DEFAULT 'Hrishikesh Kindre',
  `CarStatus` varchar(10) NOT NULL,
  `CarTrim` varchar(30) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Dumping data for table `cars`


INSERT INTO `cars` (`CarID`, `CarName`, `CarDescription`, `QuantityAvailable`, `Price`, `ProductAddedBy`, `CarStatus`, `CarTrim`, `last_updated`) VALUES
('ADS-102', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 3, 32000.00, 'Daulat Talpde', 'New', 'GT', '2024-10-04 03:12:48'),
('ADS-103', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 2, 36000.00, 'Johnny Lever', 'New', 'R/T', '2024-10-04 03:12:48'),
('ADS-105', 'Ford Mustang', 'Iconic American muscle car known for its impressive performance and sleek design.', 2, 35000.00, 'Hrikish Kindre', 'New', 'GT', '2024-10-04 03:12:48'),
('ADS-106', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 3, 25000.00, 'Johnny Lever', 'New', 'LS', '2024-10-04 03:12:48'),
('ADS-107', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 2, 29000.00, 'Deepak Kalal', 'New', 'LT', '2024-10-04 03:12:48'),
('ADS-108', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 1, 37000.00, 'Bablu Phatak', 'New', 'SS', '2024-10-04 03:12:48'),
('ADS-109', 'Honda Civic', 'Reliable and efficient, the Civic is known for its longevity and compact design.', 4, 22000.00, 'Daulat Talpde', 'New', 'LX', '2024-10-04 03:12:48'),
('ADS-110', 'Honda Accord', 'A staple in the midsize sedan market, offering comfort and innovative technology.', 3, 24000.00, 'Johnny Lever', 'New', 'Sport', '2024-10-04 03:12:48'),
('ADS-111', 'Kia Sorento', 'A family-friendly SUV offering ample space and modern tech features.', 4, 29000.00, 'Bablu Phatak', 'New', 'S', '2024-10-04 03:12:48'),
('ADS-112', 'Kia Optima', 'Sleek design and comfortable interiors make the Optima a great choice for a midsize sedan.', 3, 23000.00, 'Hrikish Kindre', 'New', 'EX', '2024-10-04 03:12:48'),
('ADS-113', 'Mahindra Scorpio', 'Police Car used in India (Inspector Talpade)', 10, 30000.00, 'YourName', 'New', 'XUV', '2024-10-04 03:50:11'),
('ADS-114', 'Suzuki Swift', 'Frog like car in india', 40, 5000.00, 'YourName', 'New', 'LXS', '2024-10-04 03:58:56'),
('ADS-115', 'Suzuki Accord', 'Nice car', 40, 6000.00, 'YourName', 'New', 'XLS', '2024-10-04 03:59:23'),
('TRD-101', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 1, 33000.00, 'Deepak Kalal', 'Used', 'SRT Hellcat', '2024-10-04 03:12:48'),
('TRD-103', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 1, 34000.00, 'Hrikish Kindre', 'Used', 'ZL1', '2024-10-04 03:12:48'),
('TRD-104', 'Honda CR-V', 'Spacious and versatile, the CR-V is ideal for families seeking practicality and safety.', 2, 26000.00, 'Deepak Kalal', 'Used', 'EX-L', '2024-10-04 03:12:48'),
('TRD-105', 'Kia Forte', 'Compact yet stylish, the Forte offers excellent value and efficiency for urban drivers.', 2, 19000.00, 'Daulat Talpde', 'Used', 'GT-Line', '2024-10-04 03:12:48'),
('TRD-106', 'Maruti 800', 'oldest car in india', 5, 2000.00, 'YourName', 'Used', 'ls', '2024-10-04 03:58:27');


-- Indexes for dumped tables

ALTER TABLE `cars`
  ADD PRIMARY KEY (`CarID`);
COMMIT;
