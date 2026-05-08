<?php
/**
 * MenuController - Handles user requests and connects Model with View
 */

// 1. පද්ධතිය ආරම්භ කිරීම සහ අවශ්‍ය Files සම්බන්ධ කිරීම
require_once __DIR__ . '/../includes/session.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/menu_view_controller_model.php';

// 2. Database සම්බන්ධතාවය සහ Model එක සූදානම් කිරීම
$database = new Database();
$db = $database->getConnection();
$menuModel = new MenuModel($db);

// --- APPLICATION LOGIC ---

// A. ADD TO CART LOGIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['food_id'])) {
    $food_id = (int)$_POST['food_id'];
    $food = $menuModel->getFoodById($food_id);
    
    if ($food) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // අයිතමය දැනටමත් තිබේ නම් ප්‍රමාණය වැඩි කරයි
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
        $cat_id = isset($_POST['current_cat']) ? (int)$_POST['current_cat'] : 0;
        header("Location: menu_view_controller.php" . ($cat_id > 0 ? "?cat_id=$cat_id" : ""));
        exit();
    }
    header("Location: menu_view_controller.php" . (isset($_GET['cat_id']) ? "?cat_id=".$_GET['cat_id'] : ""));
    exit();
}

// B. REMOVE FROM CART LOGIC
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: menu_view_controller.php");
    exit();
}

// C. FETCH DATA FOR VIEW
$category_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$categories = $menuModel->getAllCategories();
$foods = $menuModel->getFoods($category_id);

// 3. පෙනුම (View) ලෝඩ් කිරීම
include __DIR__ . '/../view/menu_view.php';
?>