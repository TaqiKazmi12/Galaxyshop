<?php

session_start();

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Something went wrong.';
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'error'; 

$redirectUrl = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : 'SellerHomePage.html';
$redirectDelay = 3; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Message</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
         
            height: 100vh;
            background: url('FaqBg.png') no-repeat center center fixed;
            background-size: cover;
        }
        .message-container {
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: auto;
margin-top:100px;
        }
footer{
    margin-top:425px;
}
        .message-container.success {
            border-left: 5px solid #28a745;
        }
        .message-container.error {
            border-left: 5px solid #dc3545;
        }
        .message-container h1 {
            margin: 0;
            font-size: 24px;
        }
        .message-container p {
            font-size: 18px;
            margin: 15px 0;
        }
        .message-container a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .message-container a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="Home.css">

</head>
<body>
    <!-- Navbar Starting -->
    <header>
        <nav class="navbar">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <div class="logo">
                <img src="Logo.png" alt="MyLogo" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="SellerHomePage.php">Home</a></li>
                <li><a href="SellerProductPage.php">My Products</a></li>
                <li><a href="SellerAboutUs.php">About Us</a></li>
                <li><a href="SellercontactUs.php"  class="active">Contact Us</a></li>
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
    <div class="cursor"></div>

    <div class="message-container <?php echo $type; ?>">
        <h1><?php echo $type === 'success' ? 'Success!' : 'Error'; ?></h1>
        <p><?php echo $message; ?></p>
        <p>Redirecting you to <a href="<?php echo $redirectUrl; ?>">the next page</a> in <?php echo $redirectDelay; ?> seconds...</p>
    </div>

    <script>
        // Redirect after a delay
        setTimeout(function() {
            window.location.href = "<?php echo $redirectUrl; ?>";
        }, <?php echo $redirectDelay * 1000; ?>);
    </script>

<script src="Navbar.js"></script>
    <script>
        document.addEventListener('mousemove', function(e) {
            const cursor = document.querySelector('.cursor');
            cursor.style.left = e.pageX + 'px';
            cursor.style.top = e.pageY + 'px';
        });

        function createTrail(e) {
            const trail = document.createElement('div');
            trail.classList.add('trail');
            document.body.appendChild(trail);
            trail.style.left = e.pageX + 'px';
            trail.style.top = e.pageY + 'px';

            requestAnimationFrame(() => {
                trail.style.opacity = '1';
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        trail.style.opacity = '0';
                        trail.style.transform = 'scale(0)'; 
                        requestAnimationFrame(() => {
                            setTimeout(() => {
                                document.body.removeChild(trail);
                            }, 500); 
                        });
                    }, 100); 
                });
            });
        }

        document.addEventListener('mousemove', function(e) {
            createTrail(e);
        });

        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('mouseover', function() {
                document.querySelector('.cursor').classList.add('hovered');
            });

            el.addEventListener('mouseout', function() {
                document.querySelector('.cursor').classList.remove('hovered');
            });
        });
    </script>
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
</body>
</html>
