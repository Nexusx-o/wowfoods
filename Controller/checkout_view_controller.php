<?php
/**
 * CheckoutController - Controls the checkout flow
 */

// 1. අවශ්‍ය මූලික ගොනු සම්බන්ධ කිරීම
require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/checkout_view_controller_model.php';

// 2. ආරක්ෂක පියවර: Customer ලොග් වී නොමැති නම් ලොගින් පිටුවට යොමු කරයි
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php?error=must_login");
    exit();
}

// 3. Database සහ Model Object නිර්මාණය
$database = new Database();
$db = $database->getConnection();
$checkoutModel = new CheckoutModel($db);

// 4. දත්ත සූදානම් කිරීම
$customer_id = $_SESSION['customer_id'];
$cart = $_SESSION['cart'] ?? [];

// 5. කරත්තය හිස් නම් මෙනු පිටුවට (Menu Controller එකට) යොමු කරයි
if (empty($cart)) {
    header("Location: MenuController.php");
    exit();
}

// 6. මුළු මුදල ගණනය කිරීම (Model එක හරහා)
$total_amount = $checkoutModel->calculateTotal($cart);

// 7. පෙනුම (View) ලෝඩ් කිරීම
// මෙහි ඇති $total_amount, $cart වැනි variables, checkout_view.php එකට ලබාගත හැක.
include __DIR__ . '/../view/checkout_view.php'; 
?>