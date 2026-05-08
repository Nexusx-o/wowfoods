<?php
/**
 * MenuModel - Database interactions for Foods and Categories
 */
class MenuModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // සියලුම සක්‍රීය Categories ලබා ගැනීම
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT id, title FROM category WHERE active='Yes'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Category එක අනුව හෝ සියලුම කෑම වර්ග ලබා ගැනීම
    public function getFoods($category_id = 0) {
        if ($category_id > 0) {
            $stmt = $this->db->prepare("SELECT * FROM foods WHERE category_id = ? AND active = 'Yes'");
            $stmt->execute([$category_id]);
        } else {
            $stmt = $this->db->query("SELECT * FROM foods WHERE active = 'Yes'");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // නිශ්චිත කෑමක විස්තර ලබා ගැනීම (Cart එක සඳහා)
    public function getFoodById($id) {
        $stmt = $this->db->prepare("SELECT id, title, price, image_name FROM foods WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>