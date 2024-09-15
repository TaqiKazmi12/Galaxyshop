<?php
session_start();
include 'connectionfile.php'; 

$isLoggedIn = isset($_SESSION['user_id']); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $email; 
            header('Location: profile.php'); 
            exit();
        } else {
            $loginError = 'Invalid email or password.';
        }
    } else {
        $loginError = 'Invalid email or password.';
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - User</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="UserSignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profileContainer = document.querySelector('.profile-container');
            const profileToggle = document.querySelector('.profile-toggle');
            
            profileToggle.addEventListener('click', () => {
                profileContainer.classList.toggle('active');
            });
            
            document.addEventListener('click', (event) => {
                if (!profileContainer.contains(event.target)) {
                    profileContainer.classList.remove('active');
                }
            });

            document.querySelector('.menu-toggle').addEventListener('click', function() {
                document.querySelector('.nav-links').classList.toggle('active');
            });
        });
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

    <div class="container">
        <div class="form-container">
            <h1>Log In</h1>
            <form action="UserLogin.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Log In</button>
                <?php if (isset($loginError)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($loginError); ?></div>
                <?php endif; ?>
            </form>
            <div class="links">
                <p><a href="UserSignUp.php">New User? Sign Up</a></p>
                <p><a href="forgotPassword.php">Forgot Password?</a></p>
                <p><a href="sellerSignUp.php">Wanna Become a Seller?</a></p>
            </div>
        </div>
        <div class="bg-image"></div>
    </div>
</body>
                </html>
