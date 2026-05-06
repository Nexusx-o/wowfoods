
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WOWFOOD | Fast, Delicious Deliveries</title>
    
    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="../public/index.php">
                    <img src="../assets/images/logo.png" alt="Logo" width="40" class="me-2">
                    <span class="logo-text">WOWFOOD</span>
                </a>
                
                <!-- Mobile Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link px-3" href="../public/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="../public/menu.php">Menu</a>
                        </li>
                        
                        <?php if(isset($_SESSION['customer_id'])): 
                            $fullName = $_SESSION['full_name'] ?? 'User';
                            $firstName = explode(' ', trim($fullName))[0];
                        ?>
                            <!-- Customer Links -->
                            <li class="nav-item">
                                <a class="nav-link px-3 fw-bold text-danger" href="customer-dashboard.php">
                                    <i class="fas fa-history me-1"></i> My Orders
                                </a>
                            </li>
                            <li class="nav-item px-3">
                                <span class="user-greeting">Hi, <?php echo htmlspecialchars($firstName); ?>!</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-login ms-lg-3" href="../logout.php">Logout</a>
                            </li>
                        
                        <?php elseif(isset($_SESSION['user_id'])): ?>
                            <!-- Admin Links -->
                            <li class="nav-item">
                                <a class="nav-link px-3" href="../admin/dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn-login ms-lg-3" href="../logout.php">Logout</a>
                            </li>
                            
                        <?php else: ?>
                            <!-- Guest Link -->
                            <li class="nav-item">
                                <a class="nav-link btn-login ms-lg-3" href="../login.php">Login / Sign Up</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Prevents content from being hidden under the fixed navbar -->
    <div class="content-spacer"></div>