<?php 
// Removed checkLogin() from here because the Controller handles it now.
include '../includes/header.php'; 
?>

<div class="container">
     <br> <br> <br>
    <h1>Dashboard</h1>
    <section class="profile-card">
        <h3>User Profile (Loaded via SP)</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($userData['role']); ?></p>
    </section>
</div>

<?php include '../includes/footer.php'; ?>