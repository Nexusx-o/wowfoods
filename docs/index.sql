USE `food_order`;

-- ==========================================
-- 1. AUDIT LOG OPTIMIZATION
-- ==========================================
-- Speeds up viewing history for a specific staff member
CREATE INDEX idx_audit_user_id ON audit_log(user_id);

-- Speeds up viewing history for a specific customer
CREATE INDEX idx_audit_customer_id ON audit_log(customer_id);

-- Speeds up viewing all changes made to a specific table/record
CREATE INDEX idx_audit_table_record ON audit_log(table_name, record_id);


-- ==========================================
-- 2. PASSWORD RESET OPTIMIZATION
-- ==========================================
-- Optimized for the refactored password_resets table to handle token lookups and expirations
CREATE INDEX idx_password_resets_token_lookup ON password_resets(token, expires_at);

-- Speeds up finding reset history for specific users/customers
CREATE INDEX idx_password_resets_user ON password_resets(user_id);
CREATE INDEX idx_password_resets_customer ON password_resets(customer_id);


-- ==========================================
-- 3. ORDERS & REPORTING OPTIMIZATION
-- ==========================================
-- Speeds up "Recent Orders" and date-based financial reports
CREATE INDEX idx_orders_created_at ON orders(created_at);

-- Composite index to speed up filtering by both status and payment (common in dashboards)
CREATE INDEX idx_orders_status_payment ON orders(status, payment_status);


-- ==========================================
-- 4. SEARCH & CATALOG OPTIMIZATION
-- ==========================================
-- Helps the vw_food_catalog view when joining and ordering by category
CREATE INDEX idx_foods_category_active ON foods(category_id, active);

-- Full-Text search index for food items (Requires MyISAM or InnoDB 5.6+)
-- Allows efficient searching like: WHERE MATCH(title, description) AGAINST('pizza')
CREATE FULLTEXT INDEX idx_food_search ON foods(title, description);


-- ==========================================
-- 5. MAINTENANCE & CLEANUP
-- ==========================================
-- If these indexes already exist from previous attempts, you can use the following 
-- logic to check before creation (MySQL 8.0.12+):
/*
ALTER TABLE orders ADD INDEX idx_orders_created_at (created_at) ALGORITHM=INPLACE LOCK=NONE;
*/