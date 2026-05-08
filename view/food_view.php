<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manage Food Items</h3>
        <a href="Food_Controller.php?action=add" class="btn btn-danger rounded-pill px-4">Add Food</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foods as $food): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($food['title']); ?></strong></td>
                    <td><span class="badge bg-light text-dark"><?php echo $food['category_title']; ?></span></td>
                    <td class="text-danger fw-bold">$<?php echo number_format($food['price'], 2); ?></td>
                    <td><img src="../assets/images/food/<?php echo $food['image_name']; ?>" width="50" class="rounded shadow-sm"></td>
                    <td><?php echo $food['active']; ?></td>
                    <td class="text-end">
                        <a href="Food_Controller.php?action=update&id=<?php echo $food['id']; ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                        <a href="Food_Controller.php?action=delete&id=<?php echo $food['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>