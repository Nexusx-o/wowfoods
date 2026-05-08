<?php include '../includes/header.php'; ?>

<div class="container py-5">
    <div class="card border-0 shadow-sm col-md-6 mx-auto rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-danger mb-0">UPDATE ORDER #<?php echo $order['id']; ?></h4>
            <a href="Order_Controller.php?action=manage" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Back</a>
        </div>

        <div class="bg-light p-3 rounded-3 mb-4">
            <p class="mb-1 small text-muted">Customer Name</p>
            <h6 class="fw-bold"><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></h6>
            <p class="mb-1 small text-muted mt-2">Total Amount</p>
            <h6 class="fw-bold text-danger">$<?php echo number_format($order['total_amount'], 2); ?></h6>
        </div>

        <form action="Order_Controller.php?action=update&id=<?php echo $order['id']; ?>" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Order Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="Ordered" <?php if($order['status']=='Ordered') echo 'selected'; ?>>Ordered</option>
                    <option value="On Delivery" <?php if($order['status']=='On Delivery') echo 'selected'; ?>>On Delivery</option>
                    <option value="Delivered" <?php if($order['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Cancelled" <?php if($order['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Payment Status</label>
                <select name="payment_status" class="form-select rounded-3">
                    <option value="Pending" <?php if($order['payment_status']=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Paid" <?php if($order['payment_status']=='Paid') echo 'selected'; ?>>Paid</option>
                    <option value="Failed" <?php if($order['payment_status']=='Failed') echo 'selected'; ?>>Failed</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-danger btn-lg w-100 rounded-pill shadow-sm">Save Changes</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>