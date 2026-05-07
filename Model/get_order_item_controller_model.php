<?php
/**
 * OrderModel - Handles order data
 */
class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * Order ID එක අනුව අදාළ කෑම වර්ග සහ ප්‍රමාණයන් ලබා ගැනීම
     */
    public function getOrderItems($order_id) {
        try {
            $sql = "SELECT oi.quantity, oi.unit_price, f.title 
                    FROM order_items oi 
                    JOIN foods f ON oi.food_id = f.id 
                    WHERE oi.order_id = :order_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['order_id' => (int)$order_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Fetch Items Error: " . $e->getMessage());
            return false;
        }
    }
}
?>