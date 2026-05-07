<?php
class HomeMenuModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Categories ලබා ගැනීම
    public function getAllCategories() {
        $stmt = $this->conn->prepare("SELECT id, title FROM category WHERE active='Yes'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Foods ලබා ගැනීම
    public function getFoods($category_id = 0) {
        if ($category_id > 0) {
            $stmt = $this->conn->prepare("SELECT * FROM foods WHERE category_id = ? AND active = 'Yes'");
            $stmt->execute([$category_id]);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM foods WHERE active = 'Yes'");
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFoodById($id) {
        $stmt = $this->conn->prepare("SELECT id, title, price, image_name FROM foods WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>