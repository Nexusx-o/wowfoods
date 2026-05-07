<?php
/**
 * CartModel - Handles data retrieval and calculations for the cart
 */
class CartModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Food ID එක අනුව විස්තර ලබා ගැනීම
    public function getFoodForCart($food_id) {
        $stmt = $this->db->prepare("SELECT title, price, image_name FROM foods WHERE id = ?");
        $stmt->execute([(int)$food_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // මුළු මුදල ගණනය කිරීම
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