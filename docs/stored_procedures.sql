DELIMITER //
CREATE PROCEDURE GetTestUser(IN id INT)
BEGIN
    SELECT 'John Doe' AS name, 'admin@example.com' AS email, 'Administrator' AS role;
END //
DELIMITER ;

DELIMITER //

DELIMITER //

DELIMITER //

CREATE PROCEDURE GetDashboardStats()
BEGIN
    DECLARE cat_count INT DEFAULT 0;
    DECLARE food_count INT DEFAULT 0;
    DECLARE user_count INT DEFAULT 0;
    DECLARE total_revenue DECIMAL(10,2) DEFAULT 0.00;

    -- Count Categories (from 'category' table)
    SELECT COUNT(*) INTO cat_count FROM category; 
    
    -- Count Foods (from 'foods' table)
    SELECT COUNT(*) INTO food_count FROM foods; 
    
    -- Count Customers (from 'customers' table)
    SELECT COUNT(*) INTO user_count FROM customers; 
    
    -- Calculate Revenue (Sums 'total_amount' from 'orders' table where delivered)
    -- Note: Change 'Delivered' to whatever exact text you use for completed orders!
    SELECT COALESCE(SUM(total_amount), 0) INTO total_revenue 
    FROM orders 
    WHERE status = 'Delivered';

    -- Return the final data as a single row so your PHP Model can fetch it
    SELECT 
        cat_count AS categories, 
        food_count AS foods, 
        user_count AS users, 
        total_revenue AS revenue;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetRecentOrders()
BEGIN
    -- Gets the 10 most recent orders using your table's columns
    SELECT id, order_number, status, total_amount, created_at 
    FROM orders 
    ORDER BY created_at DESC 
    LIMIT 10;
END //

DELIMITER ;

DELIMITER //

-- 1. USER PROCEDURES
-- -----------------------------------------------------
-- Add a new administrative user
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

-- Get all users for the Manage User page
CREATE PROCEDURE GetAllUsers()
BEGIN
    SELECT id, first_name, last_name, username, email, role, created_at 
    FROM `user` ORDER BY id DESC;
END //

-- 2. CATEGORY PROCEDURES
-- -----------------------------------------------------
-- Add a category with audit tracking
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

-- Get categories for management
CREATE PROCEDURE GetManageCategories()
BEGIN
    SELECT * FROM category ORDER BY id DESC;
END //

-- 3. FOOD PROCEDURES
-- -----------------------------------------------------
-- Add new food item
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

-- Get foods with their category titles (Using a JOIN inside the SP)
CREATE PROCEDURE GetManageFoods()
BEGIN
    SELECT f.*, c.title AS category_title 
    FROM foods f 
    LEFT JOIN category c ON f.category_id = c.id 
    ORDER BY f.id DESC;
END //

DELIMITER //


DELIMITER //

-- UPDATE CATEGORY
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

-- DELETE CATEGORY
CREATE PROCEDURE DeleteCategory(IN p_id INT)
BEGIN
    DELETE FROM category WHERE id = p_id;
END //

-- UPDATE ORDER STATUS
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

DELIMITER ;

DELIMITER //

-- 1. Get all foods with Category Titles for the Manage View
CREATE PROCEDURE GetManageFoods()
BEGIN
    SELECT f.*, c.title AS category_title 
    FROM foods f 
    LEFT JOIN category c ON f.category_id = c.id 
    ORDER BY f.id DESC;
END //

-- 2. Add new food
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

-- 3. Update existing food
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

DELIMITER ;

DELIMITER //

DELIMITER //

-- 1. Get all users for the management table
CREATE PROCEDURE GetAllUsers()
BEGIN
    SELECT id, first_name, last_name, username, email, role, created_at 
    FROM `user` 
    ORDER BY id DESC;
END //

-- 2. Add a new user
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

-- 3. Update existing user (without changing password)
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

DELIMITER ;

DELIMITER //

-- 1. Get all orders with Customer Name for the Manage View
CREATE PROCEDURE GetAllOrders()
BEGIN
    SELECT o.*, c.first_name, c.last_name 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    ORDER BY o.created_at DESC;
END //

-- 2. Get a single order with detailed customer info
CREATE PROCEDURE GetOrderDetails(IN p_id INT)
BEGIN
    SELECT o.*, c.first_name, c.last_name, c.email AS cust_email 
    FROM orders o 
    JOIN customers c ON o.customer_id = c.id 
    WHERE o.id = p_id;
END //

-- 3. Update Order and Payment Status
CREATE PROCEDURE UpdateOrder(
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

DELIMITER ;

