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