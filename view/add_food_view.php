<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-danger">ADD NEW FOOD ITEM</h4>
                        <a href="../controller/Food_Controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">Back</a>
                    </div>

                    <form action="../controller/Food_Controller.php?action=add" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Food Title</label>
                                <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. Special Burger" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Price ($)</label>
                                <input type="number" name="price" step="0.01" class="form-control rounded-3" placeholder="10.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category</label>
                            <select name="category_id" class="form-select rounded-3" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Description</label>
                            <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Ingredients, spice level, etc..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Food Image</label>
                            <input type="file" name="image" class="form-control rounded-3">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" value="Yes" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" value="No">
                                <label class="form-check-label">Inactive</label>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-danger btn-lg w-100 rounded-pill shadow-sm">Save Food Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>