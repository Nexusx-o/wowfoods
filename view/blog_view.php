<div class="container">
    <h1>Welcome to WowFoods</h1>
    <div class="grid">
        <?php while($row = mysqli_fetch_assoc($posts)): ?>
            <div class="card">
                <img src="images/<?php echo $row['image_url']; ?>">
                <h2><?php echo $row['title']; ?></h2>
                <p><?php echo $row['excerpt']; ?></p>
                <a href="post.php?id=<?php echo $row['id']; ?>">View Recipe</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>