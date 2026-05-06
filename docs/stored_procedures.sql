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