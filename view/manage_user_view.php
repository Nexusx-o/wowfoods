<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">System <span class="text-danger">Users</span></h3>
        <a href="User_Controller.php?action=add" class="btn btn-danger rounded-pill px-4 shadow-sm">Add User</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <table class="table align-middle mb-0">
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
                <?php foreach ($users as $u): ?>
                <tr>
                    <td class="ps-4"><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                    <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($u['username']); ?></span></td>
                    <td><?php echo htmlspecialchars($u['email'] ?? 'N/A'); ?></td>
                    <td><?php echo $u['role']; ?></td>
                    <td class="text-end pe-4">
                        <a href="User_Controller.php?action=update&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3">Edit</a>
                        <?php if($u['id'] != $_SESSION['user_id']): ?>
                            <a href="User_Controller.php?action=delete&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Delete user?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>