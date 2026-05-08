<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Order <span class="text-danger">Management</span></h3>
        <a href="../Controller/admin_dashboard_controller.php" class="btn btn-outline-secondary rounded-pill px-4">Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td class="ps-4">#<?php echo $o['id']; ?></td>
                    <td><?php echo htmlspecialchars($o['first_name'] . ' ' . $o['last_name']); ?></td>
                    <td class="fw-bold text-danger">$<?php echo number_format($o['total_amount'], 2); ?></td>
                    <td><span class="badge rounded-pill bg-info text-dark"><?php echo $o['status']; ?></span></td>
                    <td><?php echo $o['payment_status']; ?></td>
                    <td class="text-end pe-4">
                        <a href="Order_Controller.php?action=update&id=<?php echo $o['id']; ?>" class="btn btn-sm btn-dark rounded-pill px-3">Update Status</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>