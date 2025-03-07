<?php
session_start();
include 'config.php';

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
} else {
    // Handle query error
    echo "<p>Error fetching products: " . $conn->error . "</p>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neski Gifts - Unique Presents Online</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/jpg" href="images/logo neski.jpg">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="branding">
                <img src="images/logo neski.jpg" alt="Neski Gifts Logo" class="logo">
                <h1>Neski Gifts</h1>
            </div>
            <nav class="main-nav">
    <ul>
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="#products">Products</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="cart.php" class="cart-link">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a href="admin.php">Admin Panel</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Beautiful Gifts for Every Occasion</h2>
            <p>Handcrafted with care, delivered with love</p>
        </div>
    </section>

    <main class="container" id="products">
        <h2 class="section-title">Our Featured Gifts</h2>
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="product-details">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                            <form action="add_to_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="cta-button">Add to Cart</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <div class="admin-section">
                <h2>Admin Controls</h2>
                <p>Manage products, orders, and users.</p>
                <a href="admin.php" class="cta-button">Go to Admin Panel</a>
            </div>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <img src="images/logo neski.jpg" alt="Neski Gifts Logo" class="footer-logo">
                <p>&copy; <?php echo date('Y'); ?> Neski Gifts. All rights reserved.</p>
                <div class="social-links">
                    <a href="#"><img src="images/facebook-icon.png" alt="Facebook"></a>
                    <a href="#"><img src="images/instagram-icon.png" alt="Instagram"></a>
                    <a href="#"><img src="images/twitter-icon.png" alt="Twitter"></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>