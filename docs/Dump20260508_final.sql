CREATE DATABASE  IF NOT EXISTS `food_order` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `food_order`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: food_order
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_log`
--

DROP TABLE IF EXISTS `audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_name` varchar(50) NOT NULL,
  `action_type` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `record_id` int NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `changed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_audit_user_id` (`user_id`),
  KEY `idx_audit_customer_id` (`customer_id`),
  KEY `idx_audit_table_record` (`table_name`,`record_id`),
  CONSTRAINT `fk_audit_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_audit_internal_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_log`
--

LOCK TABLES `audit_log` WRITE;
/*!40000 ALTER TABLE `audit_log` DISABLE KEYS */;
INSERT INTO `audit_log` VALUES (1,'foods','INSERT',1,NULL,'{\"price\": 12.99, \"title\": \"Margherita Pizza\"}','2026-05-08 07:27:59',NULL,NULL);
/*!40000 ALTER TABLE `audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_code` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `active` enum('Yes','No') DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_code` (`category_code`),
  KEY `idx_cat_active` (`active`),
  KEY `fk_cat_created_by` (`created_by`),
  KEY `fk_cat_updated_by` (`updated_by`),
  CONSTRAINT `fk_cat_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cat_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'CAT001','Italian Pizza','pizza.jpg','Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(2,'CAT002','Gourmet Burgers','burger.jpg','Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(3,'CAT003','Fresh Salads','salad.jpg','Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(4,'CAT004','Beverages','drinks.jpg','Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(5,'CAT005','Desserts','dessert.jpg','No','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_cust_email` (`email`),
  KEY `idx_cust_phone` (`phone`),
  KEY `fk_cust_created_by` (`created_by`),
  KEY `fk_cust_updated_by` (`updated_by`),
  CONSTRAINT `fk_cust_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cust_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Alice','Smith','alice@gmail.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','555-0101','123 Maple St','New York','2026-05-08 07:27:59','2026-05-08 08:12:56',1,NULL),(2,'Bob','Johnson','bob@yahoo.com','pass456','555-0102','456 Oak Avenue','Chicago','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(3,'Charlie','Brown','charlie@outlook.com','pass789','555-0103','789 Pine Lane','Los Angeles','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `foods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `food_code` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `image_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int NOT NULL,
  `active` enum('Yes','No') DEFAULT 'Yes',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `food_code` (`food_code`),
  KEY `fk_food_created_by` (`created_by`),
  KEY `fk_food_updated_by` (`updated_by`),
  KEY `idx_food_active` (`active`),
  KEY `idx_foods_category_active` (`category_id`,`active`),
  FULLTEXT KEY `idx_food_search` (`title`,`description`),
  CONSTRAINT `fk_food_cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_food_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_food_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `chk_food_price` CHECK ((`price` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foods`
--

LOCK TABLES `foods` WRITE;
/*!40000 ALTER TABLE `foods` DISABLE KEYS */;
INSERT INTO `foods` VALUES (1,'F001','Margherita Pizza','Classic tomato, mozzarella, and basil',NULL,12.99,1,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(2,'F002','Pepperoni Feast','Double pepperoni with extra cheese',NULL,15.50,1,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(3,'F003','Classic Cheeseburger','Angus beef patty with cheddar cheese',NULL,9.99,2,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(4,'F004','Bacon BBQ Burger','Beef patty, crispy bacon, and BBQ sauce',NULL,11.50,2,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(5,'F005','Caesar Salad','Romaine lettuce with Caesar dressing',NULL,8.50,3,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(6,'F006','Iced Lemon Tea','Freshly brewed tea with lemon',NULL,3.50,4,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL),(7,'F007','Coca Cola','Chilled 500ml bottle',NULL,2.50,4,'Yes','2026-05-08 07:27:59','2026-05-08 07:27:59',1,NULL);
/*!40000 ALTER TABLE `foods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `food_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS ((`quantity` * `unit_price`)) STORED,
  PRIMARY KEY (`id`),
  KEY `fk_item_order` (`order_id`),
  KEY `fk_item_food` (`food_id`),
  CONSTRAINT `fk_item_food` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_item_price` CHECK ((`unit_price` > 0)),
  CONSTRAINT `chk_item_qty` CHECK ((`quantity` > 0))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `quantity`, `unit_price`) VALUES (1,1,1,1,12.99),(2,1,2,1,15.50),(3,2,4,1,11.50),(4,3,5,1,8.50),(5,3,1,1,12.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_number` varchar(20) NOT NULL,
  `customer_id` int NOT NULL,
  `status` varchar(50) DEFAULT 'Ordered',
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `delivery_phone` varchar(20) NOT NULL,
  `payment_method` enum('Cash','Card','Online') DEFAULT 'Cash',
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `fk_order_cust` (`customer_id`),
  KEY `fk_order_updated_by` (`updated_by`),
  KEY `idx_order_status` (`status`),
  KEY `idx_order_date` (`created_at`),
  KEY `idx_orders_created_at` (`created_at`),
  KEY `idx_orders_status_payment` (`status`,`payment_status`),
  CONSTRAINT `fk_order_cust` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `fk_order_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `chk_order_total` CHECK ((`total_amount` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'ORD-2023-001',1,'On Delivery',25.48,'123 Maple St, New York','555-0101','Card','Pending','2026-05-08 07:27:59','2026-05-08 12:21:40',NULL),(2,'ORD-2023-002',2,'Ordered',11.50,'456 Oak Avenue, Chicago','555-0102','Cash','Pending','2026-05-08 07:27:59','2026-05-08 12:21:45',NULL),(3,'ORD-2023-003',3,'Processing',21.49,'789 Pine Lane, Los Angeles','555-0103','Online','Paid','2026-05-08 07:27:59','2026-05-08 07:27:59',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_type` enum('user','customer') NOT NULL,
  `account_id` int NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `idx_password_resets_account` (`account_type`,`account_id`),
  KEY `idx_password_resets_token` (`token`),
  KEY `idx_password_resets_token_lookup` (`token`,`expires_at`),
  KEY `idx_password_resets_user` (`user_id`),
  KEY `idx_password_resets_customer` (`customer_id`),
  CONSTRAINT `fk_reset_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reset_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (1,'customer',1,'abc123token789xyz','2026-05-08 13:57:59',0,'2026-05-08 07:27:59',NULL,NULL);
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `role` enum('Admin','Manager','Staff') NOT NULL DEFAULT 'Staff',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Johns','Admin','admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin@restaurant.com','Admin','2026-05-08 07:27:59','2026-05-08 13:47:11'),(2,'Jane','Manager','jane_m','$2y$10$i5Q.oFz8P1Z.qA9G0G5WHeY8V.QzY6G1g6f5e4d3c2b1a','jane@restaurant.com','Manager','2026-05-08 07:27:59','2026-05-08 07:27:59'),(3,'Robert','Staff','robert_s','$2y$10$i5Q.oFz8P1Z.qA9G0G5WHeY8V.QzY6G1g6f5e4d3c2b1a','robert@restaurant.com','Staff','2026-05-08 07:27:59','2026-05-08 07:27:59');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vw_food_catalog`
--

DROP TABLE IF EXISTS `vw_food_catalog`;
/*!50001 DROP VIEW IF EXISTS `vw_food_catalog`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_food_catalog` AS SELECT 
 1 AS `id`,
 1 AS `food_code`,
 1 AS `title`,
 1 AS `description`,
 1 AS `image_name`,
 1 AS `price`,
 1 AS `category_id`,
 1 AS `active`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `created_by`,
 1 AS `updated_by`,
 1 AS `category_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vw_order_master`
--

DROP TABLE IF EXISTS `vw_order_master`;
/*!50001 DROP VIEW IF EXISTS `vw_order_master`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vw_order_master` AS SELECT 
 1 AS `id`,
 1 AS `order_number`,
 1 AS `customer_id`,
 1 AS `status`,
 1 AS `total_amount`,
 1 AS `delivery_address`,
 1 AS `delivery_phone`,
 1 AS `payment_method`,
 1 AS `payment_status`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `updated_by`,
 1 AS `customer_full_name`,
 1 AS `customer_email`,
 1 AS `customer_phone`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'food_order'
--

--
-- Dumping routines for database 'food_order'
--
/*!50003 DROP PROCEDURE IF EXISTS `AddCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddCategory`(
    IN p_code VARCHAR(20),
    IN p_title VARCHAR(100),
    IN p_image VARCHAR(255),
    IN p_active VARCHAR(10),
    IN p_admin_id INT
)
BEGIN
    INSERT INTO category (category_code, title, image_name, active, created_by, updated_by)
    VALUES (p_code, p_title, p_image, p_active, p_admin_id, p_admin_id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AddFood` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddFood`(
    IN p_code VARCHAR(20),
    IN p_title VARCHAR(150),
    IN p_desc TEXT,
    IN p_price DECIMAL(10,2),
    IN p_image VARCHAR(255),
    IN p_cat_id INT,
    IN p_active VARCHAR(10),
    IN p_admin_id INT
)
BEGIN
    INSERT INTO foods (food_code, title, description, price, image_name, category_id, active, created_by, updated_by)
    VALUES (p_code, p_title, p_desc, p_price, p_image, p_cat_id, p_active, p_admin_id, p_admin_id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AddOrderItem` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddOrderItem`(
    IN p_order_id INT,
    IN p_food_id INT,
    IN p_qty INT,
    IN p_price DECIMAL(10,2)
)
BEGIN
    INSERT INTO order_items (order_id, food_id, quantity, unit_price) 
    VALUES (p_order_id, p_food_id, p_qty, p_price);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `AddUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddUser`(
    IN p_first VARCHAR(50), 
    IN p_last VARCHAR(50), 
    IN p_user VARCHAR(100), 
    IN p_pass VARCHAR(255), 
    IN p_email VARCHAR(150), 
    IN p_role ENUM('Admin', 'Manager', 'Staff')
)
BEGIN
    INSERT INTO `user` (first_name, last_name, username, password, email, role)
    VALUES (p_first, p_last, p_user, p_pass, p_email, p_role);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `CreateNewOrder` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `CreateNewOrder`(
    IN p_order_number VARCHAR(255),
    IN p_customer_id INT,
    IN p_total DECIMAL(10,2),
    IN p_payment VARCHAR(50),
    IN p_address TEXT,
    IN p_phone VARCHAR(20),
    OUT p_order_id INT
)
BEGIN
    INSERT INTO orders (
        order_number, customer_id, total_amount, 
        status, payment_method, payment_status, 
        delivery_address, delivery_phone
    ) 
    VALUES (
        p_order_number, p_customer_id, p_total, 
        'Pending', p_payment, 'Pending', 
        p_address, p_phone
    );
    SET p_order_id = LAST_INSERT_ID();
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `DeleteCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteCategory`(IN p_id INT)
BEGIN
    DELETE FROM category WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetActiveFoods` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetActiveFoods`(IN p_category_id INT)
BEGIN
    IF p_category_id > 0 THEN
        SELECT * FROM foods WHERE category_id = p_category_id AND active = 'Yes';
    ELSE
        SELECT * FROM foods WHERE active = 'Yes';
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetAllActiveCategories` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllActiveCategories`()
BEGIN
    SELECT id, title FROM category WHERE active = 'Yes';
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetAllOrders` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllOrders`()
BEGIN
    SELECT * FROM `vw_order_master` ORDER BY created_at DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetAllUsers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllUsers`()
BEGIN
    SELECT id, first_name, last_name, username, email, role, created_at 
    FROM `user` ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetDashboardStats` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDashboardStats`()
BEGIN
    DECLARE cat_count INT DEFAULT 0;
    DECLARE food_count INT DEFAULT 0;
    DECLARE user_count INT DEFAULT 0;
    DECLARE total_revenue DECIMAL(10,2) DEFAULT 0.00;

    SELECT COUNT(*) INTO cat_count FROM category; 
    SELECT COUNT(*) INTO food_count FROM foods; 
    SELECT COUNT(*) INTO user_count FROM customers; 
    SELECT COALESCE(SUM(total_amount), 0) INTO total_revenue 
    FROM orders 
    WHERE status = 'Delivered';

    SELECT 
        cat_count AS categories, 
        food_count AS foods, 
        user_count AS users, 
        total_revenue AS revenue;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetFoodDetailsById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFoodDetailsById`(IN p_food_id INT)
BEGIN
    SELECT id, title, price, image_name FROM foods WHERE id = p_food_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetManageCategories` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetManageCategories`()
BEGIN
    SELECT * FROM category ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetManageFoods` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetManageFoods`()
BEGIN
    SELECT * FROM `vw_food_catalog` ORDER BY id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetOrderById` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOrderById`(IN p_order_id INT)
BEGIN
    SELECT * FROM `vw_order_master` WHERE id = p_order_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetOrderDetails` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOrderDetails`(IN p_id INT)
BEGIN
    SELECT o.*, c.first_name, c.last_name, c.email AS cust_email 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    WHERE o.id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetOrderItemsDetails` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetOrderItemsDetails`(IN p_order_id INT)
BEGIN
    SELECT oi.quantity, oi.unit_price, f.title 
    FROM order_items oi 
    JOIN foods f ON oi.food_id = f.id 
    WHERE oi.order_id = p_order_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetRecentOrders` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetRecentOrders`()
BEGIN
    SELECT id, order_number, status, total_amount, created_at 
    FROM orders 
    ORDER BY created_at DESC 
    LIMIT 10;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ResetUserPassword` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ResetUserPassword`(
    IN p_id INT,
    IN p_pass VARCHAR(255)
)
BEGIN
    UPDATE `user` SET password = p_pass WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_AuthenticateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_AuthenticateUser`(
    IN p_identifier VARCHAR(100)
)
BEGIN
    SELECT id, password, first_name, last_name, role, 'user' as account_origin 
    FROM `user` 
    WHERE username = p_identifier
    UNION ALL
    SELECT id, password, first_name, last_name, 'customer' as role, 'customer' as account_origin 
    FROM customers 
    WHERE email = p_identifier;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_CreateCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_CreateCustomer`(
    IN p_first_name VARCHAR(50),
    IN p_last_name VARCHAR(50),
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_address TEXT,
    IN p_city VARCHAR(50)
)
BEGIN
    INSERT INTO customers (first_name, last_name, email, password, phone, address, city)
    VALUES (p_first_name, p_last_name, p_email, p_password, p_phone, p_address, p_city);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_ResetPassword_Updated` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ResetPassword_Updated`(
    IN p_token VARCHAR(255),
    IN p_user_id INT,
    IN p_customer_id INT,
    IN p_new_password VARCHAR(255)
)
BEGIN
    -- Update the correct master table based on which ID is provided
    IF p_user_id IS NOT NULL THEN
        UPDATE `user` SET password = p_new_password WHERE id = p_user_id;
    ELSEIF p_customer_id IS NOT NULL THEN
        UPDATE customers SET password = p_new_password WHERE id = p_customer_id;
    END IF;
    
    -- Mark the token as used
    UPDATE password_resets SET used = 1 WHERE token = p_token;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `UpdateCategory` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateCategory`(
    IN p_id INT,
    IN p_title VARCHAR(100),
    IN p_image VARCHAR(255),
    IN p_active VARCHAR(10),
    IN p_admin_id INT
)
BEGIN
    UPDATE category SET 
        title = p_title, 
        image_name = p_image, 
        active = p_active, 
        updated_by = p_admin_id 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `UpdateFood` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateFood`(
    IN p_id INT,
    IN p_title VARCHAR(150),
    IN p_desc TEXT,
    IN p_price DECIMAL(10,2),
    IN p_image VARCHAR(255),
    IN p_cat_id INT,
    IN p_active VARCHAR(10),
    IN p_admin_id INT
)
BEGIN
    UPDATE foods SET 
        title = p_title, 
        description = p_desc, 
        price = p_price, 
        image_name = p_image, 
        category_id = p_cat_id, 
        active = p_active, 
        updated_by = p_admin_id 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `UpdateOrderStatus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateOrderStatus`(
    IN p_id INT,
    IN p_status VARCHAR(50),
    IN p_pay_status VARCHAR(50),
    IN p_admin_id INT
)
BEGIN
    UPDATE orders SET 
        status = p_status, 
        payment_status = p_pay_status, 
        updated_by = p_admin_id 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `UpdateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateUser`(
    IN p_id INT,
    IN p_first VARCHAR(50),
    IN p_last VARCHAR(50),
    IN p_user VARCHAR(100),
    IN p_email VARCHAR(150),
    IN p_role ENUM('Admin', 'Manager', 'Staff')
)
BEGIN
    UPDATE `user` SET 
        first_name = p_first, 
        last_name = p_last, 
        username = p_user, 
        email = p_email, 
        role = p_role 
    WHERE id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vw_food_catalog`
--

/*!50001 DROP VIEW IF EXISTS `vw_food_catalog`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_food_catalog` AS select `f`.`id` AS `id`,`f`.`food_code` AS `food_code`,`f`.`title` AS `title`,`f`.`description` AS `description`,`f`.`image_name` AS `image_name`,`f`.`price` AS `price`,`f`.`category_id` AS `category_id`,`f`.`active` AS `active`,`f`.`created_at` AS `created_at`,`f`.`updated_at` AS `updated_at`,`f`.`created_by` AS `created_by`,`f`.`updated_by` AS `updated_by`,`c`.`title` AS `category_name` from (`foods` `f` left join `category` `c` on((`f`.`category_id` = `c`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_order_master`
--

/*!50001 DROP VIEW IF EXISTS `vw_order_master`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_order_master` AS select `o`.`id` AS `id`,`o`.`order_number` AS `order_number`,`o`.`customer_id` AS `customer_id`,`o`.`status` AS `status`,`o`.`total_amount` AS `total_amount`,`o`.`delivery_address` AS `delivery_address`,`o`.`delivery_phone` AS `delivery_phone`,`o`.`payment_method` AS `payment_method`,`o`.`payment_status` AS `payment_status`,`o`.`created_at` AS `created_at`,`o`.`updated_at` AS `updated_at`,`o`.`updated_by` AS `updated_by`,concat(`c`.`first_name`,' ',`c`.`last_name`) AS `customer_full_name`,`c`.`email` AS `customer_email`,`c`.`phone` AS `customer_phone` from (`orders` `o` join `customers` `c` on((`o`.`customer_id` = `c`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-08 19:34:58
