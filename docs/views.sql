-- ======================================================================
-- 2. VIEWS: ABSTRACTION LAYER
-- ======================================================================

-- View for Food Items with Category names
CREATE OR REPLACE VIEW `vw_food_catalog` AS
SELECT f.*, c.title AS category_name
FROM `foods` f
LEFT JOIN `category` c ON f.category_id = c.id;

-- View for Orders with Customer Details
CREATE OR REPLACE VIEW `vw_order_master` AS
SELECT 
    o.*, 
    CONCAT(c.first_name, ' ', c.last_name) AS customer_full_name, 
    c.email AS customer_email,
    c.phone AS customer_phone
FROM `orders` o
JOIN `customers` c ON o.customer_id = c.id;

-- ======================================================================
-- 3. STORED PROCEDURES: USING VIEWS
-- ======================================================================

DELIMITER ;;

-- Get all foods using the View
CREATE OR REPLACE PROCEDURE `GetManageFoods`()
BEGIN
    SELECT * FROM `vw_food_catalog` ORDER BY id DESC;
END ;;

-- Get all orders using the View
CREATE OR REPLACE PROCEDURE `GetAllOrders`()
BEGIN
    SELECT * FROM `vw_order_master` ORDER BY created_at DESC;
END ;;

-- Get a single order detail using the View
CREATE OR REPLACE PROCEDURE `GetOrderById`(IN p_order_id INT)
BEGIN
    SELECT * FROM `vw_order_master` WHERE id = p_order_id;
END ;;

DELIMITER ;

CREATE OR REPLACE VIEW `vw_food_catalog` AS
SELECT 
    f.*, 
    c.title AS category_name  -- <--- This is the key your PHP must use
FROM `foods` f
LEFT JOIN `category` c ON f.category_id = c.id;

USE `food_order`;

-- Update the view to include separate first and last name columns
CREATE OR REPLACE VIEW `vw_order_master` AS
SELECT 
    o.*, 
    c.first_name, 
    c.last_name,
    CONCAT(c.first_name, ' ', c.last_name) AS customer_full_name, 
    c.email AS customer_email,
    c.phone AS customer_phone
FROM `orders` o
JOIN `customers` c ON o.customer_id = c.id;