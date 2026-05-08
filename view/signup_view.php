    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Signup | WOWFOOD</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="..assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </head>
    <body class="bg-light">

    <div class="container py-5">
        <div class="card shadow-sm mx-auto signup-card" style="max-width: 600px;">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold text-danger mb-4">Customer Registration</h3>

                <?php if($error_message): ?>
                    <div class="alert alert-danger small py-2"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <?php if($success_message): ?>
                    <div class="alert alert-success small py-2">
                        <?php echo $success_message; ?>
                        <p class="mb-0 mt-1">Redirecting to login in 3 seconds...</p>
                    </div>
                    <script>
                        setTimeout(function(){ window.location.href = '../controller/login_controller.php'; }, 3000);
                    </script>
                <?php endif; ?>
                <form action="../controller/signup_controller.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">First Name</label>
                            <input type="text" name="first_name" class="form-control" 
                                placeholder="John" required 
                                value="<?php echo isset($first_name) ? htmlspecialchars($first_name) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Last Name</label>
                            <input type="text" name="last_name" class="form-control" 
                                placeholder="Doe" required 
                                value="<?php echo isset($last_name) ? htmlspecialchars($last_name) : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" 
                                name="email" 
                                id="email" 
                                class="form-control" 
                                placeholder="name@example.com"
                                required 
                                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                            <div id="emailFeedback" class="small mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone</label>
                            <input type="tel" name="phone" class="form-control" 
                            placeholder="07X-XXXXXXX"
                                pattern="[0-9]{10,15}" 
                                title="Please enter 10 to 15 digits"
                                required>
                        </div>
                    </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="password" 
                                        class="form-control password-field" required minlength="8">
                                </div>
                                <div id="passwordFeedback"></div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Confirm Password</label>
                                <div class="position-relative">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control password-field" required minlength="8">
                                </div>
                                <div id="confirmFeedback"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Delivery Address</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">City</label>
                            <input type="text" name="city" class="form-control" placeholder="City">
                        </div>

                        <button type="submit" name="submit" class="btn btn-danger w-100 rounded-pill fw-bold py-2 shadow-sm">
                            Create Account
                        </button>
                        
                        <div class="text-center mt-3">
                            <p class="small text-muted">Already have an account? 
                                <a href="../controller/login_controller.php" class="text-danger fw-bold text-decoration-none">Login</a>
                            </p>
                        </div>
                </form>
            </div>
        </div>
    </div>

<script src="../assets/javascript/main.js"></script>
    </body>
    </html>