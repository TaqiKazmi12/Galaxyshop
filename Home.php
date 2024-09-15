
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
    <title>GalaxyShop | Home</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">

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
            <li><a href="Home.php" class="active">Home</a></li>
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


<!-- Header Starting -->
<header class="Header2">
    <div class="header-content">
        <h1>Welcome to <span>Galaxy</span>Shop</h1>
        <p>From the Galaxy to Your Doorstep</p>
        <button class="cta-button" onclick="window.location.href='GetStarted.php'" >Get Started</button>
    </div>
</header>
<!-- Header Ending -->

<!-- About Us Starting -->
<section class="about-us">
    <div class="about-content">
        <div class="text-content">
            <h2 class="fade-in-from-top">About Us</h2>
            <p class="fade-in-from-left">
                Welcome to <span class="highlight">Galaxy</span> Shop! We are dedicated to bringing you the best products from across the galaxy, all delivered right to your doorstep. Our team is passionate about quality and customer satisfaction, and we strive to offer a seamless shopping experience. Explore our range and discover why we are the top choice for all your needs.
            </p>
            <button class="cta-button fade-in-from-left"  onclick="window.location.href='AboutUs.php'" >Learn More</button>
        </div>
        <div class="image-content fade-in-from-bottom">
            <img src="AboutUsHome.png" alt="About Us Image"> 
        </div>
    </div>
</section>
<!-- About Us Ending -->



<!-- Products Section Starting -->
<section class="products">
    <div class="products-bg">
        <h2>Our Products</h2>
        <div class="product-grid">
            <!-- Product Card -->
            <div class="product-card">
                <img src="Galaxy Pro Headphones.png" alt="Product 1">
                <div class="product-info">
                    <h3>Galaxy Pro Headphones</h3>
                    <p>Experience high-quality sound with the Galaxy Pro Headphones. Equipped with noise-cancellation technology and a comfortable fit for extended listening.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card">
                <img src="Stellar 4K Monitor.jpeg" alt="Product 2">
                <div class="product-info">
                    <h3>Stellar 4K Monitor</h3>
                    <p>Upgrade your workspace with the Stellar 4K Monitor. Enjoy vibrant colors and sharp details with a sleek design that's perfect for both work and play.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card">
                <img src="Quantum X Smartphone.jpg" alt="Product 3">
                <div class="product-info">
                    <h3>Quantum X Smartphone</h3>
                    <p>The Quantum X Smartphone combines cutting-edge technology with a sleek design. Enjoy a powerful performance, stunning display, and advanced camera features.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card">
                <img src="Nova Fitness Tracker.png" alt="Product 4">
                <div class="product-info">
                    <h3>Nova Fitness Tracker</h3>
                    <p>Stay on top of your health and fitness goals with the Nova Fitness Tracker. Monitor your activity, sleep, and heart rate with real-time data and personalized insights.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card">
                <img src="Astral Wireless Speaker.png" alt="Product 5">
                <div class="product-info">
                    <h3>Astral Wireless Speaker</h3>
                    <p>Enjoy rich and clear sound with the Astral Wireless Speaker. Compact and portable, it's perfect for taking your music anywhere with Bluetooth connectivity.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card">
                <img src="Cosmic Gaming Mouse.jpg" alt="Product 6">
                <div class="product-info">
                    <h3>Cosmic Gaming Mouse</h3>
                    <p>Enhance your gaming experience with the Cosmic Gaming Mouse. Featuring customizable buttons, a high-precision sensor, and ergonomic design for comfort during long sessions.</p>
                    <a href="products.php" class="cta-button">View More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Products Section Ending -->


<!-- CTA Section Starting -->
<section class="cta">
    <div class="cta-content">
        <h2>Ready to Shop?</h2>
        <p>Explore our wide range of products and find what you're looking for. Click below to view all our offerings and make your purchase today!</p>
        <a href="products.php" class="cta-button">Shop Now</a>
    </div>
</section>
<!-- CTA Section Ending -->


