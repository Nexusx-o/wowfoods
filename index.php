<?php 
include 'includes/session.php'; 
include 'config/database.php'; // This defines the class

// ADD THESE LINES TO INITIALIZE THE CONNECTION
$database = new Database();
$db = $database->getConnection(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOWFOOD | Premium Food Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top px-4">
        <a class="navbar-brand fw-bold" href="#">
            <span style="color: #E63946;">WOW</span>FOOD
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="../controller/menu_view_controller.php">Menu</a></li> -->
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['customer_id'])): ?>
                    <li class="nav-item"><a class="nav-link text-warning" href="controller/customer_dashboard_controller.php">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="controller/logout_controller.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="controller/login_controller.php">Login</a></li>
                <?php endif; ?>

                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary rounded-pill px-4" href="controller/menu_view_controller.php">Order Now</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-2 fw-bold mb-4" style="font-family: 'Playfair Display';">The Food You Love, <span class="text-warning">Delivered.</span></h1>
                    <p class="lead mb-5">Experience the ultimate flavor with WOWFOOD. From local favorites to gourmet delights, we bring the restaurant to your door.</p>
                    <div class="d-flex gap-3">
                        <a href="#menu" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold">Explore Menu</a>
                        <a href="assets/video/marketing.mp4" class="btn btn-outline-light btn-lg rounded-pill px-5"><i class="fas fa-play me-2"></i>Watch Video</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="fas fa-shipping-fast fa-3x text-danger mb-3"></i>
                    <h4>30 Minute Delivery</h4>
                    <p class="text-secondary">Fastest delivery in the city or your money back.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                    <h4>Quality Ingredients</h4>
                    <p class="text-secondary">We only partner with top-rated local restaurants.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-headset fa-3x text-danger mb-3"></i>
                    <h4>24/7 Support</h4>
                    <p class="text-secondary">Our team is always here to help with your cravings.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="menu">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Popular Categories</h2>
                <div class="mx-auto bg-danger" style="height: 3px; width: 60px;"></div>
            </div>
           <div class="row g-4">
<?php 
$query = "SELECT 
    category_id, 
    category_name, 
    MIN(image_name) as image_name 
FROM vw_food_details 
WHERE active = 'Yes' 
GROUP BY category_id, category_name 
LIMIT 4;";
          
try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($categories)): 
        foreach ($categories as $cat): 
            // FIX: Check if image_name is empty OR null
            // Also fixed the typo 'catergory' to 'category'
            $imageFileName = (!empty($cat['image_name'])) ? $cat['image_name'] : 'default-catergory.jpg';
?>
            <div class="col-md-3">
                <div class="category-card text-center p-4 shadow-sm rounded-4 bg-white border">
                    <img src="assets/images/category/<?php echo htmlspecialchars($imageFileName); ?>" 
                         class="img-fluid mb-3 rounded-3" 
                         style="height: 150px; width: 100%; object-fit: cover;" 
                         alt="<?php echo htmlspecialchars($cat['category_name']); ?>">
                    <h5 class="fw-bold"><?php echo htmlspecialchars($cat['category_name']); ?></h5>
                </div>
            </div>
        <?php endforeach; 
    else: ?>
        <div class="col-12 text-center py-5 text-secondary">
            <p>No popular categories available right now.</p>
        </div>
<?php 
    endif; 
} catch (PDOException $e) {
    echo "<p class='text-danger'>Error loading categories: " . $e->getMessage() . "</p>";
}
?>
</div>
                       <br>
                       <br>


    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3 class="fw-bold"><span class="text-danger">WOW</span>FOOD</h3>
                    <p class="text-secondary">Redefining how you eat. Reliable, fast, and always delicious.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-secondary text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">Terms & Conditions</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <h5>Follow Us</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center text-secondary mb-0">&copy; 2026 WOWFOOD Inc. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/javascript/main.js"></script>
</body>
</html>