<?php 

include('../includes/header.php'); 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h4 class="fw-bold mb-0"><i class="fas fa-shopping-basket text-danger me-2"></i> Your Cart</h4>
                </div>
                <div class="card-body p-0">
                    <form action="../Controller/cart_view_controller.php" method="POST">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($_SESSION['cart'])): ?>
                                    <?php foreach ($_SESSION['cart'] as $id => $item): 
                                        $subtotal = $item['price'] * $item['qty'];
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="../assets/images/food/<?php echo htmlspecialchars($item['image'] ?? 'default-food.jpg'); ?>" 
                                                class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <span class="fw-bold"><?php echo htmlspecialchars($item['title'] ?? 'Default Food'); ?></span>
                                            </div>
                                        </td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td>
                                            <input type="number" name="qty[<?php echo $id; ?>]" 
                                                   value="<?php echo $item['qty']; ?>" 
                                                   class="form-control form-control-sm" style="width: 70px;" min="1">
                                        </td>
                                        <td class="text-danger fw-bold">$<?php echo number_format($subtotal, 2); ?></td>
                                        <td class="text-end pe-4">
                                            <a href="../Controller/cart_view_controller.php?remove=<?php echo $id; ?>" class="text-muted"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <p class="text-muted">Your cart is empty.</p>
                                            <a href="menu_controller.php" class="btn btn-danger rounded-pill px-4">Browse Menu</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                        <?php if (!empty($_SESSION['cart'])): ?>
                        <div class="p-3 text-end">
                            <button type="submit" name="update_qty" class="btn btn-sm btn-outline-dark rounded-pill px-4">Update Cart</button>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span class="fw-bold">$<?php echo number_format($grand_total, 2); ?></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="h5 fw-bold">Total</span>
                    <span class="h5 fw-bold text-danger">$<?php echo number_format($grand_total, 2); ?></span>
                </div>
                <a href="../Controller/checkout_view_controller.php" class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow-sm">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>