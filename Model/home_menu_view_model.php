<?php
class HomeMenuModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getting Categories
    public function getAllCategories() {
        try {
            $stmt = $this->conn->prepare("CALL GetAllActiveCategories()");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getAllCategories SP: " . $e->getMessage());
            return [];
        }
    }

    // Getting Foods
    public function getFoods($category_id = 0) {
        try {
            $stmt = $this->conn->prepare("CALL GetActiveFoods(?)");
            $stmt->execute([(int)$category_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getFoods SP: " . $e->getMessage());
            return [];
        }
    }

    // Getting food by ID
    public function getFoodById($id) {
        try {
            $stmt = $this->conn->prepare("CALL GetFoodDetailsById(?)");
            $stmt->execute([(int)$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getFoodById SP: " . $e->getMessage());
            return false;
        }
    }
}
?>