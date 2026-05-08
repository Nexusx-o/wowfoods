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
     * Stored Procedure එක භාවිතා කර Order Items ලබා ගැනීම
     */
    public function getOrderItems($order_id) {
        try {
            // Stored Procedure එක CALL කිරීම
            $sql = "CALL GetOrderItemsDetails(:order_id)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['order_id' => (int)$order_id]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Cursor එක close කිරීම අනිවාර්ය වේ (පසුකාලීන Queries වල දෝෂ මඟහැරීමට)
            $stmt->closeCursor();

            return $result;
            
        } catch (PDOException $e) {
            error_log("Stored Procedure Fetch Items Error: " . $e->getMessage());
            return false;
        }
    }
}
?>