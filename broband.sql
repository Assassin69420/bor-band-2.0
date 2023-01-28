-- Adminer 4.8.1 MySQL 8.0.31 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `customer_plan_tracker`;
CREATE TABLE `customer_plan_tracker` (
  `customer_id` int NOT NULL,
  `plan_id` int NOT NULL,
  `date_of_purchase` date NOT NULL,
  KEY `customer_id` (`customer_id`),
  KEY `plan_id` (`plan_id`),
  CONSTRAINT `customer_plan_tracker_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`C_id`) ON DELETE CASCADE,
  CONSTRAINT `customer_plan_tracker_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`Plan_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `C_id` int NOT NULL,
  `C_conn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `S_id` int DEFAULT NULL,
  PRIMARY KEY (`C_id`),
  KEY `customers_c_conn_foreign` (`C_conn`),
  KEY `customers_s_id_foreign` (`S_id`),
  CONSTRAINT `constcid` FOREIGN KEY (`C_id`) REFERENCES `useraccount` (`U_id`),
  CONSTRAINT `customers_c_conn_foreign` FOREIGN KEY (`C_conn`) REFERENCES `serviceprovider` (`SerPName`),
  CONSTRAINT `customers_s_id_foreign` FOREIGN KEY (`S_id`) REFERENCES `service` (`S_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `Of_id` int NOT NULL,
  `Of_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Of_amount` bigint NOT NULL,
  `Of_valid` int NOT NULL,
  PRIMARY KEY (`Of_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `Plan_id` int NOT NULL,
  `Plan_Name` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Plan_starting_Date` date DEFAULT NULL,
  `Plan_ending_Date` date DEFAULT NULL,
  `Plan_Amount` bigint DEFAULT NULL,
  PRIMARY KEY (`Plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `plans` (`Plan_id`, `Plan_Name`, `Plan_starting_Date`, `Plan_ending_Date`, `Plan_Amount`) VALUES
(1,	'Test Plan',	'2023-06-26',	'2023-09-26',	500),
(2,	'Test Plan2',	'2024-01-23',	'2024-12-10',	1500),
(3,	'Test Plan',	'2023-06-26',	'2023-09-26',	3500);

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
  `S_id` int NOT NULL,
  `S_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `S_city` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `S_phone` bigint NOT NULL,
  `S_amount` bigint NOT NULL,
  `Of_id` int DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'https://images.unsplash.com/photo-1589820745206-c6b6d3602361?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OXx8SW5kaWFuJTIwQ2l0eXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60',
  PRIMARY KEY (`S_id`),
  KEY `service_of_id_foreign` (`Of_id`),
  CONSTRAINT `service_of_id_foreign` FOREIGN KEY (`Of_id`) REFERENCES `offers` (`Of_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service` (`S_id`, `S_name`, `S_city`, `S_phone`, `S_amount`, `Of_id`, `img`) VALUES
(1,	'Router-Installation',	'Bangalore',	9877880000,	5000,	NULL,	'https://images.unsplash.com/photo-1589820745206-c6b6d3602361?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OXx8SW5kaWFuJTIwQ2l0eXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60'),
(2,	'Fibre-Cable',	'Mumbai',	9898980000,	4000,	NULL,	'https://images.unsplash.com/photo-1589820745206-c6b6d3602361?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OXx8SW5kaWFuJTIwQ2l0eXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60'),
(3,	'Access-Point',	'kolkata',	9879803282,	8000,	NULL,	'https://media.istockphoto.com/id/504701694/photo/the-last-sailors-sunset.jpg?s=612x612&w=0&k=20&c=pfqcEEsG66h37VWNTdk6ItLTJP8-XQjQC9YTgx6yqHE='),
(4,	'Server-room-maintainance',	'Delhi',	9876543210,	8000,	NULL,	'https://images.unsplash.com/photo-1589820745206-c6b6d3602361?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OXx8SW5kaWFuJTIwQ2l0eXxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60');

DROP TABLE IF EXISTS `serviceprovider`;
CREATE TABLE `serviceprovider` (
  `SerPName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sta_amount` bigint NOT NULL,
  `C_id` int NOT NULL,
  PRIMARY KEY (`SerPName`),
  KEY `serviceprovider_c_id_foreign` (`C_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `ulogin`;
CREATE TABLE `ulogin` (
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ulogin` (`username`, `password`) VALUES
('Aryaman47',	'Uncharted 4'),
('Rayyan',	'Sol'),
('Shotspot',	'Shotspot53'),
('Sunny',	'Assassin69');

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
  `U_id` int NOT NULL,
  `Username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `U_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `U_gender` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `U_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `U_phone` bigint NOT NULL,
  PRIMARY KEY (`U_id`),
  UNIQUE KEY `useraccount_username_unique` (`Username`),
  CONSTRAINT `changingusername` FOREIGN KEY (`Username`) REFERENCES `ulogin` (`username`),
  CONSTRAINT `useraccount_username_foreign` FOREIGN KEY (`Username`) REFERENCES `ulogin` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `useraccount` (`U_id`, `Username`, `U_name`, `U_gender`, `U_address`, `U_phone`) VALUES
(1,	'Aryaman47',	'Om Aryaman Pattnaik',	'Male',	'Hormavu Agara',	9874808888),
(2,	'Sunny',	'Somya',	'Male',	'MS Palya',	81188999777),
(3,	'Rayyan',	'Rayyan',	'Male',	'Yelahanka',	9696968888),
(4,	'Shotspot',	'Sahani',	'Male',	'Yeshwantpur',	9090908787);

-- 2023-01-19 19:59:14
