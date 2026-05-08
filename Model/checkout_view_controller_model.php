<?php
/**
 * CheckoutModel - Handles data logic for the checkout process
 */
class CheckoutModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * කරත්තයේ ඇති අයිතමවල මුළු මුදල ගණනය කිරීම
     */
    public function calculateTotal($cart) {
        $total = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                $total += ($item['price'] * $item['qty']);
            }
        }
        return $total;
    }

    // ඉදිරියේදී ඇණවුම ඩේටාබේස් එකට ඇතුළත් කිරීමට මෙහි function එකක් ලියාගත හැක
    // public function placeOrder($customer_id, $total, $cart) { ... }
}
?>