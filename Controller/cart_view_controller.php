<?php

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../Model/cart_view_controller_model.php';

//  Database and Model Object Creation
$database = new Database();
$db = $database->getConnection();
$cartModel = new CartModel($db);


// --- logic Section ---

//  ADD ITEM TO CART
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['food_id'])) {
    $food_id = (int)$_POST['food_id'];
    $food = $cartModel->getFoodForCart($food_id);
    
    if ($food) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $image = !empty($food['image_name']) ? $food['image_name'] : 'default-food.jpg';

        if (isset($_SESSION['cart'][$food_id])) {
            $_SESSION['cart'][$food_id]['qty']++;
        } else {
            $_SESSION['cart'][$food_id] = [
                'title' => $food['title'],
                'price' => $food['price'],
                'image' => $image,
                'qty' => 1
            ];
        }
    }

    // Providing the correct path to avoid "Not Found"
    header("Location: CartController.php");
    exit();
}

 //  REMOVE ITEM FROM CART
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart_view_controller.php");
    exit();
}

 // UPDATE QUANTITIES
if (isset($_POST['update_qty']) && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $new_qty) {
        if ($new_qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['qty'] = (int)$new_qty;
        }
    }
    header("Location: cart_view_controller.php");
    exit();
}

// CALCULATE TOTALS
$grand_total = $cartModel->calculateGrandTotal($_SESSION['cart'] ?? []);

include __DIR__ . '/../view/cart_view.php';
?>