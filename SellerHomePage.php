
<?php
session_start();
include 'connectionfile.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sellerLogin.php');
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email, joined_date FROM users WHERE id = ? AND account_type = 'seller'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $joinedDate);
$stmt->fetch();
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Seller</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">

    <link rel="stylesheet" href="SellerHomePage.css">
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
                <li><a href="SellerHomePage.php" class="active">Home</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome Back, Seller!</h1>
            <p>Manage your products, track sales, and grow your business with GalaxyShop.</p>
            <a href="add-product.php" class="cta-button">Add New Product</a>
        </div>
    </section>

 
    <main>
     <!-- About Us Starting -->
<section class="about-us">
    <div class="about-content">
        <div class="text-content">
            <h2 class="fade-in-from-top">About Us</h2>
            <p class="fade-in-from-left">
                Welcome to <span class="highlight">Galaxy</span> Shop! As a valued seller, you're part of our mission to bring the best products from across the galaxy to our customers. We are committed to providing you with a powerful platform and exceptional support to help you succeed. Discover how we can work together to make your business thrive in the e-commerce universe.
            </p>
            <button class="cta-button fade-in-from-left" onclick="window.location.href='SellerAboutUs.php'">Learn More</button>
        </div>
        <div class="image-content fade-in-from-bottom">
            <img src="AboutUsHome.png" alt="About Us Image"> 
        </div>
    </div>
</section>
<!-- About Us Ending -->





<!-- Seller Support Services Starting -->
<section class="support-services">
    <div class="support-content">
        <h2 class="fade-in">How GalaxyShop Supports Sellers</h2>
        <p class="fade-in">At GalaxyShop, we provide a range of services and tools designed to help sellers succeed. Our platform offers comprehensive support to streamline your selling experience, from managing your products to analyzing sales performance.</p>
        <div class="services-images">
            <div class="service-item fade-in">
                <img src="service1.png" alt="Service 1">
                <div class="service-text">
                    <h3>Product Management</h3>
                    <p>Effortlessly manage your product listings, update inventory, and track your sales with our intuitive dashboard.</p>
                </div>
            </div>
            <div class="service-item fade-in">
                <img src="service2.png" alt="Service 2">
                <div class="service-text">
                    <h3>Sales Analytics</h3>
                    <p>Get detailed insights into your sales performance with comprehensive analytics and reporting tools.</p>
                </div>
            </div>
            <div class="service-item fade-in">
                <img src="service3.png" alt="Service 3">
                <div class="service-text">
                    <h3>Promotions & Discounts</h3>
                    <p>Create and manage promotions and discounts to boost your sales and attract more customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Seller Support Services Ending -->

<!-- Partners & Affiliates Section Starting -->
<section class="partners">
    <h2>Our Trusted Partners</h2>
    <div class="partners-container">
        <div class="partner-item">
            <img src="daraz.png" alt="Partner 1">
            <p>Daraz</p>
        </div>
        <div class="partner-item">
            <img src="amazaon.png" alt="Partner 2">
            <p>Amazaon</p>
        </div>
        <div class="partner-item">
            <img src="flipkart.png" alt="Partner 3">
            <p>Flipkart</p>
        </div>
        <div class="partner-item">
            <img src="meesho.png" alt="Partner 4">
            <p>Meesho</p>
        </div>
        <div class="partner-item">
            <img src="aliexpress.png" alt="Partner 5">
            <p>Ali Express</p>
        </div>
    </div>
</section>
<!-- Partners & Affiliates Section Ending -->

<!-- Seller CTA Section Starting -->
<section class="SellerCta">
    <div class="SellerCta-content">
        <div class="SellerCta-text">
            <h2>How You Can Help Us</h2>
            <p>At GalaxyShop, we are always looking for new and exciting products to offer our customers. By adding your products to our platform, you can reach a wider audience and grow your business. Join us today and be part of our thriving marketplace!</p>
            <a href="add-product.php" class="SellerCta-button">Add Your Products</a>
        </div>
        <div class="SellerCta-image">
            <img src="sellercta.png" alt="CTA Image">
        </div>
    </div>
