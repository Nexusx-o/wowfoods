<?php 
require_once '../config/init.php';
require_once '../model/home_menu_view_model.php';

// Creating a Database Object and Obtaining a Connection
$database = new Database(); 
$db = $database->getConnection();

// Making the model
$menuModel = new HomeMenuModel($db);


// LOGIC
// ADD TO CART LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['food_id'])) {
    $food_id = (int)$_POST['food_id'];
    $food = $menuModel->getFoodById($food_id);
    
    if ($food) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        
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
    header("Location: home_menu_view_controller.php" . (isset($_GET['cat_id']) ? "?cat_id=".$_GET['cat_id'] : ""));
    exit();
}

// DATA FETCHING
$category_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$categories = $menuModel->getAllCategories();
$foods = $menuModel->getFoods($category_id);

// LOADING THE VIEW
include __DIR__ . '/../view/home_menu_view.php'; 
?>