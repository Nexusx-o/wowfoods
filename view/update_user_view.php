<?php 
// Header includes your standard CSS, Fonts, and Navigation
include '../includes/header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-danger">UPDATE USER INFO</h4>
                        <a href="../Controller/User_Controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>

                    <hr class="mb-4 opacity-50">

                    <form action="../Controller/User_Controller.php?action=update&id=<?php echo $user['id']; ?>" method="POST">
                        <div class="row g-3">
                            
                            <div class="col-6">
                                <label class="small fw-bold text-muted">First Name</label>
                                <input type="text" name="first_name" class="form-control rounded-3" 
                                       value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                            </div>

                            <div class="col-6">
                                <label class="small fw-bold text-muted">Last Name</label>
                                <input type="text" name="last_name" class="form-control rounded-3" 
                                       value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="small fw-bold text-muted">Username</label>
                                <input type="text" name="username" class="form-control rounded-3" 
                                       value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="small fw-bold text-muted">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-3" 
                                       value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            </div>

                            <div class="col-12">
                                <label class="small fw-bold text-muted">Access Level / Role</label>
                                <select name="role" class="form-select rounded-3">
                                    <option value="Staff" <?php if(($user['role'] ?? '') == 'Staff') echo 'selected'; ?>>Staff</option>
                                    <option value="Manager" <?php if(($user['role'] ?? '') == 'Manager') echo 'selected'; ?>>Manager</option>
                                    <option value="Admin" <?php if(($user['role'] ?? '') == 'Admin') echo 'selected'; ?>>Admin</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" name="submit" class="btn btn-danger btn-lg w-100 rounded-pill mt-4 shadow-sm">
                            Update Changes
                        </button>
                    </form>

                </div>
            </div>

            <div class="text-center mt-3 small text-muted">
                <i class="fas fa-info-circle me-1"></i> 
                Passwords cannot be changed here. Use the <strong>Reset Password</strong> feature in User Management.
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>