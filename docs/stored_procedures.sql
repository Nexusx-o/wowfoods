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