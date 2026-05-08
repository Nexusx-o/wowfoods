-- -----------------------------------------------------
-- Schema food_order
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `food_order`;
CREATE SCHEMA IF NOT EXISTS `food_order` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `food_order`;

-- -----------------------------------------------------
-- Table: user
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) NULL,
  `role` ENUM('Admin', 'Manager', 'Staff') NOT NULL DEFAULT 'Staff',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: audit_log
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `table_name` VARCHAR(50) NOT NULL,
  `action_type` ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
  `record_id` INT NOT NULL,
  `old_values` JSON NULL,
  `new_values` JSON NULL,
  `changed_by` INT NULL,
  `changed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_audit_user` FOREIGN KEY (`changed_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: category
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_code` VARCHAR(10) NOT NULL UNIQUE,
  `title` VARCHAR(100) NOT NULL,
  `image_name` VARCHAR(255),
  `active` ENUM('Yes', 'No') DEFAULT 'Yes',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_cat_active` (`active`),
  CONSTRAINT `fk_cat_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cat_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: customers (Updated with Password after Email)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Positioned per migration
  `phone` VARCHAR(20) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `city` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_cust_email` (`email`),
  INDEX `idx_cust_phone` (`phone`),
  CONSTRAINT `fk_cust_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cust_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: password_resets (Newly Created)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `account_type` ENUM('user','customer') NOT NULL,
  `account_id` INT NOT NULL,
  `token` VARCHAR(64) NOT NULL UNIQUE,
  `expires_at` DATETIME NOT NULL,
  `used` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_password_resets_account` (`account_type`, `account_id`),
  INDEX `idx_password_resets_token` (`token`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: foods (Updated with image_name after description)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `foods` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `food_code` VARCHAR(10) NOT NULL UNIQUE,
  `title` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `image_name` VARCHAR(255) NULL, -- Positioned per migration
  `price` DECIMAL(10,2) NOT NULL,
  `category_id` INT NOT NULL,
  `active` ENUM('Yes', 'No') DEFAULT 'Yes',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` INT NULL,
  `updated_by` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_food_price` CHECK (price > 0),
  CONSTRAINT `fk_food_cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_food_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_food_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  INDEX `idx_food_active` (`active`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: orders
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(20) NOT NULL UNIQUE,
  `customer_id` INT NOT NULL,
  `status` ENUM('Pending', 'Confirmed', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled') DEFAULT 'Pending',
  `total_amount` DECIMAL(10,2) NOT NULL,
  `delivery_address` VARCHAR(255) NOT NULL,
  `delivery_phone` VARCHAR(20) NOT NULL,
  `payment_method` ENUM('Cash', 'Card', 'Online') DEFAULT 'Cash',
  `payment_status` ENUM('Pending', 'Paid', 'Failed') DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_order_total` CHECK (total_amount >= 0),
  CONSTRAINT `fk_order_cust` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `fk_order_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  INDEX `idx_order_status` (`status`),
  INDEX `idx_order_date` (`created_at`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table: order_items
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `food_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `subtotal` DECIMAL(10,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
  PRIMARY KEY (`id`),
  CONSTRAINT `chk_item_qty` CHECK (quantity > 0),
  CONSTRAINT `chk_item_price` CHECK (unit_price > 0),
  CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_item_food` FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`)
) ENGINE = InnoDB;

ALTER TABLE `orders` MODIFY COLUMN `status` VARCHAR(50) DEFAULT 'Ordered';
