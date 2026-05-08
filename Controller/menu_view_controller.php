<?php

require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../Model/menu_view_controller_model.php';

// Preparing the Database Connection and Model
$database = new Database();
$db = $database->getConnection();
$menuModel = new MenuModel($db);



// LOGIC 

//  ADD TO CART LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['food_id'])) {
    $food_id = (int)$_POST['food_id'];
    $food = $menuModel->getFoodById($food_id);
    
    if ($food) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Increases quantity if item already exists
        if (isset($_SESSION['cart'][$food_id])) {
            $_SESSION['cart'][$food_id]['qty']++;
        } else {
            $_SESSION['cart'][$food_id] = [
                'title' => $food['title'],
                'price' => $food['price'],
                'image' => $food['image_name'],
                'qty' => 1
            ];
        }
    }
    header("Location: menu_view_controller.php" . (isset($_GET['cat_id']) ? "?cat_id=".$_GET['cat_id'] : ""));
    exit();
}

// REMOVE FROM CART LOGIC
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: menu_view_controller.php");
    exit();
}

// FETCH DATA FOR VIEW
$category_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$categories = $menuModel->getAllCategories();
$foods = $menuModel->getFoods($category_id);


include __DIR__ . '/../view/menu_view.php';
?>