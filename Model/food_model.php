<?php
class FoodModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("CALL GetManageFoods()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM foods WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getActiveCategories() {
        $stmt = $this->conn->prepare("SELECT id, title FROM category WHERE active = 'Yes'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("CALL AddFood(:code, :title, :desc, :price, :img, :cat, :act, :admin)");
        return $stmt->execute($data);
    }

    public function update($data) {
        $stmt = $this->conn->prepare("CALL UpdateFood(:id, :title, :desc, :price, :img, :cat, :act, :admin)");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM foods WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    
}