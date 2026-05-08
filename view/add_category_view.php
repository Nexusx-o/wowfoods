<?php 
// We include the header which contains our CSS and Navigation
include '../includes/header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0 text-danger">Add New Category</h4>
                        <div>
                            <a href="../controller/Category_Controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <hr class="mb-4 opacity-50">

                    <form action="../controller/Category_Controller.php?action=add" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Category Title</label>
                            <input type="text" name="title" class="form-control form-control-lg rounded-3" 
                                   placeholder="e.g. Italian Pizza" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Category Image</label>
                            <div class="input-group">
                                <input type="file" name="image" class="form-control rounded-3" id="categoryImage">
                            </div>
                            <small class="text-muted mt-1 d-block">Recommended: Square image (500x500px), JPG or PNG.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted d-block">Visibility Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" id="activeYes" value="Yes" checked>
                                <label class="form-check-label" for="activeYes">Show on Site (Active)</label>
                            </div>
                            <div class="form-check form-check-inline ms-3">
                                <input class="form-check-input" type="radio" name="active" id="activeNo" value="No">
                                <label class="form-check-label" for="activeNo">Hide (Inactive)</label>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-danger btn-lg w-100 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Save Category
                        </button>

                    </form>

                </div>
            </div>
            
            <div class="alert alert-light mt-3 border-0 small text-muted text-center rounded-4 shadow-sm">
                Adding a category will make it available when adding new food items.
            </div>
        </div>
    </div>
</div>

<?php 
// Include the footer which closes the body and html tags
include '../includes/footer.php'; 
?>