<?php
require_once '../config/init.php';
require_once '../Model/User_Model.php';
checkAdmin(); // Only Admins can manage users

$database = new Database();
$db = $database->getConnection();
$userModel = new UserModel($db);

$action = $_GET['action'] ?? 'manage';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'add':
        if (isset($_POST['submit'])) {
            $data = [
                ':first' => cleanInput($_POST['first_name']),
                ':last'  => cleanInput($_POST['last_name']),
                ':user'  => cleanInput($_POST['username']),
                ':pass'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ':email' => cleanInput($_POST['email']),
                ':role'  => $_POST['role']
            ];
            if ($userModel->create($data)) redirect('Controller/User_Controller.php?action=manage');
        }
        include '../view/add_user_view.php';
        break;

   case 'update':
    $id = $_GET['id'];
    // 1. Fetch user data to populate the form
    $user = $userModel->getById($id);

    // 2. If form is submitted, process the update
    if (isset($_POST['submit'])) {
        $updateData = [
            ':id'    => $id,
            ':first' => cleanInput($_POST['first_name']),
            ':last'  => cleanInput($_POST['last_name']),
            ':user'  => cleanInput($_POST['username']),
            ':email' => cleanInput($_POST['email']),
            ':role'  => $_POST['role']
        ];
        if ($userModel->update($updateData)) {
            redirect('Controller/User_Controller.php?action=manage&msg=user_updated');
        }
    }
    include '../view/update_user_view.php';
    break;

    case 'delete':
        if ($id != $_SESSION['user_id']) { // Prevent self-deletion
            $userModel->delete($id);
        }
        redirect('Controller/User_Controller.php?action=manage');
        break;

    default:
        $users = $userModel->getAll();
        include '../view/manage_user_view.php';
        break;
}