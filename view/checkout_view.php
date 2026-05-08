<?php 
include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-5 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-danger">Your items</span>
                <span class="badge bg-danger rounded-pill"><?php echo count($cart); ?></span>
            </h4>
            <ul class="list-group mb-3 shadow-sm">
                <?php foreach($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['qty'];
                ?>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0"><?php echo htmlspecialchars($item['title']); ?></h6>
                        <small class="text-muted">Qty: <?php echo $item['qty']; ?></small>
                    </div>
                    <span class="text-muted">$<?php echo number_format($subtotal, 2); ?></span>
                </li>
                <?php endforeach; ?>
                
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <span class="fw-bold">Total (USD)</span>
                    <strong class="text-danger h5">$<?php echo number_format($total_amount, 2); ?></strong>
                </li>
            </ul>
        </div>

        <div class="col-md-7 order-md-1">
            <h4 class="mb-3 fw-bold">Delivery & Payment</h4>
            <form action="../Controller/process_order_controller.php" method="POST" class="card p-4 shadow-sm border-0 rounded-4">
                <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Delivery Address</label>
                    <textarea name="delivery_address" class="form-control" required placeholder="Where should we send the food?"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Contact Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="Cash">Cash on Delivery</option> 
                            <option value="Card">Card Payment</option>
                            <option value="Online">Online Transfer</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <button class="btn btn-danger btn-lg w-100 rounded-pill fw-bold" type="submit">Place Order</button>
            </form>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>