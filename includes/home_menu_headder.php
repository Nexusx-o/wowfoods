<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../config/database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOWFOOD | Fast, Delicious Deliveries</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="../index.php">
                    <img src="../assets/images/logo.png" alt="Logo" width="35" class="me-2" onerror="this.style.display='none'">
                    <span class="logo-text fw-bold text-danger" style="letter-spacing: 1px;">WOWFOOD</span>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link px-3 fw-medium text-dark" href="../index.php">Home</a>
                        </li>
                        
                        <?php if(isset($_SESSION['customer_id'])): 
                            $firstName = explode(' ', trim($_SESSION['full_name'] ?? 'User'))[0];
                        ?>
                            <li class="nav-item ms-lg-2">
                                <a href="../Controller/login_controller.php" class="btn btn-outline-dark btn-sm rounded-pill px-3">Login</a>
                            </li>
                        <?php else: ?> 
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="content-spacer" style="margin-top: 75px;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>