<?php include('../includes/header.php'); 
      

?>

<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="row">
            
            <aside class="col-lg-2 mb-4">
                <div class="card shadow-sm border-0 rounded-4 p-3 sticky-top" style="top: 100px;">
                    <h6 class="fw-bold mb-3 text-uppercase small">Categories</h6>
                    <ul class="list-group list-group-flush small">
                        <a href="menu_view.php" class="list-group-item list-group-item-action border-0 <?php echo $category_id == 0 ? 'text-danger fw-bold' : ''; ?>">All</a>
                        
                        <?php foreach($categories as $cat): ?>
                        <a href="menu_view.php?cat_id=<?php echo $cat['id']; ?>" 
                           class="list-group-item list-group-item-action border-0 <?php echo $category_id == $cat['id'] ? 'text-danger fw-bold' : ''; ?>">
                            <?php echo htmlspecialchars($cat['title']); ?>
                        </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <div class="col-lg-7">
                <h2 class="fw-bold mb-4">Our <span class="text-danger">Menu</span></h2>
                <div class="row g-4">
                    
                    <?php foreach($foods as $food): 
                        $image_name = !empty($food['image_name']) ? $food['image_name'] : 'default-food.jpg';
                        $description = (string) ($food['description'] ?? '');
                    ?>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden food-card">
                            <img src="../assets/images/food/<?php echo htmlspecialchars($image_name); ?>" 
                                 class="card-img-top" 
                                 style="height: 160px; object-fit: cover;" 
                                 alt="<?php echo htmlspecialchars($food['title']); ?>">
                            
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($food['title']); ?></h6>
                                <p class="text-muted small mb-2">
                                    <?php echo htmlspecialchars(substr($description, 0, 50)); ?>
                                    <?php echo strlen($description) > 50 ? '...' : ''; ?>
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-danger fw-bold">$<?php echo number_format($food['price'], 2); ?></span>
                                    
                                    <form action="../Controller/menu_view_controller.php" method="POST">
                                        <input type="hidden" name="food_id" value="<?php echo $food['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">+ Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <aside class="col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-3">
                        <h5 class="fw-bold mb-3"><i class="fas fa-shopping-cart text-danger"></i> Your Order</h5>
                        <hr>
                        
                        <?php 
                        $total = 0;
                        if (!empty($_SESSION['cart'])): 
                            foreach ($_SESSION['cart'] as $id => $item): 
                                $subtotal = $item['price'] * $item['qty'];
                                $total += $subtotal;
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="small">
                                <p class="mb-0 fw-bold"><?php echo htmlspecialchars($item['title']); ?></p>
                                <span class="text-muted"><?php echo $item['qty']; ?> x $<?php echo number_format($item['price'], 2); ?></span>
                            </div>
                            <div class="text-end">
                                <p class="mb-0 small fw-bold">$<?php echo number_format($subtotal, 2); ?></p>
                                <a href="menu_view.php?remove=<?php echo $id; ?>" class="text-danger small">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold mb-3">
                            <span>Total:</span>
                            <span class="text-danger">$<?php echo number_format($total, 2); ?></span>
                        </div>

                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <a href="../Controller/cart_view_controller.php" class="btn btn-danger w-100 rounded-pill fw-bold">Show Cart</a>
                        <?php else: ?>
                            <a href="../login.php" class="btn btn-dark w-100 rounded-pill fw-bold">Login to Order</a>
                        <?php endif; ?>

                        <?php else: ?>
                            <p class="text-center text-muted py-4">Your cart is empty.</p>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>