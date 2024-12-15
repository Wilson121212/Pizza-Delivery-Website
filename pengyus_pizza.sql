-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 15, 2024 at 12:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengyus_pizza`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `feedback`, `rating`, `created_at`) VALUES
(1, 'Wilson', 'wilson@gmail.com', 'This is the best pizza I have ever had.', 5, '2024-10-17 06:45:45'),
(2, 'Tom', 'tom@gmail.com', 'Their online portal is very nice', 5, '2024-10-19 06:23:45');

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE `Items` (
  `itemID` int(10) UNSIGNED NOT NULL,
  `itemName` char(255) NOT NULL,
  `price` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`itemID`, `itemName`, `price`) VALUES
(1, 'Margheritta Pizza, Small - 10\"', 13.90),
(2, 'Margheritta Pizza, Medium - 12\"', 15.90),
(3, 'Margheritta Pizza, Large - 14\"', 17.90),
(4, 'Pepperoni Pizza, Small - 10\"', 11.90),
(5, 'Pepperoni Pizza, Medium - 12\"', 13.90),
(6, 'Pepperoni Pizza, Large - 14\"', 15.90),
(7, 'Veggie Delight, Small - 10\"', 11.90),
(8, 'Veggie Delight, Medium - 12\"', 13.90),
(9, 'Veggie Delight, Large - 14\"', 15.90),
(10, 'Cheesy Delight, Small - 10\"', 11.90),
(11, 'Cheesy Delight, Medium - 12\"', 13.90),
(12, 'Cheesy Delight, Large - 14\"', 15.90),
(13, 'Potato Pizza, Small - 10\"', 10.90),
(14, 'Potato Pizza, Medium - 12\"', 12.90),
(15, 'Potato Pizza, Large - 14\"', 14.90),
(16, 'Shroomzza, Small - 10\"', 6.45),
(17, 'Shroomzza, Medium - 12\"', 14.90),
(18, 'Shroomzza, Large - 14\"', 16.90),
(19, 'Promotion Set: \n3x Margherita Pizza (12-in., thin-crust), \n4x Chicken Wings, 2x Garlic Bread, \n1x Himalayan Fries, 3x Coca-Cola', 45.90),
(20, 'Himalayan Fries', 6.90),
(21, 'Personalized Pizza, Small - 10\"', 7.90),
(22, 'Personalized Pizza, Medium - 12\"', 9.90),
(23, 'Personalized Pizza, Large - 14\"', 11.90),
(24, 'Chicken Wings (1 Pair)', 7.50),
(25, 'Garlic Bread', 4.50),
(26, 'Mozzarella Cheese', 5.90),
(27, 'Himalayan Fries', 3.90),
(28, 'Coca Cola', 2.50),
(29, 'Sprite', 2.50),
(30, 'Iced Lemon Tea', 2.50),
(31, 'Margheritta Pizza Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90),
(32, 'Pepperoni Pizza Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90),
(33, 'Veggie Delight Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90),
(34, 'Cheesy Delight Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90),
(35, 'Potato Pizza Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90),
(36, 'Shroomzza Meal Set (inclu. Iced Lemon Tea & Fries)', 22.90);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `orderID` int(10) UNSIGNED NOT NULL,
  `itemID` int(10) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED DEFAULT NULL,
  `thickness` varchar(100) DEFAULT NULL,
  `sauce` varchar(100) DEFAULT NULL,
  `toppings` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user1`
--

CREATE TABLE `user1` (
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user1`
--

INSERT INTO `user1` (`username`, `password`) VALUES
('username', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`itemID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
