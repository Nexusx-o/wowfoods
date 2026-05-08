USE `food_order`;

-- 1. REFACTOR AUDIT LOG TABLE (Handling previous errors)
-- We add the new columns and constraints. 
-- If you get an error saying they already exist, you can skip to the triggers.
ALTER TABLE `audit_log` 
    ADD COLUMN IF NOT EXISTS `user_id` INT NULL AFTER `new_values`,
    ADD COLUMN IF NOT EXISTS `customer_id` INT NULL AFTER `user_id`,
    ADD CONSTRAINT `fk_audit_staff` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
    ADD CONSTRAINT `fk_audit_cust` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

-- Remove the old polymorphic column if it still exists
SET @exists = (SELECT 1 FROM information_schema.columns WHERE table_name='audit_log' AND column_name='changed_by' AND table_schema='food_order');
SET @s = IF(@exists=1, 'ALTER TABLE audit_log DROP COLUMN changed_by', 'SELECT "Column changed_by already removed"');
PREPARE stmt FROM @s; EXECUTE stmt; DEALLOCATE PREPARE stmt;

DELIMITER //

-- ==========================================
-- 2. TRIGGERS FOR TABLE: user (Staff Management)
-- ==========================================
CREATE TRIGGER trg_user_insert AFTER INSERT ON `user` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, new_values, user_id)
    VALUES ('user', 'INSERT', NEW.id, JSON_OBJECT('user', NEW.username, 'role', NEW.role, 'email', NEW.email), @current_user_id);
END//

CREATE TRIGGER trg_user_update AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, new_values, user_id)
    VALUES ('user', 'UPDATE', NEW.id, 
        JSON_OBJECT('role', OLD.role, 'email', OLD.email), 
        JSON_OBJECT('role', NEW.role, 'email', NEW.email), @current_user_id);
END//

-- ==========================================
-- 3. TRIGGERS FOR TABLE: customers
-- ==========================================
CREATE TRIGGER trg_cust_insert AFTER INSERT ON `customers` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, new_values, customer_id)
    VALUES ('customers', 'INSERT', NEW.id, JSON_OBJECT('email', NEW.email, 'city', NEW.city), NEW.id);
END//

CREATE TRIGGER trg_cust_update AFTER UPDATE ON `customers` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, new_values, user_id, customer_id)
    VALUES ('customers', 'UPDATE', NEW.id, 
        JSON_OBJECT('phone', OLD.phone, 'address', OLD.address), 
        JSON_OBJECT('phone', NEW.phone, 'address', NEW.address), 
        IF(@current_user_type = 'staff', @current_user_id, NULL), IF(@current_user_type = 'customer', @current_user_id, NULL));
END//

-- ==========================================
-- 4. TRIGGERS FOR TABLE: category
-- ==========================================
CREATE TRIGGER trg_cat_insert AFTER INSERT ON `category` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, new_values, user_id)
    VALUES ('category', 'INSERT', NEW.id, JSON_OBJECT('code', NEW.category_code, 'title', NEW.title), @current_user_id);
END//

CREATE TRIGGER trg_cat_update AFTER UPDATE ON `category` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, new_values, user_id)
    VALUES ('category', 'UPDATE', NEW.id, 
        JSON_OBJECT('title', OLD.title, 'active', OLD.active), 
        JSON_OBJECT('title', NEW.title, 'active', NEW.active), @current_user_id);
END//

-- ==========================================
-- 5. TRIGGERS FOR TABLE: foods
-- ==========================================
CREATE TRIGGER trg_food_insert AFTER INSERT ON `foods` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, new_values, user_id)
    VALUES ('foods', 'INSERT', NEW.id, JSON_OBJECT('code', NEW.food_code, 'title', NEW.title, 'price', NEW.price), @current_user_id);
END//

CREATE TRIGGER trg_food_update AFTER UPDATE ON `foods` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, new_values, user_id)
    VALUES ('foods', 'UPDATE', NEW.id, 
        JSON_OBJECT('price', OLD.price, 'active', OLD.active), 
        JSON_OBJECT('price', NEW.price, 'active', NEW.active), @current_user_id);
END//

-- ==========================================
-- 6. TRIGGERS FOR TABLE: orders
-- ==========================================
CREATE TRIGGER trg_order_insert AFTER INSERT ON `orders` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, new_values, customer_id)
    VALUES ('orders', 'INSERT', NEW.id, JSON_OBJECT('order_no', NEW.order_number, 'total', NEW.total_amount), NEW.customer_id);
END//

CREATE TRIGGER trg_order_update AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, new_values, user_id, customer_id)
    VALUES ('orders', 'UPDATE', NEW.id, 
        JSON_OBJECT('status', OLD.status, 'pay_status', OLD.payment_status), 
        JSON_OBJECT('status', NEW.status, 'pay_status', NEW.payment_status), 
        IF(@current_user_type = 'staff', @current_user_id, NULL), IF(@current_user_type = 'customer', @current_user_id, NULL));
END//

-- ==========================================
-- 7. GLOBAL DELETE TRIGGERS (Security/Cleanup)
-- ==========================================
CREATE TRIGGER trg_user_delete AFTER DELETE ON `user` FOR EACH ROW 
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, user_id) 
    VALUES ('user', 'DELETE', OLD.id, JSON_OBJECT('user', OLD.username), @current_user_id); //

CREATE TRIGGER trg_food_delete AFTER DELETE ON `foods` FOR EACH ROW 
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, user_id) 
    VALUES ('foods', 'DELETE', OLD.id, JSON_OBJECT('title', OLD.title), @current_user_id); //

CREATE TRIGGER trg_order_delete AFTER DELETE ON `orders` FOR EACH ROW 
    INSERT INTO audit_log (table_name, action_type, record_id, old_values, user_id) 
    VALUES ('orders', 'DELETE', OLD.id, JSON_OBJECT('order_no', OLD.order_number), @current_user_id); //

DELIMITER ;