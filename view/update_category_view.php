<?php 
include '../includes/header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-danger">Update Category</h4>
                        <a href="../controller/Category_Controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">
                            Back
                        </a>
                    </div>

                    <hr class="mb-4 opacity-50">

                    <form action="../controller/Category_Controller.php?action=update&id=<?php echo $category['id']; ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Category Title</label>
                            <input type="text" name="title" class="form-control rounded-3" 
                                   value="<?php echo htmlspecialchars($category['title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted d-block">Current Image</label>
                            <?php if (!empty($category['image_name'])): ?>
                                <img src="../assets/images/category/<?php echo $category['image_name']; ?>" 
                                     class="rounded-3 mb-2 shadow-sm" width="150">
                            <?php else: ?>
                                <p class="text-muted small">No image currently assigned.</p>
                            <?php endif; ?>
                            
                            <input type="file" name="image" class="form-control rounded-3">
                            <small class="text-muted">Leave blank to keep the current image.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted d-block">Visibility Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" id="activeYes" value="Yes" 
                                    <?php if($category['active'] == "Yes") echo "checked"; ?>>
                                <label class="form-check-label" for="activeYes">Active</label>
                            </div>
                            <div class="form-check form-check-inline ms-3">
                                <input class="form-check-input" type="radio" name="active" id="activeNo" value="No"
                                    <?php if($category['active'] == "No") echo "checked"; ?>>
                                <label class="form-check-label" for="activeNo">Inactive</label>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">

                        <button type="submit" name="submit" class="btn btn-danger btn-lg w-100 rounded-pill shadow-sm">
                            Update Category
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>