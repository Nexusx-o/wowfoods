<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | WOWFOOD</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-page-body">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4">
                
                <div class="text-center mb-4">
                    <h2 class="fw-bold"><span class="brand-red">WOW</span>FOOD</h2>
                    <p class="text-muted">Login to order your favorites!</p>
                </div>

                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label text-small-bold">Email or Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-small-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="btn btn-wow w-100 py-2 fw-bold">Login</button>
                </form>

                <div class="text-center mt-4">
                    <a href="../controller/forgot_password_controller.php" class="text-small-bold brand-red text-decoration-none">Forgot Password?</a>
                    <hr class="my-3 opacity-10">
                    <p class="small mb-1">Don't have an account? 
                        <a href="../controller/signup_controller.php" class="brand-red fw-bold text-decoration-none">Sign Up</a>
                    </p>
                    <a href="index.php" class="text-muted text-decoration-none small">Back to Home</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>