

<?php
session_start();
include 'connectionfile.php'; 


if (!isset($_SESSION['seller_id'])) {
    die("Seller ID is not set in session.");
}

$seller_id = $_SESSION['seller_id'];
$sql = "SELECT * FROM Products WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | My Products</title>
    <link rel="stylesheet" href="SellerProductPage.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
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
                <li><a href="SellerHomePage.php">Home</a></li>
                <li><a href="SellerProductPage.php" class="active">My Products</a></li>
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

    <!-- Products Section Starting -->
    <section class="products-section">
        <h1 class="fade-in-from-top">My Products</h1>
        <div class="products-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                
                    $image_url = 'uploads/' . basename($row['image_url']);
                    echo '<div class="product-card fade-in">';
                    echo '<img src="' . htmlspecialchars($image_url) . '" alt="' . htmlspecialchars($row['name']) . '" onerror="this.src=\'default-image.png\'">'; 
                    echo '<div class="product-info">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<a href="SellerProductDetails.php?id=' . $row['id'] . '" class="cta-button">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-products-message fade-in">';
                echo '<p>No products added or not found.</p>';
                echo '<a href="add-product.php" class="add-more-button">Add More</a>';
                echo '</div>';
            }
            ?>
          
        </div>
        <div class="add-more-container fade-in">
                <a href="add-product.php" class="add-more-button">Add More Products</a>
            </div>
    </section>
    <!-- Products Section Ending -->

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

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const fadeInElements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1
            });

            fadeInElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
    <style>
      .footer {
    background-color: #000041;
    color: #ffffff;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    margin-top: 185px;
}
body{
    background: #000041;
}
    </style>
</body>
</html>

<?php

$conn->close();
?>
