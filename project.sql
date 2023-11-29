-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 29, 2023 at 12:00 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `name_` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `seller` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `name_`, `price`, `seller`) VALUES
(1, 'Increasing Luxury', '1.99', 'Amien'),
(2, 'Secondary Sediment', '2.99', 'Bertrude'),
(3, 'Determined Spine', '3.99', 'Christmas'),
(4, 'Distinctive Extract', '4.99', 'Dack'),
(5, 'Supporting Past', '5.99', 'Eshley'),
(7, 'Widespread Root', '7.99', 'Geatrice'),
(8, 'Teenage Agreement', '8.99', 'Hostel'),
(9, 'Golden Bond', '9.99', 'Iceland'),
(10, 'Intriguing Summary', '10.99', 'Janice'),
(11, 'Lithuanian Cheese', '11.99', 'Amien'),
(12, 'Worm on String', '12.99', 'Bertrude'),
(13, 'Bottle Without Genie', '13.99', 'Christmas'),
(14, 'Glass Half Full', '14.99', 'Dack'),
(15, 'Glass Half Empty', '15.99', 'Eshley'),
(17, 'Selected Sodium', '17.99', 'Geatrice'),
(18, 'Confused Executive', '18.99', 'Hostel'),
(19, 'Useless Decree', '19.99', 'Iceland'),
(20, 'Harmful Choice', '20.99', 'Janice'),
(25, 'Update Function Test Product', '0.00', 'Hostel'),
(30, 'Scam', '999.99', 'Seller Sellerson');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`username`, `password`) VALUES
('', '$2y$10$cVZ17CcTA20tOx.bApHNLu5MyMPgMqoQ3Q1HEepsMy49Is6ieL2OC'),
('11/24/2023', '$2y$10$XA9YfzDEZVSI9LgsNgMGp.8tsbs.JuInaWBdObgVLQwCWrUPv91SG'),
('Admin', '$2y$10$S9yyy50qFFNZBJE1uksXB.myeoqGlyaDRDmJQHUqeSaPyNJ0FN8.S'),
('battery', '$2y$10$bv.woyvGQknNMJqywr.tL.rSy2EStIwduHkmr8SkkVpAdbeZnSmvS'),
('Blank', '$2y$10$5erPq56wyk6pcnX11Vl8nO1gijPKkcxmEYlCytikl8/paP7ek0hJ2'),
('katheriner', '$2y$10$fySVDnHp05ytyQuIm5U5sux8xqgYGNpYuXe48GEfuDL0./0yvvEPa'),
('Lionel', '$2y$10$xQn2mEuvlUh8nksdI4VLQeRe/cvyjUuYOrCsdYNgGq2gQS1DINWRa'),
('loser17', '$2y$10$3jxMrXXkXVjtDp5nRLIM.um01x25VdWzmPEyPKlHktb9u313fo.AG'),
('new', '$2y$10$3Usy9HefNd4eZ/TVsBFmmevHE7qedWKBgKhqezsk0B0dake5OSaHq'),
('RandomGuyJames', '$2y$10$RCDycNkkZrvrd4lvE6yR7OQbSPWCJGM3fGjpveZCL/qOjeUmzmNGq'),
('salt', '$2y$10$ZuiJ.fj24r3IEiaZzhHo5uGDoKKb/IJ.7rISUS59uxA7UpuRtA/yG'),
('user jones', '$2y$10$lCDSBvVKdkLw7uBlD4X2KeFI6DBg/38jkpDzdNKd/JsWyody1rWQm'),
('Username', '$2y$10$A4E7DiJQXFCVtc4vDihrXu6Ky76r2G0nEKO55e2tCfvf0Nql3I4WW');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `sellerId` varchar(100) NOT NULL,
  `sales` int(11) NOT NULL DEFAULT '0',
  `country` varchar(100) NOT NULL,
  `state_` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`sellerId`, `sales`, `country`, `state_`) VALUES
('Amien', 1, 'UK', NULL),
('Bertrude', 12, 'Germany', NULL),
('Christmas', 0, 'USA', 'IL'),
('Dack', 9, 'USA', 'SD'),
('Eshley', 3, 'USA', 'CA'),
('Fish', 28, 'Sweden', NULL),
('Geatrice', 0, 'Canada', NULL),
('Hostel', 211, 'USA', 'NY'),
('Iceland', 0, 'China', NULL),
('Janice', 24, 'USA', 'GA'),
('Seller Sellerson', 15, 'Belize', NULL),
('SellerUpdateTest', 9, 'FakeCountry', 'FakeState');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `seller` (`seller`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`sellerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `sellers` (`sellerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
