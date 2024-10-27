-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 27, 2024 at 06:24 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jockstream`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_joke_providers`
--

CREATE TABLE `api_joke_providers` (
  `id` tinyint UNSIGNED NOT NULL,
  `host` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_uri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_activated` tinyint(1) NOT NULL,
  `total_used` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

-- --------------------------------------------------------

--
-- Table structure for table `api_provider_logs`
--

CREATE TABLE `api_provider_logs` (
  `id` int UNSIGNED NOT NULL,
  `provider_id` tinyint UNSIGNED NOT NULL,
  `request_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_code` smallint UNSIGNED NOT NULL,
  `error_message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_joke_providers`
--
ALTER TABLE `api_joke_providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `host` (`host`);

--
-- Indexes for table `api_provider_logs`
--
ALTER TABLE `api_provider_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `response_code` (`response_code`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_joke_providers`
--
ALTER TABLE `api_joke_providers`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `api_provider_logs`
--
ALTER TABLE `api_provider_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_provider_logs`
--
ALTER TABLE `api_provider_logs`
  ADD CONSTRAINT `fk_api_joke_providers_api_provider_logs_provider_id` FOREIGN KEY (`provider_id`) REFERENCES `api_joke_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
