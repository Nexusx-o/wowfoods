<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | WOWFOOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Use your external CSS -->
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1548');
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .btn-wow { background-color: #E63946; color: white; border-radius: 50px; transition: 0.3s; }
        .btn-wow:hover { background-color: #d62828; color: white; transform: scale(1.02); }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold"><span class="text-danger">WOW</span>FOOD</h2>
                    <p class="text-muted">Login to order your favorites!</p>
                </div>

                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email or Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-wow w-100 py-2 fw-bold">Login</button>
                </form>

                <div class="text-center mt-3">
                    <a href="forgot-password.php" class="small text-danger fw-bold text-decoration-none">Forgot Password?</a>
                </div>
                <div class="text-center mt-3">
                    <p class="small">Don't have an account? <a href="signup.php" class="text-danger fw-bold text-decoration-none">Sign Up</a></p>
                    <a href="../index.php" class="text-muted text-decoration-none small">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>