USE `food_order`;

DELIMITER //

-- 1. AUTHENTICATION & ACCOUNT PROCEDURES
-- -----------------------------------------------------

-- Combined Authentication for both Admin Users and Customers
CREATE PROCEDURE sp_AuthenticateUser(
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
END //

-- Reset Password (Used by both account types via token system)
CREATE PROCEDURE sp_ResetPassword(
    IN p_token VARCHAR(255),
    IN p_account_type VARCHAR(20),
    IN p_account_id INT,
    IN p_new_password VARCHAR(255)
)
BEGIN
    IF p_account_type = 'user' THEN
        UPDATE `user` SET password = p_new_password WHERE id = p_account_id;
    ELSE
        UPDATE customers SET password = p_new_password WHERE id = p_account_id;
    END IF;
    
    UPDATE password_resets SET used = 1 WHERE token = p_token;
END //

-- Direct Admin Reset (Management Page)
CREATE PROCEDURE ResetUserPassword(
    IN p_id INT,
    IN p_pass VARCHAR(255)
)
BEGIN
    UPDATE `user` SET password = p_pass WHERE id = p_id;
END //


-- 2. USER MANAGEMENT (Admin)
-- -----------------------------------------------------

CREATE PROCEDURE AddUser(
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
END //

CREATE PROCEDURE GetAllUsers()
BEGIN
    SELECT id, first_name, last_name, username, email, role, created_at 
    FROM `user` ORDER BY id DESC;
END //

CREATE PROCEDURE UpdateUser(
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
END //


-- 3. CATEGORY PROCEDURES
-- -----------------------------------------------------

CREATE PROCEDURE AddCategory(
    IN p_code VARCHAR(20),
    IN p_title VARCHAR(100),
    IN p_image VARCHAR(255),
    IN p_active VARCHAR(10),
    IN p_admin_id INT
)
BEGIN
    INSERT INTO category (category_code, title, image_name, active, created_by, updated_by)
    VALUES (p_code, p_title, p_image, p_active, p_admin_id, p_admin_id);
END //

CREATE PROCEDURE GetManageCategories()
BEGIN
    SELECT * FROM category ORDER BY id DESC;
END //

CREATE PROCEDURE GetAllActiveCategories()
BEGIN
    SELECT id, title FROM category WHERE active = 'Yes';
END //

CREATE PROCEDURE UpdateCategory(
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
END //

CREATE PROCEDURE DeleteCategory(IN p_id INT)
BEGIN
    DELETE FROM category WHERE id = p_id;
END //


-- 4. FOOD PROCEDURES
-- -----------------------------------------------------

CREATE PROCEDURE AddFood(
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
END //

CREATE PROCEDURE UpdateFood(
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
END //

CREATE PROCEDURE GetManageFoods()
BEGIN
    SELECT f.*, c.title AS category_title 
    FROM foods f 
    LEFT JOIN category c ON f.category_id = c.id 
    ORDER BY f.id DESC;
END //

CREATE PROCEDURE GetActiveFoods(IN p_category_id INT)
BEGIN
    IF p_category_id > 0 THEN
        SELECT * FROM foods WHERE category_id = p_category_id AND active = 'Yes';
    ELSE
        SELECT * FROM foods WHERE active = 'Yes';
    END IF;
END //

CREATE PROCEDURE GetFoodDetailsById(IN p_food_id INT)
BEGIN
    SELECT id, title, price, image_name FROM foods WHERE id = p_food_id;
END //


-- 5. CUSTOMER & ORDER PROCEDURES
-- -----------------------------------------------------

CREATE PROCEDURE sp_CreateCustomer(
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
END //

CREATE PROCEDURE CreateNewOrder(
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
END //

CREATE PROCEDURE AddOrderItem(
    IN p_order_id INT,
    IN p_food_id INT,
    IN p_qty INT,
    IN p_price DECIMAL(10,2)
)
BEGIN
    INSERT INTO order_items (order_id, food_id, quantity, unit_price) 
    VALUES (p_order_id, p_food_id, p_qty, p_price);
END //

CREATE PROCEDURE GetAllOrders()
BEGIN
    SELECT o.*, c.first_name, c.last_name 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    ORDER BY o.created_at DESC;
END //

CREATE PROCEDURE GetOrderDetails(IN p_id INT)
BEGIN
    SELECT o.*, c.first_name, c.last_name, c.email AS cust_email 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    WHERE o.id = p_id;
END //

CREATE PROCEDURE GetOrderItemsDetails(IN p_order_id INT)
BEGIN
    SELECT oi.quantity, oi.unit_price, f.title 
    FROM order_items oi 
    JOIN foods f ON oi.food_id = f.id 
    WHERE oi.order_id = p_order_id;
END //

CREATE PROCEDURE UpdateOrderStatus(
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
END //


-- 6. DASHBOARD & STATS
-- -----------------------------------------------------

CREATE PROCEDURE GetDashboardStats()
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
END //

CREATE PROCEDURE GetRecentOrders()
BEGIN
    SELECT id, order_number, status, total_amount, created_at 
    FROM orders 
    ORDER BY created_at DESC 
    LIMIT 10;
END //

DELIMITER ;