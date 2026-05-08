<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | WOWFOOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&w=1548');
            background-size: cover; min-height: 100vh; display: flex; align-items: center;
        }
        .card { border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); }
        .btn-wow { background-color: #E63946; color: white; border-radius: 50px; }
        .btn-wow:hover { background-color: #d62828; color: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold"><span class="text-danger">WOW</span>FOOD</h2>
                    <p class="text-muted">Reset your password securely.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success py-2 small text-center"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form action="forgot_password_controller.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-wow w-100 py-2 fw-bold">Send Reset Link</button>
                </form>

                <?php if ($reset_link): ?>
                    <div class="mt-4">
                        <label class="form-label small fw-bold">Internal Test Link:</label>
                        <div class="bg-light p-3 rounded-3 small text-break"><?= htmlspecialchars($reset_link) ?></div>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <p class="small">Remembered? <a href="login_controller.php" class="text-danger fw-bold text-decoration-none">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>