<?php
class TestModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserData($id) {
        $stmt = $this->conn->prepare("CALL GetTestUser(:id)");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}