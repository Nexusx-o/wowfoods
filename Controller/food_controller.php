<?php
require_once '../config/init.php';
require_once '../Model/Food_Model.php';
checkAdmin();

$database = new Database();
$db = $database->getConnection();
$foodModel = new FoodModel($db);

$action = $_GET['action'] ?? 'manage';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'add':
        if (isset($_POST['submit'])) {
            $image = handleImageUpload($_FILES['image'], 'food');
            $data = [
                ':code'  => "FD" . rand(1000, 9999),
                ':title' => cleanInput($_POST['title']),
                ':desc'  => cleanInput($_POST['description']),
                ':price' => $_POST['price'],
                ':img'   => $image,
                ':cat'   => $_POST['category_id'],
                ':act'   => $_POST['active'],
                ':admin' => $_SESSION['user_id']
            ];
            if ($foodModel->create($data)) redirect('Controller/Food_Controller.php?action=manage');
        }
        $categories = $foodModel->getActiveCategories();
        include '../view/add_food_view.php';
        break;

    case 'update':
        $food = $foodModel->getById($id);
        if (isset($_POST['submit'])) {
            $image = ($_FILES['image']['name'] != "") ? handleImageUpload($_FILES['image'], 'food') : $food['image_name'];
            $data = [
                ':id'    => $id,
                ':title' => cleanInput($_POST['title']),
                ':desc'  => cleanInput($_POST['description']),
                ':price' => $_POST['price'],
                ':img'   => $image,
                ':cat'   => $_POST['category_id'],
                ':act'   => $_POST['active'],
                ':admin' => $_SESSION['user_id']
            ];
            if ($foodModel->update($data)) redirect('Controller/Food_Controller.php?action=manage');
        }
        $categories = $foodModel->getActiveCategories();
        include '../view/update_food_view.php';
        break;

    case 'delete':
        $food = $foodModel->getById($id);
        if ($food && $food['image_name']) unlink("../assets/images/food/" . $food['image_name']);
        $foodModel->delete($id);
        redirect('Controller/Food_Controller.php?action=manage');
        break;

    default:
        $foods = $foodModel->getAll();
        include '../view/manage_food_view.php';
        break;
}

// Reuse the image handler logic
function handleImageUpload($file, $folder) {
    if (!isset($file['name']) || $file['name'] == "") return "";
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = ucfirst($folder) . "_" . rand(000, 999) . '.' . $ext;
    move_uploaded_file($file['tmp_name'], "../assets/images/$folder/" . $newName);
    return $newName;
}