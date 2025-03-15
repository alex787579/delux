-- Adminer 4.8.1 MySQL 8.0.27 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `delux_users_list`;
CREATE TABLE `delux_users_list` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `NAME` varchar(30) NOT NULL,
  `EMAIL` varchar(30) NOT NULL,
  `PASSWORD` varchar(30) NOT NULL,
  `IS_ACTIVE` varchar(30) NOT NULL,
  `CONTACT` int NOT NULL,
  `ADDRESS` varchar(100) NOT NULL,
  `ROLE` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `std_pkg` int DEFAULT NULL,
  `value_mrp_less_50` decimal(10,2) DEFAULT NULL,
  `material_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `part_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `segment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `materials` (`id`, `std_pkg`, `value_mrp_less_50`, `material_no`, `part_number`, `segment`, `status`) VALUES
(832,	1,	123.00,	'DJL610',	'DLX - JL 610',	'NRB',	'1'),
(833,	1,	238.00,	'DJL68',	'DLX - JL 68',	'NRB',	'1'),
(834,	20,	33.00,	'6000',	'DLX - 6000',	'2W BB',	'1');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dist_ch` int DEFAULT NULL,
  `sold_to_party_cust_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ship_to_cust_code` int DEFAULT NULL,
  `material_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `std_pkg` int DEFAULT NULL,
  `value_mrp_less_50` decimal(10,2) DEFAULT NULL,
  `total_value_mrp_less_50` decimal(10,2) DEFAULT NULL,
  `segment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_of_packs` decimal(10,2) DEFAULT NULL,
  `std_packing_ok_not_ok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `order_value` decimal(10,2) DEFAULT NULL,
  `order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `orders` (`id`, `dist_ch`, `sold_to_party_cust_code`, `ship_to_cust_code`, `material_no`, `qty`, `std_pkg`, `value_mrp_less_50`, `total_value_mrp_less_50`, `segment`, `no_of_packs`, `std_packing_ok_not_ok`, `order_value`, `order_id`, `status`, `created_at`, `created_by`, `updated_at`) VALUES
(836,	NULL,	NULL,	NULL,	'DJL68',	4,	1,	NULL,	NULL,	'NRB',	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-03-13 18:37:47',	NULL,	'2025-03-13 18:37:47');

DROP TABLE IF EXISTS `orders_trail`;
CREATE TABLE `orders_trail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dist_ch` int DEFAULT NULL,
  `sold_to_party_cust_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ship_to_cust_code` int DEFAULT NULL,
  `material_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `std_pkg` int DEFAULT NULL,
  `value_mrp_less_50` decimal(10,2) DEFAULT NULL,
  `total_value_mrp_less_50` decimal(10,2) DEFAULT NULL,
  `segment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_of_packs` decimal(10,2) DEFAULT NULL,
  `std_packing_ok_not_ok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `order_value` decimal(10,2) DEFAULT NULL,
  `order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `order_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `orders_trail` (`id`, `dist_ch`, `sold_to_party_cust_code`, `ship_to_cust_code`, `material_no`, `qty`, `std_pkg`, `value_mrp_less_50`, `total_value_mrp_less_50`, `segment`, `no_of_packs`, `std_packing_ok_not_ok`, `order_value`, `order_id`, `status`, `order_type`, `created_at`, `created_by`, `updated_at`) VALUES
(835,	NULL,	NULL,	NULL,	'DJL610',	2,	1,	123.00,	NULL,	'NRB',	NULL,	NULL,	NULL,	NULL,	'P',	'Regular',	'2025-03-13 18:44:56',	NULL,	'2025-03-13 19:27:26');

DROP TABLE IF EXISTS `uploaded_files`;
CREATE TABLE `uploaded_files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `created_at` varchar(100) DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `uploaded_files` (`id`, `order_id`, `filename`, `created_at`, `updated_at`) VALUES
(48,	'DELUX-1741539984',	'uploads/1741539984_ORDER Template.xlsx',	'2025-03-09 17:06:24',	'2025-03-09 17:06:24');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_active` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '1',
  `contact` int DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_active`, `contact`, `address`, `role`, `created_at`, `updated_at`) VALUES
(1,	'John Cena',	'john@gmail.com',	'1234',	'1',	2147483647,	'123 Main St, NY',	'admin',	'2025-03-04 16:43:01',	'2025-03-04 16:43:01'),
(2,	'Test Email',	'test@gmail.com',	'1234',	'1',	2147483647,	'456 Park Ave, CA',	'user',	'2025-03-04 16:43:01',	'2025-03-04 16:43:01'),
(6,	'PQR',	'pqr@email.com',	'1234',	'1',	NULL,	NULL,	NULL,	'2025-03-05 12:26:58',	'2025-03-05 12:26:58'),
(5,	'XYZ',	'xyz@email.com',	'1234',	'1',	NULL,	NULL,	NULL,	'2025-03-05 12:26:58',	'2025-03-05 12:26:58');

-- 2025-03-15 05:03:12
