<?php

class CartModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

   
     // Retrieving food details using a stored procedure
     
    public function getFoodForCart($food_id) {
        try {
            // CALL the Stored Procedure
            $stmt = $this->db->prepare("CALL GetFoodDetailsForCart(?)");
            $stmt->execute([(int)$food_id]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
            $stmt->closeCursor(); 
            
            return $result;
        } catch (PDOException $e) {
            error_log("Stored Procedure Error: " . $e->getMessage());
            return false;
        }
    }

    // Calculating the total amount
    public function calculateGrandTotal($cart) {
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $total += ($item['price'] * $item['qty']);
            }
        }
        return $total;
    }
}
?>