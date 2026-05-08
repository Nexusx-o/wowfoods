<?php
class Post {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getAll() {
        $query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $query);
        return $result;
    }
}
?>