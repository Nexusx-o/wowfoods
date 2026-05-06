<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | WOWFOOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>assets/css/style.css">
</head>
<body class="forgot-pwd-body"> <!-- Reusing the background from forgot-password -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold"><span class="text-danger">WOW</span>FOOD</h2>
                    <p class="text-muted">Set a new password for your account.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-success py-2 small text-center"><?php echo $message; ?></div>
                    <div class="text-center mt-3">
                        <a href="login.php" class="btn btn-outline-dark rounded-pill px-4">Go to Login</a>
                    </div>
                <?php endif; ?>

                <!-- Show form only if there is no error and no success message -->
                <?php if (!$error && !$message): ?>
                    <form action="reset-password.php" method="POST">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required minlength="8">
                            <div class="form-text small">At least 8 characters recommended.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                        </div>
                        
                        <button type="submit" class="btn btn-wow w-100 py-2 fw-bold">Update Password</button>
                    </form>
                <?php endif; ?>

                <div class="text-center mt-4">
                    <a href="login.php" class="text-muted small text-decoration-none">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>