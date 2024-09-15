<?php
session_start();
include 'connectionfile.php'; 


if (!isset($_SESSION['user_id'])) {
    header('Location: UserLogin.php'); 
    exit();
}

$email = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    
    if (!empty($newName) && filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
      
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE email = ?");
        $stmt->bind_param("ssss", $newName, $newEmail, password_hash($newPassword, PASSWORD_DEFAULT), $email);
        if ($stmt->execute()) {
          
            $_SESSION['user_id'] = $newEmail;
            header('Location: message_template_for_profile.php');
            exit();
        } else {
            $message = 'Failed to update profile. Please try again.';
        }
        $stmt->close();
    } else {
        $message = 'Invalid input. Please provide valid information.';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Edit Profile</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
    <style>
        body {
            background-image: url('FaqBg.png');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
           
        }
footer{
    margin-top:310px;
}
        .form-container {
            background: rgba(255, 255, 255, 0.9); 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; 
            box-sizing: border-box;
            margin:auto;
            margin-top:60px;
        }

        .form-container h1 {
            margin: 0 0 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
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
                <li><a href="Home.php"  >Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="AboutUs.php"  class="active" >About Us</a></li>
                <li><a href="ContactUs.php">Contact Us</a></li>
                <li class="profile-container">
                    <button class="profile-toggle"><i class="fas fa-user"></i></button>
                    <div class="profile-dropdown">
                    <a href="profile.php">Profile</a>

                    <a href="logout.php">Logout</a>

                       
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
 
    <div class="form-container">
        <h1>Edit Your Profile</h1>
        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="edit_profile.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password (leave blank if not changing)">

            <button type="submit">Update Profile</button>
        </form>
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
