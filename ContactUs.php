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
    <title>GalaxyShop | Contact Us</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="ContactUs.css">
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
    <!-- Navbar Starting -->
   
     <header>
        <nav class="navbar">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <div class="logo">
                <img src="Logo.png" alt="MyLogo" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="Home.php"  >Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="AboutUs.php"   >About Us</a></li>
                <li><a href="ContactUs.php" class="active">Contact Us</a></li>
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

    <!-- Contact Us Header -->
    <section class="ContactUsheader">
        <div class="ContactUsheader-content">
            <h1>Contact <span>Galaxy</span>Shop</h1>
            <p>We're here to help! Reach out to us with any questions or concerns you may have, and we'll get back to you as soon as possible. Your satisfaction is our priority.</p>
        </div>
    </section>
    <!-- Contact Us Header End -->

    <!-- Contact Details Section -->
    <section class="ContactDetails">
        <div class="ContactDetails-content">
            <h2>Contact Information</h2>
            <p>Email: <a href="mailto:support@galaxyshop.com">support@galaxyshop.com</a></p>
            <p>Phone: +1 (234) 567-8901</p>
            <p>Address: 123 Galaxy Street, Space City, ST 45678</p>
        </div>
    </section>
    <!-- Contact Details Section End -->

    <!-- Map Section -->
    <section class="ContactMap">
        <div class="ContactMap-content">
            <h2>Our Location</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.6613085165474!2d-122.40828118468115!3d37.78341067975814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808a2f258d7d%3A0xd5d4528e3c7ed2c0!2sGoogleplex!5e0!3m2!1sen!2sus!4v1629397821077!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
    <!-- Map Section End -->

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
    <div class="cursor"></div>
</body>
                </html>
