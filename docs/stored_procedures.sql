DELIMITER //

CREATE PROCEDURE GetFoodDetailsForCart(IN p_food_id INT)
BEGIN
    SELECT title, price, image_name 
    FROM foods 
    WHERE id = p_food_id;
END //

DELIMITER ;


==============================================================================================


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
END //

DELIMITER ;



=======================================================================================

DELIMITER //

-- 1. සියලුම සක්‍රීය Categories ලබා ගැනීමට
CREATE PROCEDURE GetAllActiveCategories()
BEGIN
    SELECT id, title FROM category WHERE active = 'Yes';
END //

-- 2. Foods ලබා ගැනීමට (Category ID එක 0 නම් සියල්ල ලබා දේ)
CREATE PROCEDURE GetActiveFoods(IN p_category_id INT)
BEGIN
    IF p_category_id > 0 THEN
        SELECT * FROM foods WHERE category_id = p_category_id AND active = 'Yes';
    ELSE
        SELECT * FROM foods WHERE active = 'Yes';
    END IF;
END //

-- 3. ID එක අනුව කෑමක විස්තර ලබා ගැනීමට
CREATE PROCEDURE GetFoodDetailsById(IN p_food_id INT)
BEGIN
    SELECT id, title, price, image_name FROM foods WHERE id = p_food_id;
END //

DELIMITER ;


==============================================================================================================

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

    -- අලුතින් සෑදුණු ID එක ලබා ගැනීම
    SET p_order_id = LAST_INSERT_ID();
END //

-- 2. අයිතම ඇතුළත් කිරීම සඳහා තවත් Procedure එකක් (විකල්ප)
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