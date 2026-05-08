<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link href='https://fonts.googleapis.com/css2?family=Poppins&display=swap' rel='stylesheet'>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Order Placed!',
            text: 'Your order has been successfully received.',
            icon: 'success',
            confirmButtonColor: '#e63946',
            confirmButtonText: 'Go to Dashboard'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../Controller/customer_dashboard_controller.php';
            }
        });
    </script>
</body>
</html>