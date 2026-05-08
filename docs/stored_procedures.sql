DELIMITER //

CREATE PROCEDURE GetFoodDetailsForCart(IN p_food_id INT)
BEGIN
    SELECT title, price, image_name 
    FROM foods 
    WHERE id = p_food_id;
END //

DELIMITER ;




DELIMITER //

CREATE PROCEDURE GetOrderItemsDetails(IN p_order_id INT)
BEGIN
    SELECT 
        oi.quantity, 
        oi.unit_price, 
        f.title 
    FROM 
        order_items oi 
    JOIN 
        foods f ON oi.food_id = f.id 
    WHERE 
        oi.order_id = p_order_id;
        


-- Stored Procedure to Create Customer Record

DELIMITER //

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

DELIMITER ;

DELIMITER //



-- To get all active categories
CREATE PROCEDURE GetAllActiveCategories()
BEGIN
    SELECT id, title FROM category WHERE active = 'Yes';
END //

--  To get Foods (if Category ID is 0 then all are given)

CREATE PROCEDURE GetActiveFoods(IN p_category_id INT)
BEGIN
    IF p_category_id > 0 THEN
        SELECT * FROM foods WHERE category_id = p_category_id AND active = 'Yes';
    ELSE
        SELECT * FROM foods WHERE active = 'Yes';
    END IF;
END //

-- To get details of a dish by ID
CREATE PROCEDURE GetFoodDetailsById(IN p_food_id INT)
BEGIN
    SELECT id, title, price, image_name FROM foods WHERE id = p_food_id;
END //

DELIMITER ;



DELIMITER //

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

    -- Getting the newly created ID
    SET p_order_id = LAST_INSERT_ID();
END //

--  Another procedure for entering items
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

DELIMITER ;
-- Stored Procedure to Reset Password

CREATE PROCEDURE sp_ResetPassword(
    IN p_token VARCHAR(255),
    IN p_account_type VARCHAR(20),
    IN p_account_id INT,
    IN p_new_password VARCHAR(255)
)
BEGIN
    --  Update the correct account table
    IF p_account_type = 'user' THEN
        UPDATE `user` SET password = p_new_password WHERE id = p_account_id;
    ELSE
        UPDATE customers SET password = p_new_password WHERE id = p_account_id;
    END IF;

    --  Invalidate the token so it can't be used again
    UPDATE password_resets SET used = 1 WHERE token = p_token;
END

-- Stored Procedure to Authenticate User or Customer

CREATE PROCEDURE sp_AuthenticateUser(
    IN p_identifier VARCHAR(100)
)
BEGIN
    -- Try to find in 'user' table first
    SELECT id, password, first_name, last_name, role, 'user' as account_origin 
    FROM `user` 
    WHERE username = p_identifier
    UNION ALL
    -- If not found, check 'customers' table
    SELECT id, password, first_name, last_name, 'customer' as role, 'customer' as account_origin 
    FROM customers 
    WHERE email = p_identifier;
END

DELIMITER //
CREATE PROCEDURE GetTestUser(IN id INT)
BEGIN
    SELECT 'John Doe' AS name, 'admin@example.com' AS email, 'Administrator' AS role;
END //
DELIMITER ;