<!-- Testimonials Section Starting -->
<section class="testimonials">
    <div class="testimonials-content">
        <h2>What Our Customers Say</h2>
        <div class="testimonial-grid">
            <!-- Testimonial Card -->
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"The Galaxy Shop has the best selection of tech products! I love the fast shipping and excellent customer service."</p>
                </div>
                <div class="testimonial-author">
                    <h3>Jerry Motstok</h3>
                    <p>Product Manager</p>
                </div>
            </div>
            <!-- Testimonial Card -->
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"I bought a Stellar 4K Monitor, and it exceeded my expectations. The quality is amazing, and the delivery was quick."</p>
                </div>
                <div class="testimonial-author">
                    <h3>Alex Watson</h3>
                    <p>Software Engineer</p>
                </div>
            </div>
            <!-- Testimonial Card -->
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <p>"Great experience shopping at Galaxy Shop! The products are top-notch, and the support team is very helpful."</p>
                </div>
                <div class="testimonial-author">
                    <h3>Emily Johnson</h3>
                    <p>Graphic Designer</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials Section Ending -->


<!-- FAQ Section Starting -->
<section class="faq">
    <div class="faq-content">
        <div class="faq-questions">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    <span>What is Galaxy Shop?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p>Galaxy Shop is your one-stop destination for a wide range of products, from electronics to fashion, offering top-notch quality and customer service.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    <span>How can I track my order?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can track your order by logging into your account and visiting the 'Order History' section, where you will find tracking details for your recent purchases.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    <span>What are the payment options available?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p>We accept various payment methods including credit/debit cards, PayPal, and bank transfers for your convenience.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    <span>Can I return or exchange an item?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can return or exchange items within 30 days of receipt, provided they are in their original condition and packaging.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleAnswer(this)">
                    <span>How can I contact customer support?</span>
                    <span class="faq-icon">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can contact our customer support team via email at support@galaxyshop.com or by calling our helpline at 1-800-123-4567.</p>
                </div>
            </div>
        </div>
        <div class="faq-image">
            <img src="FaqImage.png" alt="FAQ Image">
        </div>
    </div>
</section>
<!-- FAQ Section Ending -->

<!-- Contact Us Starting -->
<section class="customer-support">
    <div class="customer-support-content">
        <div class="support-form">
            <h2>Contact Our Support Team</h2>
            <form action="submit_form.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
        <div class="support-testimonials">
            <h2>What Our Customers Say</h2>
            <div class="newtestcards">
                <div class="newtestcard">
                    <p>"The customer support team was incredibly helpful and resolved my issue quickly!"</p>
                    <h3>John Doe</h3>
                </div>
                <div class="newtestcard">
                    <p>"I had a great experience with the support team. They went above and beyond to help me."</p>
                    <h3>Jane Smith</h3>
                </div>
                <div class="newtestcard">
                    <p>"Fantastic support! My problem was fixed in no time and the staff were very friendly."</p>
                    <h3>Emily Johnson</h3>
                </div>
                <div class="newtestcard">
                    <p>"Quick and efficient support. I appreciate the prompt responses and effective solutions."</p>
                    <h3>Michael Brown</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Us Ending -->

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

<div class="cursor"></div>

<script>
// FAQ Starting
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    const faqAnswers = document.querySelectorAll('.faq-answer');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.faq-icon');
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                answer.classList.remove('fade-in');
                icon.style.transform = 'rotate(0deg)';
            } else {
                faqAnswers.forEach(ans => {
                    ans.classList.remove('show');
                    ans.classList.remove('fade-in');
                });
                faqQuestions.forEach(q => {
                    const icon = q.querySelector('.faq-icon');
                    icon.style.transform = 'rotate(0deg)'; 
                });
                answer.classList.add('show');
                answer.classList.add('fade-in');
                icon.style.transform = 'rotate(45deg)'; 
            }
        });
    });
});

// FAQ Ending


// Testimonials Starting
document.addEventListener('DOMContentLoaded', function() {
    const testimonialElements = document.querySelectorAll('.testimonials h2, .testimonial-card');
    
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
    
    testimonialElements.forEach(el => {
        observer.observe(el);
    });
});
// Testimonials Ending



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





// Products Starting
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');

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
        productCards.forEach(el => {
            if (isElementInViewport(el)) {
                el.classList.add('show');
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); 
});

// Products Ending


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
















    
    </script>
    
<script src="Navbar.js"></script>

</body>
</html>
