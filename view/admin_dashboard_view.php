<?php include('../includes/header.php'); ?>

<div class="container-fluid py-5 bg-light" style="min-height: 100vh;">
    <div class="container">
        
        <div class="row mb-4">
            <div class="col-md-7">
                <h2 class="fw-bold">
                    <i class="fas fa-chart-line text-danger me-2"></i>Admin 
                    <span class="text-danger">Dashboard</span>
                </h2>
                <p class="text-muted">Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>. Here is what's happening today.</p>
            </div>
            <div class="col-md-5 text-md-end align-self-center">
                <a href="../view/add_category_view.php" class="btn btn-outline-danger rounded-pill px-4 shadow-sm me-2">
                    <i class="fas fa-folder-plus me-2"></i>Add Category
                </a>
                <a href="../controller/food_controller.php?action=add" class="btn btn-danger rounded-pill px-4 shadow-sm me-2">
                    <i class="fas fa-hamburger me-2"></i>Add Food
                </a>
                <a href="../view/add_user_view.php" class="btn btn-outline-dark rounded-pill px-4 shadow-sm">
                    <i class="fas fa-user-plus me-2"></i>Add User
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card p-3 shadow-sm admin-card text-center">
                    <h5>Categories</h5>
                    <p class="fs-4 fw-bold text-danger"><?php echo htmlspecialchars($stats['categories']); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm admin-card text-center">
                    <h5>Foods</h5>
                    <p class="fs-4 fw-bold text-danger"><?php echo htmlspecialchars($stats['foods']); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm admin-card text-center">
                    <h5>Total Users</h5>
                    <p class="fs-4 fw-bold text-danger"><?php echo htmlspecialchars($stats['users']); ?></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm admin-card text-center">
                    <h5>Revenue</h5>
                    <p class="fs-4 fw-bold text-danger">$<?php echo number_format($stats['revenue'], 2); ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag text-danger me-2"></i>Recent Orders</h5>
                        <a href="../controller/order_controller.php" class="btn btn-sm btn-outline-danger rounded-pill">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3">Order ID</th>
                                        <th class="py-3">Status</th>
                                        <th class="text-center pe-4 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentOrders)): ?>
                                        <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">#<?php echo htmlspecialchars($order['id']); ?></td>
                                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($order['status']); ?></span></td>
                                            <td class="text-center pe-4">
                                                <a href="../view/update_order_view.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-sm btn-dark rounded-pill px-3">
                                                    Manage
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <img src="../assets/images/no-data.svg" alt="No data" style="width: 80px;" class="mb-3 d-block mx-auto opacity-50">
                                            <p class="text-muted">No orders found in the database.</p>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .admin-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .table-hover tbody tr:hover { background-color: rgba(220, 53, 69, 0.02); }
</style>

<?php include('../includes/footer.php'); ?>