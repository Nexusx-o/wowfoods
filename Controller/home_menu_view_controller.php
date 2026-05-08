<?php
/**
 * WOWFOOD - Home Menu View Controller
 */

// 1. පද්ධතිය ආරම්භ කිරීම සහ අවශ්‍ය Files සම්බන්ධ කිරීම
// init.php හරහා session start වේ.
//require_once __DIR__ . '/../config/init.php'; 

// 2. Database Class එක සහ Model එක කෙලින්ම සම්බන්ධ කිරීම (Error එක වැළැක්වීමට)
//require_once __DIR__ . '/../config/database.php'; 
//require_once __DIR__ . '/../Model/home_menu_view_model.php'; 
require_once '../config/init.php';
require_once '../model/home_menu_view_model.php';
// 3. Database Object එකක් සාදා Connection එක ලබා ගැනීම
// දැන් Class 'Database' not found error එක එන්නේ නැත.
$database = new Database(); 
$db = $database->getConnection();

// 4. Model එක සෑදීම
$menuModel = new HomeMenuModel($db);

// --- APPLICATION LOGIC ---

// A. ADD TO CART LOGIC
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

// B. DATA FETCHING (දත්ත ලබා ගැනීම)
$category_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;
$categories = $menuModel->getAllCategories();
$foods = $menuModel->getFoods($category_id);

// 5. VIEW එක LOAD කිරීම
include __DIR__ . '/../view/home_menu_view.php'; 
?>