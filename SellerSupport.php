<?php
session_start();
include 'connectionfile.php'; 
if (!isset($_SESSION['user_id'])) {
    header('Location: SellerLogin.php'); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $issue_type = htmlspecialchars(trim($_POST['issue']));
    $description = htmlspecialchars(trim($_POST['description']));

   
    if (empty($name) || empty($email) || empty($issue_type) || empty($description)) {
   
        header('Location: message.php?message=All fields are required.&type=error&redirect=SellerSupport.php');
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
        header('Location: message.php?message=Invalid email format.&type=error&redirect=SellerSupport.php');
        exit();
    } else {
      
        $stmt = $conn->prepare("INSERT INTO sellersupport (name, email, issue_type, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $issue_type, $description);

        if ($stmt->execute()) {
        
            header('Location: message.php?message=Your issue has been submitted successfully.&type=success&redirect=SellerHomePage.php');
        } else {
        
            header('Location: message.php?message=Error: ' . urlencode($stmt->error) . '&type=error&redirect=SellerSupport.php');
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Seller Support</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="SellerSupport.css"> 
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

    <div class="form-container">
        <h2>Seller Support</h2>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="issue">Issue Type</label>
            <select id="issue" name="issue" required>
                <option value="">Select an issue</option>
                <option value="Product Stolen">Product Stolen</option>
                <option value="Product Not Selling">Product Not Selling</option>
                <option value="Payment Issues">Payment Issues</option>
                <option value="Shipping Problems">Shipping Problems</option>
                <option value="Account Access Issues">Account Access Issues</option>
                <option value="Listing Errors">Listing Errors</option>
                <option value="Other">Other</option>
            </select>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

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
