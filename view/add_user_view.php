<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="card border-0 shadow-sm col-md-6 mx-auto rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-danger">CREATE NEW USER</h4>
            <a href="../Controller/User_Controller.php?action=manage" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <form action="../Controller/User_Controller.php?action=add" method="POST">
            
            <div class="row g-3">
                <div class="col-6"><input type="text" name="first_name" class="form-control" placeholder="First Name" required></div>
                <div class="col-6"><input type="text" name="last_name" class="form-control" placeholder="Last Name" required></div>
                <div class="col-12"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
                <div class="col-12"><input type="email" name="email" class="form-control" placeholder="Email Address"></div>
                <div class="col-12">
                    <select name="role" class="form-select" required>
                        <option value="Staff">Staff</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="col-12"><input type="password" name="password" class="form-control" placeholder="Initial Password" required></div>
            </div>
            <button type="submit" name="submit" class="btn btn-danger w-100 rounded-pill mt-4 shadow-sm">Save User</button>
        
        </form> </div>
</div>

<?php include '../includes/footer.php'; ?>