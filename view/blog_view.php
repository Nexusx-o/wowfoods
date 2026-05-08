<div class="container">
    <h2>Latest Recipes</h2>
    <?php while($row = mysqli_fetch_assoc($posts)): ?>
        <div class="recipe-card">
            <h3><?php echo $row['title']; ?></h3>
            <p>Category: <strong><?php echo $row['category']; ?></strong></p>
            <p><?php echo substr($row['excerpt'], 0, 100); ?>...</p>
            <a href="post.php?id=<?php echo $row['id']; ?>">Read More</a>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>