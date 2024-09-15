<?php
session_start();
include 'connectionfile.php'; 

$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | About Us</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="AboutUs.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">

</head>
<body>
<script>
 
      function handleCheckOutClick() {
            <?php if ($isLoggedIn): ?>
                window.location.href = "ProductInnerPage.php";
            <?php else: ?>
                window.location.href = "UserSignUp.php";
            <?php endif; ?>
        }

</script>
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
                <li><a href="SellerProductPage.php" >My Products</a></li>
                <li><a href="SellerAboutUs.php" class="active"  >About Us</a></li>
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

<!-- Header Starting -->
<section class="AboutUsheader">
    <div class="AboutUsheader-content">
        <h1>About <span>Galaxy</span>Shop</h1>
        <p>Welcome to GalaxyShop! We are dedicated to bringing you the best products from across the galaxy, right to your doorstep. Our team is passionate about providing exceptional service and ensuring that you have an out-of-this-world shopping experience. Discover more about our mission, values, and what sets us apart as you explore our site.</p>
    </div>
</section>
<!-- Header Ending -->
<!-- About Section Starting -->
<section class="About">
    <div class="About-content">
        <div class="About-text">
            <h2>Our Story</h2>
            <p>At GalaxyShop, our journey began with a simple mission: to offer unique and high-quality products from across the galaxy to our customers. We pride ourselves on our exceptional customer service and dedication to making your shopping experience extraordinary. Explore our diverse range of products and learn more about our commitment to excellence.</p>
        </div>
        <div class="About-image">
            <img src="AboutUsPageImage.png" alt="GalaxyShop" />
        </div>
    </div>
</section>
<!-- About Section Ending -->

<!-- Mission and Values Section Starting -->
<section class="MissionValues">
    <div class="MissionValues-content">
        <h2>Our Mission</h2>
        <p>At GalaxyShop, our mission is to provide customers with the highest quality products from across the galaxy, ensuring an exceptional shopping experience. We are committed to innovation, excellence, and delivering unparalleled value to our customers.</p>
    </div>
    <div class="MissionValues-content">
        <h2>Our Values</h2>
        <ul>
            <li>Customer-Centric: We put our customers first in everything we do.</li>
            <li>Integrity: We conduct our business with honesty and transparency.</li>
            <li>Innovation: We strive for continuous improvement and embrace new ideas.</li>
            <li>Quality: We are dedicated to providing high-quality products and services.</li>
            <li>Sustainability: We are committed to environmentally responsible practices.</li>
        </ul>
    </div>
</section>
<!-- Mission and Values Section Ending -->



     <!-- Footer Ending -->
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
                        <li><a href="SellerProductPage.php">My Products</a></li>
                        <li><a href="SellerSupport.php">Seller Support</a></li>
                        <li><a href="sellerprofile.php">Account Settings</a></li>
                    </ul>
                </div>
                <div class="links-section">
                    <h3>GalaxyShop</h3>
                    <ul>
                        <li><a href="SellerHomePage.php">Home</a></li>
                        <li><a href="SellerAboutUs.php">About Us</a></li>
                        <li><a href="SellercontactUs.php">Contact Us</a></li>
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
</php>