<?php include '../includes/header.php'; ?>


<div class="container py-5">

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'pw_reset'): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Success!</strong> Password has been reset to the default: <span class="badge bg-dark">WowFood123</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">System <span class="text-danger">Users</span></h3>
            <a href="../Controller/admin_dashboard_controller.php" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-2">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
        </div>
        <a href="User_Controller.php?action=add" class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="fas fa-user-plus me-1"></i> Add User
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <table class="table align-middle mb-0 table-hover">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold"><?php echo htmlspecialchars(($u['first_name'] ?? '') . ' ' . ($u['last_name'] ?? '')); ?></div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal">
                                <?php echo htmlspecialchars($u['username'] ?? ''); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($u['email'] ?? 'N/A'); ?></td>
                        <td>
                            <span class="small fw-bold text-uppercase text-muted"><?php echo $u['role']; ?></span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="User_Controller.php?action=update&id=<?php echo $u['id']; ?>" 
                               class="btn btn-sm btn-outline-dark rounded-pill px-3">Edit</a>
                            
                            <a href="User_Controller.php?action=reset_password&id=<?php echo $u['id']; ?>" 
                               class="btn btn-sm btn-warning rounded-pill px-3" 
                               onclick="return confirm('Reset this user\'s password to default (WowFood123)?')">
                               <i class="fas fa-key me-1"></i> Reset
                            </a>

                            <?php if($u['id'] != $_SESSION['user_id']): ?>
                                <a href="User_Controller.php?action=delete&id=<?php echo $u['id']; ?>" 
                                   class="btn btn-sm btn-danger rounded-pill px-3" 
                                   onclick="return confirm('Delete user permanently?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>