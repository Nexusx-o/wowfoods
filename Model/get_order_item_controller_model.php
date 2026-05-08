<?php

class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    
     // Retrieving Order Items using a Stored Procedure
     
    public function getOrderItems($order_id) {
        try {
            // CALL the Stored Procedure
            $sql = "CALL GetOrderItemsDetails(:order_id)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['order_id' => (int)$order_id]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt->closeCursor();

            return $result;
            
        } catch (PDOException $e) {
            error_log("Stored Procedure Fetch Items Error: " . $e->getMessage());
            return false;
        }
    }
}
?>