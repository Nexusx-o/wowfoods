<?php

class CheckoutModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    
     // Calculating the total amount of items in the cart 
    public function calculateTotal($cart) {
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