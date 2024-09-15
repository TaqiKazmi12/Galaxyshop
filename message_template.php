<?php

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
    <title>Notification</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('FaqBg.png'); 
            background-size: cover;
            background-position: center;
          
            height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .message {
            margin-bottom: 20px;
        }
    footer{
        margin-top:600px;
    }
    </style>
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
            <li><a href="Home.php">Home</a></li>
            <li><a href="products.php" class="active">Products</a></li>
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
    </nav>
</header>
<!-- Navbar Ending -->
    <div class="container">
        <div class="message">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '<?php echo htmlspecialchars($redirect_url); ?>';
            }, <?php echo $delay * 1000; ?>); 
        </script>
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

</body>
</html>
