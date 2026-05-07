<?php
class HomeMenuModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Categories ලබා ගැනීම
    public function getAllCategories() {
        try {
            $stmt = $this->conn->prepare("CALL GetAllActiveCategories()");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor(); // වැදගත්: Connection එක නිදහස් කිරීමට
            return $result;
        } catch (PDOException $e) {
            error_log("Error in getAllCategories SP: " . $e->getMessage());
            return [];
        }
    }

    // Foods ලබා ගැනීම
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

    // ID එක අනුව කෑමක් ලබා ගැනීම
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