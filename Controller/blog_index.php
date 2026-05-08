<?php
// 1. Includes
require_once 'config/database.php';
require_once 'Model/blog_post.php';

// 2. Initialize Model
$database = new Database();
$db = $database->getConnection();
$postModel = new Post($db);

// 3. Get Data (Logic)
$posts = $postModel->getAllPosts();

// 4. Load View (Display)
include 'includes/blog_header.php';
include 'view/blog_view.php';
?>