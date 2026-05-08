<?php
/**
 * CartModel - Handles data retrieval and calculations for the cart
 */
class CartModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * Stored Procedure එක භාවිතා කර කෑමේ විස්තර ලබා ගැනීම
     */
    public function getFoodForCart($food_id) {
        try {
            // Stored Procedure එක CALL කිරීම
            $stmt = $this->db->prepare("CALL GetFoodDetailsForCart(?)");
            $stmt->execute([(int)$food_id]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            /**
             * වැදගත්: සමහර විට Procedure එකක් පාවිච්චි කළ පසු තවත් Query එකක් 
             * එකම connection එකේ කිරීමට පෙර cursor එක close කළ යුතුයි.
             */
            $stmt->closeCursor(); 
            
            return $result;
        } catch (PDOException $e) {
            error_log("Stored Procedure Error: " . $e->getMessage());
            return false;
        }
    }

    // මුළු මුදල ගණනය කිරීම (මෙය PHP මගින් කිරීම වඩාත් කාර්යක්ෂමයි)
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