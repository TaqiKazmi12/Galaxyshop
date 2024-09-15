<?php
session_start();
include 'connectionfile.php'; 
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
   

    $email = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT name, email, joined_date, account_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($name, $email, $joinedDate, $accountType);
        $stmt->fetch();
    } else {
    
        $error = 'User data not found.';
    }

    $stmt->close();
} else {
    header('Location: UserLogin.php');
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Profile</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">

</head>
<body>
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
                        <?php if ($isLoggedIn): ?>
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
        <h1>Welcome to Your Profile</h1>
        <p>Manage your account settings, view your orders, and update your information from this page.</p>
    </header>

    <div class="profile-info">
        <h2>Account Details</h2>
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Joined:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($joinedDate))); ?></p>
            <p class="account-type"><strong>Account Type:</strong> <?php echo htmlspecialchars($accountType); ?></p>
        </div>
        <button class="blackcolored" class="my-orders-button" onclick="window.location.href='orders.php'">My Orders</button>
        <button class="blackcolored" onclick="window.location.href='edit_profile.php'">Edit Profile</button>
        <button class="blackcolored" onclick="window.location.href='manage_payment.php'">Payment Methots</button>
        <button class="blackcolored" class="logout-button" onclick="window.location.href='logout.php'">Log Out</button>
    </div>
<style>
    .blackcolored{
        color:black !Important;
    }
</style>
    <div class="profile-sections">

    
        <div class="saved-items">
            <h3>My Cart</h3>
            <p>View and manage your cart  items.</p>
            <button  class="my-orders-button blackcolored" onclick="window.location.href='cart.php'">View</button>
        </div>
    </div>
<style>
    .saved-items{
        margin-left:30px;
    }
</style>
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
</body>
</html>
