<?php
/**
 * OrderModel - Handles order placement logic
 */
class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * ඇණවුම ඩේටාබේස් එකේ තැන්පත් කිරීම
     */
    public function placeOrder($orderData, $cartItems) {
        try {
            $this->db->beginTransaction();

            // 1. Orders වගුවට ඇතුළත් කිරීම
            $sql_order = "INSERT INTO orders (order_number, customer_id, total_amount, status, payment_method, payment_status, delivery_address, delivery_phone) 
                          VALUES (:order_number, :customer_id, :total, 'Pending', :payment, 'Pending', :address, :phone)";
            
            $stmt_order = $this->db->prepare($sql_order);
            $stmt_order->execute([
                ':order_number' => $orderData['order_number'],
                ':customer_id'  => $orderData['customer_id'],
                ':total'        => $orderData['total'],
                ':payment'      => $orderData['payment'],
                ':address'      => $orderData['address'],
                ':phone'        => $orderData['phone']
            ]);

            $order_id = $this->db->lastInsertId();

            // 2. Order Items වගුවට ඇතුළත් කිරීම
            $sql_items = "INSERT INTO order_items (order_id, food_id, quantity, unit_price) 
                          VALUES (:order_id, :food_id, :qty, :unit_price)";
            $stmt_items = $this->db->prepare($sql_items);

            foreach ($cartItems as $food_id => $item) {
                $stmt_items->execute([
                    ':order_id'   => $order_id,
                    ':food_id'    => $food_id,
                    ':qty'        => $item['qty'],
                    ':unit_price' => $item['price']
                ]);
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Order Process Error: " . $e->getMessage());
            return false;
        }
    }
}
?>