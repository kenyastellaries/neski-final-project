<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'client'; // Default role is client

    // Insert user into the database
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Registration successful! Please log in.";
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Neski Gifts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="branding">
                <img src="images/logo neski.jpg" alt="Neski Gifts Logo" class="logo">
                <h1>Neski Gifts - Register</h1>
            </div>
        </div>
    </header>

    <main class="container">
        <h2>Register</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="cta-button">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </main>

    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <img src="images/logo neski.jpg" alt="Neski Gifts Logo" class="footer-logo">
                <p>&copy; <?php echo date('Y'); ?> Neski Gifts. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>