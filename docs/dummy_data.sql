USE `food_order`;

-- 1. POPULATE USERS (Administrative Staff)
-- -----------------------------------------------------
INSERT INTO `user` (`first_name`, `last_name`, `username`, `password`, `email`, `role`) VALUES
('John', 'Admin', 'admin', '$2y$10$i5Q.oFz8P1Z.qA9G0G5WHeY8V.QzY6G1g6f5e4d3c2b1a', 'admin@restaurant.com', 'Admin'),
('Jane', 'Manager', 'jane_m', '$2y$10$i5Q.oFz8P1Z.qA9G0G5WHeY8V.QzY6G1g6f5e4d3c2b1a', 'jane@restaurant.com', 'Manager'),
('Robert', 'Staff', 'robert_s', '$2y$10$i5Q.oFz8P1Z.qA9G0G5WHeY8V.QzY6G1g6f5e4d3c2b1a', 'robert@restaurant.com', 'Staff');

-- 2. POPULATE CATEGORIES
-- -----------------------------------------------------
-- Assumes User ID 1 is the creator
INSERT INTO `category` (`category_code`, `title`, `image_name`, `active`, `created_by`) VALUES
('CAT001', 'Italian Pizza', 'pizza.jpg', 'Yes', 1),
('CAT002', 'Gourmet Burgers', 'burger.jpg', 'Yes', 1),
('CAT003', 'Fresh Salads', 'salad.jpg', 'Yes', 1),
('CAT004', 'Beverages', 'drinks.jpg', 'Yes', 1),
('CAT005', 'Desserts', 'dessert.jpg', 'No', 1);

-- 3. POPULATE CUSTOMERS
-- -----------------------------------------------------
INSERT INTO `customers` (`first_name`, `last_name`, `email`, `password`, `phone`, `address`, `city`, `created_by`) VALUES
('Alice', 'Smith', 'alice@gmail.com', 'pass123', '555-0101', '123 Maple St', 'New York', 1),
('Bob', 'Johnson', 'bob@yahoo.com', 'pass456', '555-0102', '456 Oak Avenue', 'Chicago', 1),
('Charlie', 'Brown', 'charlie@outlook.com', 'pass789', '555-0103', '789 Pine Lane', 'Los Angeles', 1);

-- 4. POPULATE FOODS
-- -----------------------------------------------------
-- References: CAT001=1, CAT002=2, CAT003=3, CAT004=4
INSERT INTO `foods` (`food_code`, `title`, `description`, `price`, `category_id`, `active`, `created_by`) VALUES
('F001', 'Margherita Pizza', 'Classic tomato, mozzarella, and basil', 12.99, 1, 'Yes', 1),
('F002', 'Pepperoni Feast', 'Double pepperoni with extra cheese', 15.50, 1, 'Yes', 1),
('F003', 'Classic Cheeseburger', 'Angus beef patty with cheddar cheese', 9.99, 2, 'Yes', 1),
('F004', 'Bacon BBQ Burger', 'Beef patty, crispy bacon, and BBQ sauce', 11.50, 2, 'Yes', 1),
('F005', 'Caesar Salad', 'Romaine lettuce with Caesar dressing', 8.50, 3, 'Yes', 1),
('F006', 'Iced Lemon Tea', 'Freshly brewed tea with lemon', 3.50, 4, 'Yes', 1),
('F007', 'Coca Cola', 'Chilled 500ml bottle', 2.50, 4, 'Yes', 1);

-- 5. POPULATE ORDERS
-- -----------------------------------------------------
-- Note: total_amount should match the sum of items added later
INSERT INTO `orders` (`order_number`, `customer_id`, `status`, `total_amount`, `delivery_address`, `delivery_phone`, `payment_method`, `payment_status`) VALUES
('ORD-2023-001', 1, 'Delivered', 25.48, '123 Maple St, New York', '555-0101', 'Card', 'Paid'),
('ORD-2023-002', 2, 'Pending', 11.50, '456 Oak Avenue, Chicago', '555-0102', 'Cash', 'Pending'),
('ORD-2023-003', 3, 'Processing', 21.49, '789 Pine Lane, Los Angeles', '555-0103', 'Online', 'Paid');

-- 6. POPULATE ORDER ITEMS
-- -----------------------------------------------------
-- Order 1: 1 Margherita (12.99) + 1 Pepperoni (15.50) (Note: Schema handles subtotal)
INSERT INTO `order_items` (`order_id`, `food_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 12.99),
(1, 2, 1, 15.50),
-- Order 2: 1 Bacon BBQ Burger
(2, 4, 1, 11.50),
-- Order 3: 1 Caesar Salad (8.50) + 1 Margherita (12.99)
(3, 5, 1, 8.50),
(3, 1, 1, 12.99);

-- 7. POPULATE AUDIT LOG (Sample Entry)
-- -----------------------------------------------------
INSERT INTO `audit_log` (`table_name`, `action_type`, `record_id`, `new_values`, `changed_by`) VALUES
('foods', 'INSERT', 1, '{"title": "Margherita Pizza", "price": 12.99}', 1);

-- 8. POPULATE PASSWORD RESETS (Sample Entry)
-- -----------------------------------------------------
INSERT INTO `password_resets` (`account_type`, `account_id`, `token`, `expires_at`) VALUES
('customer', 1, 'abc123token789xyz', DATE_ADD(NOW(), INTERVAL 1 HOUR));

UPDATE `user` 
SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE `username` = 'admin';

UPDATE `customers` 
SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE `email` = 'alice@gmail.com';