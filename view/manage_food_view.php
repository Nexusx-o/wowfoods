<?php 
// Header includes the CSS and Navigation bar
include '../includes/header.php'; 
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Manage <span class="text-danger">Food Menu</span></h3>
            <p class="text-muted small">View and manage all dishes available on your menu.</p>
        </div>
        <a href="../controller/Food_Controller.php?action=add" class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i>Add Food Item
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Food Item</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($foods)): ?>
                        <?php foreach ($foods as $food): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold"><?php echo htmlspecialchars($food['title']); ?></div>
                                <div class="text-muted extra-small" style="font-size: 0.75rem;">
                                    Code: <?php echo $food['food_code']; ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    <?php echo htmlspecialchars($food['category_title']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-danger fw-bold">$<?php echo number_format($food['price'], 2); ?></span>
                            </td>
                            <td>
                                <?php if (!empty($food['image_name'])): ?>
                                    <img src="../assets/images/food/<?php echo $food['image_name']; ?>" 
                                         class="rounded-3 shadow-sm" width="60" height="45" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" 
                                         style="width: 60px; height: 45px; font-size: 0.7rem;">
                                        No Image
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($food['active'] == 'Yes'): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="../controller/Food_Controller.php?action=update&id=<?php echo $food['id']; ?>" 
                                   class="btn btn-sm btn-outline-dark rounded-pill me-1 px-3">
                                    Edit
                                </a>
                                <a href="../controller/Food_Controller.php?action=delete&id=<?php echo $food['id']; ?>" 
                                   class="btn btn-sm btn-danger rounded-pill px-3" 
                                   onclick="return confirm('Are you sure you want to delete this food item?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-hamburger fa-3x mb-3 opacity-25"></i>
                                <p>No food items found. Click "Add Food Item" to get started.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
// Footer closes the layout
include '../includes/footer.php'; 
?>