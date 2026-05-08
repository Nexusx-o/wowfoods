<?php
// 1. Load the database and the model
require_once 'config/database.php';
require_once 'models/Post.php';

// 2. Connect to Database
$db_obj = new Database();
$db = $db_obj->getConnection();

// 3. Ask the Model for Data
$postModel = new Post($db);
$posts = $postModel->getAll();

// 4. Send the Data to the View
include 'includes/blog_header.php';
include 'views/blog_view.php';
?>