DELIMITER //

CREATE PROCEDURE GetFoodDetailsForCart(IN p_food_id INT)
BEGIN
    SELECT title, price, image_name 
    FROM foods 
    WHERE id = p_food_id;
END //

DELIMITER ;


==============================================================================================


