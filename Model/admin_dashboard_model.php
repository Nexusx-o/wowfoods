<?php
class AdminDashboardModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Calls SP to get counts for Categories, Foods, Users, and Revenue
    public function getDashboardStats() {
        $stmt = $this->conn->prepare("CALL GetDashboardStats()");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Calls SP to get a list of recent orders
    public function getRecentOrders() {
        $stmt = $this->conn->prepare("CALL GetRecentOrders()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}