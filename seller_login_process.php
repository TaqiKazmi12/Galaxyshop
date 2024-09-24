<?php
session_start();
include 'connectionfile.php'; 

$error_message = '';
$redirect_after_error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

  
    if (empty($email) || empty($password)) {
        $error_message = 'All fields are required.';
        $redirect_after_error = true;
    } else {
       
        $stmt = $conn->prepare("SELECT id, password, name, email, account_type FROM users WHERE email = ? AND account_type = 'seller'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error_message = 'Invalid email or not a seller.';
            $stmt->close();
            $redirect_after_error = true;
        } else {
            
            $stmt->bind_result($userId, $hashedPassword, $name, $email, $accountType);
            $stmt->fetch();

        
            if (password_verify($password, $hashedPassword)) {
                
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['account_type'] = $accountType;
                $_SESSION['seller_id'] = $userId;

                header('Location: SellerHomePage.php');
                exit();
            } else {
                $error_message = 'Invalid password.';
                $redirect_after_error = true;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Your Cart</title>
   
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
  <link rel="icon" href="FavLogo.png" type="image/x-icon">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        body {
            background-image: url('CtaBg.png'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        .message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .message-box {
    background-color: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-size: 18px;
    margin-top: -490px;
}

        .error {
            color: red;
        }

        .success {
            color: green;
        }
        .footer {
    background-color: #000041;
    color: #ffffff;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    margin-top: -370px;
}
    </style>
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
        </div>
        </nav>
    </header>
    <!-- Navbar Ending -->
<div class="cursor"></div>

<div class="message-container">
    <div class="message-box">
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php if ($redirect_after_error): ?>
    <script>
        setTimeout(function() {
            window.location.href = 'sellerLogin.php'; 
        }, 3000); 
    </script>
<?php endif; ?>

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
