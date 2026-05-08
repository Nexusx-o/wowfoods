<?php 
include('../includes/header.php'); 
?>

<div class="container py-5" style="margin-top: 50px;">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">My <span class="text-danger">Orders</span></h2>
            <p class="text-muted">Track your recent purchases and delivery status.</p>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th class="text-end pe-4">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?php echo $row['id']; ?></td>
                                    <td class="small text-muted"><?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></td>
                                    <td class="fw-bold text-danger">$<?php echo number_format($row['total_amount'], 2); ?></td>
                                    <td>
                                        <?php 
                                        $status = $row['status'];
                                        $badge_class = 'bg-warning text-dark'; 
                                        if($status == 'Delivered') $badge_class = 'bg-success';
                                        if($status == 'Cancelled') $badge_class = 'bg-danger';
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?> rounded-pill"><?php echo htmlspecialchars($status); ?></span>
                                    </td>
                                    <td>
                                        <small class="d-block fw-bold"><?php echo htmlspecialchars($row['payment_method']); ?></small>
                                        <span class="small text-muted"><?php echo htmlspecialchars($row['payment_status']); ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3 view-receipt-btn" 
                                            data-id="<?php echo $row['id']; ?>"
                                            data-date="<?php echo date('d M Y', strtotime($row['created_at'])); ?>"
                                            data-total="<?php echo number_format($row['total_amount'], 2); ?>"
                                            data-address="<?php echo htmlspecialchars($row['delivery_address']); ?>"
                                            data-payment="<?php echo htmlspecialchars($row['payment_method']); ?>">
                                            View Receipt
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-0" id="receipt-content">
                <div class="p-5 text-center">
                    <h3 class="fw-bold text-danger mb-1">WOWFOOD</h3>
                    <p class="text-muted small">Deliciousness Delivered</p>
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Order ID:</span>
                        <span class="fw-bold" id="modal-order-id">#000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 small">
                        <span class="text-muted">Date:</span>
                        <span id="modal-order-date">--</span>
                    </div>

                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div id="items-loader" class="text-muted small py-2">
                            <i class="fas fa-spinner fa-spin me-1"></i> Loading items...
                        </div>
                        <table class="table table-sm table-borderless mb-0 text-start small" id="modal-items-table"></table>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4 text-start small border">
                        <p class="mb-1 fw-bold text-muted">Delivery Address:</p>
                        <p class="mb-0 text-dark" id="modal-address">--</p>
                        <p class="mt-2 mb-0 fw-bold text-muted">Payment: <span class="text-dark fw-normal" id="modal-payment">--</span></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-4">
                        <h5 class="fw-bold mb-0">Total Paid</h5>
                        <h4 class="fw-bold text-danger mb-0" id="modal-total">$0.00</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger rounded-pill px-4" id="download-pdf" disabled>
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.querySelectorAll('.view-receipt-btn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.dataset.id;
        const downloadBtn = document.getElementById('download-pdf');
        
        //  Filling static data in the modal
        document.getElementById('modal-order-id').innerText = '#' + orderId;
        document.getElementById('modal-order-date').innerText = this.dataset.date;
        document.getElementById('modal-total').innerText = '$' + this.dataset.total;
        document.getElementById('modal-address').innerText = this.dataset.address;
        document.getElementById('modal-payment').innerText = this.dataset.payment;

        const table = document.getElementById('modal-items-table');
        const loader = document.getElementById('items-loader');
        
        table.innerHTML = ''; 
        loader.style.display = 'block';
        downloadBtn.disabled = true; // Disabling the PDF button until items are loaded

        //  AJAX call 
        fetch('../Controller/get_order_item_controller.php?order_id=' + orderId)
            .then(response => response.json())
            .then(data => {
                loader.style.display = 'none';
                if(data.length > 0) {
                    data.forEach(item => {
                        const row = `<tr>
                            <td>${item.quantity}x ${item.title}</td>
                            <td class="text-end fw-bold">$${parseFloat(item.subtotal).toFixed(2)}</td>
                        </tr>`;
                        table.innerHTML += row;
                    });
                    downloadBtn.disabled = false; // Enabling the PDF button after receiving items
                } else {
                    table.innerHTML = '<tr><td colspan="2" class="text-center py-2">No items found for this order.</td></tr>';
                }
            })
            .catch(err => {
                loader.innerHTML = '<span class="text-danger">Error loading items.</span>';
                console.error('Fetch error:', err);
            });

        const myModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        myModal.show();
    });
});

// PDF Generation
document.getElementById('download-pdf').addEventListener('click', function() {
    const element = document.getElementById('receipt-content');
    const orderId = document.getElementById('modal-order-id').innerText;
    
    const opt = {
        margin: 0.5,
        filename: 'WOWFOOD-Receipt-' + orderId + '.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, logging: false, useCORS: true },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    
    html2pdf().set(opt).from(element).save();
});
</script>

<?php include('../includes/footer.php'); ?>