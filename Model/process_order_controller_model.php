<?php

class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function placeOrder($orderData, $cartItems) {
        try {
            $this->db->beginTransaction();

            //  Enter the main order and get the ID
            $sql_order = "CALL CreateNewOrder(:order_number, :customer_id, :total, :payment, :address, :phone, @order_id)";
            $stmt_order = $this->db->prepare($sql_order);
            $stmt_order->execute([
                ':order_number' => $orderData['order_number'],
                ':customer_id'  => $orderData['customer_id'],
                ':total'        => $orderData['total'],
                ':payment'      => $orderData['payment'],
                ':address'      => $orderData['address'],
                ':phone'        => $orderData['phone']
            ]);
            $stmt_order->closeCursor();

            // Getting the @order_id via SQL
            $order_id = $this->db->query("SELECT @order_id AS id")->fetch(PDO::FETCH_ASSOC)['id'];

            // Adding items to cart
            $stmt_items = $this->db->prepare("CALL AddOrderItem(:order_id, :food_id, :qty, :unit_price)");

            foreach ($cartItems as $food_id => $item) {
                $stmt_items->execute([
                    ':order_id'   => $order_id,
                    ':food_id'    => $food_id,
                    ':qty'        => $item['qty'],
                    ':unit_price' => $item['price']
                ]);
                $stmt_items->closeCursor(); // Close the cursor inside the loop
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Order Process SP Error: " . $e->getMessage());
            return false;
        }
    }
}
?>