<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("CALL GetAllOrders()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("CALL GetOrderDetails(:id)");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $status, $pay_status, $admin_id) {
        $stmt = $this->conn->prepare("CALL UpdateOrderStatus(:id, :status, :pay, :admin)");
        return $stmt->execute([
            ':id'     => $id,
            ':status' => $status,
            ':pay'    => $pay_status,
            ':admin'  => $admin_id
        ]);
    }
}