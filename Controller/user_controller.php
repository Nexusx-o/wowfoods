<?php
/**
 * Controller: User_Controller.php
 * Path: controller/User_Controller.php
 */

require_once '../config/init.php';
require_once '../model/User_Model.php';

// Security: Only Admins should access this controller
// Assumes checkAdmin() is defined in your session/init files
checkAdmin(); 

// Initialize Database and Model
$database = new Database();
$db = $database->getConnection();
$userModel = new UserModel($db);

// Get current action and ID from URL
$action = $_GET['action'] ?? 'manage';
$id = $_GET['id'] ?? null;

switch ($action) {

    /**
     * READ: Display all users
     */
    case 'manage':
        // Controller asks Model for data
        $users = $userModel->getAll(); 
        // Controller passes data to the View
        include '../view/manage_user_view.php';
        break;

    /**
     * CREATE: Process form submission or show Add form
     */
    case 'add':
        if (isset($_POST['submit'])) {
            // Controller prepares and sanitizes data for the Model
            $data = [
                ':first' => cleanInput($_POST['first_name']),
                ':last'  => cleanInput($_POST['last_name']),
                ':user'  => cleanInput($_POST['username']),
                ':pass'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ':email' => cleanInput($_POST['email']),
                ':role'  => $_POST['role']
            ];

            // Controller tells Model to save
            if ($userModel->create($data)) {
                redirect('controller/User_Controller.php?action=manage&msg=added');
            } else {
                $error = "Failed to create user. Email or Username might be taken.";
            }
        }
        include '../view/add_user_view.php';
        break;

    /**
     * UPDATE: Fetch existing data and process updates
     */
    case 'update':
        if (!$id) redirect('controller/User_Controller.php?action=manage');

        // Controller fetches user data to pre-fill the form
        $user = $userModel->getById($id);

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
                redirect('controller/User_Controller.php?action=manage&msg=updated');
            }
        }
        include '../view/update_user_view.php';
        break;

    /**
     * DELETE: Remove user (preventing self-deletion)
     */
    case 'delete':
        if ($id && $id != $_SESSION['user_id']) {
            $userModel->delete($id);
            redirect('controller/User_Controller.php?action=manage&msg=deleted');
        } else {
            // Cannot delete yourself
            redirect('controller/User_Controller.php?action=manage&msg=err_self_delete');
        }
        break;

    /**
     * UTILITY: Reset Password to default
     */
    case 'reset_password':
        if ($id) {
            $defaultPassword = "WowFood123"; 
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            
            if ($userModel->resetPassword($id, $hashedPassword)) {
                redirect('controller/User_Controller.php?action=manage&msg=pw_reset');
            }
        }
        break;

    default:
        redirect('controller/User_Controller.php?action=manage');
        break;
}