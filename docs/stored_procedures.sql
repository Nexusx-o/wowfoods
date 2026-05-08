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

-- Stored Procedure to Reset Password

CREATE PROCEDURE sp_ResetPassword(
    IN p_token VARCHAR(255),
    IN p_account_type VARCHAR(20),
    IN p_account_id INT,
    IN p_new_password VARCHAR(255)
)
BEGIN
    -- 1. Update the correct account table
    IF p_account_type = 'user' THEN
        UPDATE `user` SET password = p_new_password WHERE id = p_account_id;
    ELSE
        UPDATE customers SET password = p_new_password WHERE id = p_account_id;
    END IF;

    -- 2. Invalidate the token so it can't be used again
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


