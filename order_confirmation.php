<?php
session_start();
include 'connectionfile.php'; 

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    die('User not logged in.');
}


$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($order_id <= 0) {
    die('Invalid order ID.');
}

$query = "SELECT o.total, o.address, o.contact_number, o.payment_method, o.status, p.name AS product_name, p.price
          FROM orders o
          JOIN products p ON o.product_id = p.id
          WHERE o.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    die('Order not found.');
}

$order = $order_result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Order Confirmation</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
</head>
<body>
    <style>
        .nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
    margin-top: 30px;
    display: flex;
    gap: 15px;
}
.profile-toggle {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 20px;
    color: #ffffff;
    transition: color 0.3s ease;
    top: 20;
    margin-top: -21px;
}
    </style>
<div class="cursor"></div>

    <!-- Navbar Starting -->
    <header>
        <nav class="navbar">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <div class="logo">
                <img src="Logo.png" alt="MyLogo" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="Home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="AboutUs.php">About Us</a></li>
                <li><a href="ContactUs.php">Contact Us</a></li>
                <li class="profile-container">
                    <button class="profile-toggle"><i class="fas fa-user"></i></button>
                    <div class="profile-dropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="profile.php">Profile</a>
                            <a href="logout.php">Logout</a>
                        <?php else: ?>
                            <a href="UserSignUp.php">Sign Up</a>
                            <a href="UserLogin.php">Log In</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
             <div class="search-container">
            <form action="searched.php" method="GET">
                <input type="text" name="query" placeholder="Search..." required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        </nav>
    </header>
    <!-- Navbar Ending -->

    <header class="ProfileHeader">
        <h1>Order Confirmation</h1>
        <p>Thank you for your purchase!</p>
    </header>

    <div class="order-info">
        <h2>Order Details</h2>
        <div class="order-details">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($order['price'], 2); ?></p>
            <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($order['contact_number']); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($order['status'])); ?></p>
        </div>
        <button onclick="window.location.href='Home.php'">Return to Home</button>
    </div>

    <!-- Footer Starting -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <img src="Logo.png" alt="GalaxyShop Logo" class="footer-logo">
                <p class="footer-description">GalaxyShop brings the best of the galaxy to your doorstep with a wide range of products and exceptional service.</p>
            </div>
            <div class="footer-links">
                <div class="links-section">
                    <h3>GalaxyShop</h3>
                    <ul>
                        <li><a href="Home.php">Home</a></li>
                        <li><a href="AboutUs.php">About</a></li>
                        <li><a href="ContactUs.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="links-section">
                    <h3>Products</h3>
                    <ul>
                        <li><a href="products.php">Our Products</a></li>
                    </ul>
                </div>
            </div>
            <div class="newsletter">
                <h3>Newsletter</h3>
                <form action="subscribe.php" method="POST">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </footer>
    <!-- Footer Ending -->

    <script src="Navbar.js"></script>
    <style>
       
.order-info {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.order-info h2 {
    margin-top: 0;
    font-size: 22px;
    color: #333;
}

.order-details {
    margin: 20px 0;
}

.order-details p {
    font-size: 16px;
    line-height: 1.6;
    margin: 10px 0;
    color:black;
}

.order-details strong {
    color: whi;
}


button {
    background-color: #ffd700; 
    border: none;
    color: #333;
    padding: 15px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

button:hover {
    background-color: #ffcc00; 
    transform: scale(1.05);
}

button:focus {
    outline: none;
}

    </style>
</body>
</html>
