<?php
require_once '../config/init.php';
require_once '../Model/Category_Model.php';
checkAdmin(); // Security from session.php

$database = new Database();
$db = $database->getConnection();
$categoryModel = new CategoryModel($db);

$action = $_GET['action'] ?? 'manage';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'add':
        if (isset($_POST['submit'])) {
            $title = cleanInput($_POST['title']);
            $active = $_POST['active'];
            $image = handleImageUpload($_FILES['image'], 'category');
            $code = "CAT" . rand(1000, 9999);
            
            if ($categoryModel->create($code, $title, $image, $active, $_SESSION['user_id'])) {
                redirect('Controller/Category_Controller.php?action=manage&msg=added');
            }
        }
        include '../view/add_category_view.php';
        break;

    case 'update':
        $category = $categoryModel->getById($id);
        if (isset($_POST['submit'])) {
            $title = cleanInput($_POST['title']);
            $active = $_POST['active'];
            // Keep old image if new one isn't uploaded
            $image = ($_FILES['image']['name'] != "") ? handleImageUpload($_FILES['image'], 'category') : $category['image_name'];
            
            if ($categoryModel->update($id, $title, $image, $active, $_SESSION['user_id'])) {
                redirect('Controller/Category_Controller.php?action=manage&msg=updated');
            }
        }
        include '../view/update_category_view.php';
        break;

    case 'delete':
        $category = $categoryModel->getById($id);
        if ($category) {
            if ($category['image_name']) unlink("../assets/images/category/" . $category['image_name']);
            $categoryModel->delete($id);
        }
        redirect('Controller/Category_Controller.php?action=manage&msg=deleted');
        break;

    default: // Manage
        $categories = $categoryModel->getAll();
        include '../view/manage_category_view.php';
        break;
}

// Helper for image upload inside controller
function handleImageUpload($file, $folder) {
    if (!isset($file['name']) || $file['name'] == "") return "";
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = ucfirst($folder) . "_" . rand(000, 999) . '.' . $ext;
    move_uploaded_file($file['tmp_name'], "../assets/images/$folder/" . $newName);
    return $newName;
}