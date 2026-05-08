<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Manage <span class="text-danger">Category</span></h3>
            <p class="text-muted small">View and manage all categories available on your shop.</p>
        </div>
        <div>
         <a href="../controller/admin_dashboard_controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">Back</a>

        <a href="../controller/Category_Controller.php?action=add" class="btn btn-danger rounded-pill px-4">Add New</a>
</div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Active</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($cat['title']); ?></strong></td>
                    <td><img src="../assets/images/category/<?php echo $cat['image_name']; ?>" width="60" class="rounded"></td>
                    <td><?php echo $cat['active']; ?></td>
                    <td class="text-end">
                        <a href="../controller/Category_Controller.php?action=update&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                        <a href="../controller/Category_Controller.php?action=delete&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>