<?php
class CategoryModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("CALL GetManageCategories()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($code, $title, $image, $active, $admin_id) {
        $stmt = $this->conn->prepare("CALL AddCategory(:code, :title, :image, :active, :admin)");
        return $stmt->execute([
            ':code' => $code, ':title' => $title, ':image' => $image, ':active' => $active, ':admin' => $admin_id
        ]);
    }

    public function update($id, $title, $image, $active, $admin_id) {
        $stmt = $this->conn->prepare("CALL UpdateCategory(:id, :title, :image, :active, :admin)");
        return $stmt->execute([
            ':id' => $id, ':title' => $title, ':image' => $image, ':active' => $active, ':admin' => $admin_id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("CALL DeleteCategory(:id)");
        return $stmt->execute([':id' => $id]);
    }
}