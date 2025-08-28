-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2025 at 07:34 AM
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
-- Database: `drel_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `batch` varchar(100) DEFAULT NULL,
  `date_of_instructions` date DEFAULT NULL,
  `reliant_reference_number` varchar(100) DEFAULT NULL,
  `bank_reference_number` varchar(100) DEFAULT NULL,
  `prepared_for` varchar(255) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `property_type` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `location_coordinates` varchar(100) DEFAULT NULL,
  `property_description` text DEFAULT NULL,
  `property_occupancy` varchar(100) DEFAULT NULL,
  `property_tenure` varchar(100) DEFAULT NULL,
  `property_status` varchar(100) DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `floors` varchar(100) DEFAULT NULL,
  `bua_sqm` decimal(12,2) DEFAULT NULL,
  `bua_sqft` decimal(12,2) DEFAULT NULL,
  `land_plot_size_sqm` decimal(12,2) DEFAULT NULL,
  `land_plot_size_sqft` decimal(12,2) DEFAULT NULL,
  `purpose_of_valuation` varchar(255) DEFAULT NULL,
  `date_of_valuation` date DEFAULT NULL,
  `capacity_of_valuer` varchar(100) DEFAULT NULL,
  `method_of_valuation` varchar(100) DEFAULT NULL,
  `transaction_range` varchar(255) DEFAULT NULL,
  `adopted_rate_per_sqft` decimal(12,2) DEFAULT NULL,
  `market_value_rounded` decimal(15,2) DEFAULT NULL,
  `subject_to_valuation` varchar(255) DEFAULT NULL,
  `forced_sale_value_aed` decimal(15,2) DEFAULT NULL,
  `annual_rent_aed` decimal(15,2) DEFAULT NULL,
  `comparable_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `progress` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `generated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_queue`
--

CREATE TABLE `report_queue` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `status` enum('pending','processing','done','failed') DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Manager') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'Rehman Shoaib', 'shoaib', 'shoaib@reliantsurveyors.com', '$2y$10$tH0OD2c9mZ/hIn7IOIPRYe6xvZ6.S5f/ylN9AzlEvJmLauKDeRcvS', 'Admin', '2025-08-27 13:16:39'),
(5, 'Shoaib Ahmad', 'shoaib123', 'shoaib@gmail.com', '$2y$10$V0P53nXduNbdnqHFdafe8.aYPIYsVrGaLrcxzK78YZcsAnzjlxS2q', 'Admin', '2025-08-28 05:17:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_queue`
--
ALTER TABLE `report_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_queue`
--
ALTER TABLE `report_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `report_queue`
--
ALTER TABLE `report_queue`
  ADD CONSTRAINT `report_queue_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
