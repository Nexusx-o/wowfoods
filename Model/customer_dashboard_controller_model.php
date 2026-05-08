<?php
class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getOrdersByCustomerId($customer_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
            $stmt->execute([(int)$customer_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Order Fetch Error: " . $e->getMessage());
            return [];
        }
    }
}
?>