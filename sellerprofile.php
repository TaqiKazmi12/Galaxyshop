<?php
session_start();
include 'connectionfile.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sellerLogin.php'); 
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email, joined_date, account_type FROM users WHERE id = ? AND account_type = 'seller'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo 'No seller data found or you do not have the correct access.';
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->bind_result($name, $email, $joinedDate, $accountType);
$stmt->fetch();
$stmt->close();
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
                <li><a href="SellerHomePage.php" >Home</a></li>
                <li><a href="SellerProductPage.php">My Products</a></li>
                <li><a href="SellerAboutUs.php">About Us</a></li>
                <li><a href="SellercontactUs.php">Contact Us</a></li>
                <li class="profile-container">
                    <button class="profile-toggle"><i class="fas fa-user"></i></button>
                    <div class="profile-dropdown">
                        <a href="sellerprofile.php">Profile</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                </li>
            </ul>
          
        </nav>
    </header>
    <!-- Navbar Ending -->

    <header class="ProfileHeader">
        <h1>Welcome to Your Profile Seller</h1>
        <p>Manage your account settings, view your Products, and update your information from this page.</p>
    </header>

    <div class="profile-info">
        <h2>Account Details</h2>
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Joined:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($joinedDate))); ?></p>
            <p class="account-type"><strong>Account Type:</strong> <?php echo htmlspecialchars($accountType); ?></p>
        </div>
        <button class="my-orders-button" onclick="window.location.href='SellerProductPage.php'">My Products</button>
        <button onclick="window.location.href='edit_profile.php'">Edit Profile</button>
        <button class="logout-button" onclick="window.location.href='logout.php'">Log Out</button>
    </div>



    <!-- Footer Starting -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <img src="Logo.png" alt="GalaxyShop Logo" class="footer-logo">
                <p class="footer-description">GalaxyShop empowers sellers to reach a global audience with ease and efficiency, offering a comprehensive platform for all your e-commerce needs.</p>
            </div>
            <div class="footer-links">
                <div class="links-section">
                    <h3>Seller Resources</h3>
                    <ul>
                        <li><a href="SellerHomePage.php">My Products</a></li>
                        <li><a href="SellerSupport.php">Seller Support</a></li>
                        <li><a href="SellerAccount.php">Account Settings</a></li>
                    </ul>
                </div>
                <div class="links-section">
                    <h3>GalaxyShop</h3>
                    <ul>
                        <li><a href="Home.php">Home</a></li>
                        <li><a href="SellerAboutUs.php">About Us</a></li>
                        <li><a href="SellerContactUs.php">Contact Us</a></li>
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
