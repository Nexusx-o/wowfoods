<?php
class Post {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPosts() {
        $query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        return mysqli_query($this->conn, $query);
    }
}
?>