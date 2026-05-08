<?php 
// Header එක ඇතුළත් කිරීම (ඔයා ලබාදුන් header.php)
include ('../includes/header.php'); 
?>

<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="row">
            
            <aside class="col-lg-2 mb-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 sticky-top" style="top: 100px;">
                    <h6 class="fw-bold mb-3 text-uppercase small">Categories</h6>
                    <ul class="list-group list-group-flush small">
                        <a href="home_menu_view_controller.php" class="list-group-item list-group-item-action border-0 <?php echo (!isset($category_id) || $category_id == 0) ? 'text-danger fw-bold' : ''; ?>">
                            All
                        </a>
                        <?php if(!empty($categories)): foreach($categories as $cat): ?>
                            <a href="home_menu_view_controller.php?cat_id=<?php echo $cat['id']; ?>" 
                               class="list-group-item list-group-item-action border-0 <?php echo (isset($category_id) && $category_id == $cat['id']) ? 'text-danger fw-bold' : ''; ?>">
                                <?php echo htmlspecialchars($cat['title']); ?>
                            </a>
                        <?php endforeach; endif; ?>
                    </ul>
                </div>
            </aside>

            <div class="col-lg-10">
                <h2 class="fw-bold mb-4 text-dark">Our <span class="text-danger">Menu</span></h2>
                <div class="row g-4">
                    <?php if(!empty($foods)): foreach($foods as $food): 
                        $image_name = !empty($food['image_name']) ? $food['image_name'] : 'default-food.jpg';
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                            <img src="../assets/images/food/<?php echo htmlspecialchars($image_name); ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="fw-bold mb-1 text-dark"><?php echo htmlspecialchars($food['title']); ?></h6>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="text-danger fw-bold fs-5">Rs.<?php echo number_format($food['price'], 2); ?></span>
                                    
                                    <?php if(isset($_SESSION['customer_id'])): ?>
                                        <form action="../Controller/home_menu_view_controller.php" method="POST">
                                            <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">Order now</button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" onclick="showLoginAlert()" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">Order now</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showLoginAlert() {
    alert("Please login to your account to order foods!");
    window.location.href = "../Controller/login_controller.php";
}
</script>

<?php 
// Footer එක ඇතුළත් කිරීම (ඔයා ලබාදුන් footer.php)
include '../includes/footer.php'; 
?>