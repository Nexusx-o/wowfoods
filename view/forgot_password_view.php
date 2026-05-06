<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | WOWFOOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>assets/css/style.css">
</head>
<body class="forgot-pwd-body">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold"><span class="text-danger">WOW</span>FOOD</h2>
                    <p class="text-muted">Reset your password securely.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small text-center"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success py-2 small text-center"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <form action="forgot-password.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn btn-wow w-100 py-2 fw-bold">Send Reset Link</button>
                </form>

                <?php if ($reset_link): ?>
                    <div class="mt-4 animate-fade-in">
                        <label class="form-label small fw-bold">Reset Link</label>
                        <div class="bg-light p-3 rounded-3 small text-break"><?php echo htmlspecialchars($reset_link); ?></div>
                        <p class="text-muted small mt-2">Use this link within one hour to reset your password.</p>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <p class="small">Remembered? <a href="login.php" class="text-danger fw-bold text-decoration-none">Login</a></p>
                    <a href="signup.php" class="text-muted small text-decoration-none">Create a new account</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>