</section>
<!-- Seller CTA Section Ending -->
<!-- How We Can Help You Section Starting -->
<section class="HelpUs">
    <div class="HelpUs-content">
        <div class="HelpUs-image">
            <img src="howwehelp.png" alt="Help Us Image">
        </div>
        <div class="HelpUs-text">
            <h2>How We Can Help You</h2>
            <p>Our goal is to provide you with the best tools and support to make your selling experience as smooth as possible. From marketing assistance to customer support, we’re here to help you succeed. Contact us today to learn more about how we can assist you.</p>
            <a href="Sellercontactus.php" class="HelpUs-button">Contact Us</a>
        </div>
    </div>
</section>
<!-- How We Can Help You Section Ending -->
 <!-- Start Selling Starting -->
<section class="about-us">
    <div class="about-content">
        <div class="text-content">
            <h2 class="fade-in-from-top">Let’s Start Selling!</h2>
            <p class="fade-in-from-left">
                Welcome to <span class="highlight">Galaxy</span> Shop! Ready to reach a broader audience and grow your business? Our platform offers you the perfect opportunity to showcase your products to customers across the galaxy. Join us today and become a part of our thriving marketplace.
            </p>
            <button class="cta-button fade-in-from-left" onclick="window.location.href='add-product.php'">Add Your Products</button>
        </div>
        <div class="image-content fade-in-from-bottom">
            <img src="Startselling.png" alt="About Us Image"> 
        </div>
    </div>
</section>
<!-- Start Selling  Ending -->


    </main>

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
    const fadeInElements = document.querySelectorAll('.SellerCta-text, .HelpUs-text');
    const slideInElements = document.querySelectorAll('.SellerCta-image img, .HelpUs-image img');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('SellerCta-text') || entry.target.classList.contains('HelpUs-text')) {
                    entry.target.classList.add('fade-in');
                } else if (entry.target.classList.contains('SellerCta-image img')) {
                    entry.target.classList.add('slide-in-right');
                } else if (entry.target.classList.contains('HelpUs-image img')) {
                    entry.target.classList.add('slide-in-left');
                }
            }
        });
    }, {
        threshold: 0.1
    });

    fadeInElements.forEach(element => {
        observer.observe(element);
    });

    slideInElements.forEach(element => {
        observer.observe(element);
    });
});


        // Seller CTA Starting

        document.addEventListener("DOMContentLoaded", () => {
    const fadeInElements = document.querySelectorAll('.SellerCta-text');
    const slideInElements = document.querySelectorAll('.SellerCta-image img');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('SellerCta-text')) {
                    entry.target.classList.add('fade-in');
                } else if (entry.target.classList.contains('SellerCta-image img')) {
                    entry.target.classList.add('slide-in-right');
                }
            }
        });
    }, {
        threshold: 0.1
    });

    fadeInElements.forEach(element => {
        observer.observe(element);
    });

    slideInElements.forEach(element => {
        observer.observe(element);
    });
});

        // Seller CTA Ending



        // CTA Starting
document.addEventListener('DOMContentLoaded', function() {
    const ctaElements = document.querySelectorAll('.cta h2, .cta p, .cta-button');
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    };
    
    const observer = new IntersectionObserver(observerCallback, observerOptions);
    
    ctaElements.forEach(el => {
        observer.observe(el);
    });
});

// CTA Ending


// About Us Starting
document.addEventListener('DOMContentLoaded', function() {
        const elementsToShow = document.querySelectorAll('.text-content, .image-content, .cta-button');
    
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
    
        function handleScroll() {
            elementsToShow.forEach(el => {
                if (isElementInViewport(el)) {
                    el.style.opacity = 1;
                    el.style.animationPlayState = 'running'; 
                }
            });
        }
    
        window.addEventListener('scroll', handleScroll);
        handleScroll(); 
    });
// About Us Ending


// Services Starting

document.addEventListener("DOMContentLoaded", () => {
    const fadeInElements = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-visible');
            }
        });
    }, {
        threshold: 0.1
    });

    fadeInElements.forEach(element => {
        observer.observe(element);
    });
});
// Services Ending


    </script>
</body>
</html>
