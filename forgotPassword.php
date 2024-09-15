<?php
session_start();
include 'connectionfile.php'; 
include 'mail_function.php'; 


$message = '';
$emailSent = false;
$codeVerified = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

      
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
             
                $code = rand(10000, 99999); 
                $_SESSION['reset_code'] = $code;
                $_SESSION['reset_email'] = $email;

         
                $subject = "Password Reset Code";
                $body = "Your password reset code is: $code";
                if (sendEmail($email, $subject, $body)) {
                    $emailSent = true;
                } else {
                    $message = 'Failed to send the verification code. Please try again.';
                }
            } else {
                $message = 'Email not found in our records.';
            }
            $stmt->close();
        } else {
            $message = 'Invalid email address.';
        }
    }

    if (isset($_POST['code'])) {
        $codeEntered = $_POST['code'];
        
        if (isset($_SESSION['reset_code']) && $codeEntered == $_SESSION['reset_code']) {
            $codeVerified = true;
        } else {
            $message = 'Invalid verification code.';
        }
    }

    if (isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        if ($newPassword === $confirmPassword) {
        
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $emailToReset = $_SESSION['reset_email'];

            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $emailToReset);
            
            if ($stmt->execute()) {
                $message = 'Password reset successfully. <a href="UserLogin.php">Login here</a>.';
                unset($_SESSION['reset_code']);
                unset($_SESSION['reset_email']);
            } else {
                $message = 'Failed to reset the password. Please try again.';
            }
            $stmt->close();
        } else {
            $message = 'Passwords do not match.';
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
    <title>Forgot Password</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="UserSignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hidden {
            display: none;
        }
        .error-message {
            color: red;
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
                <li><a href="Home.php" class="active">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="AboutUs.php">About Us</a></li>
                <li><a href="ContactUs.php">Contact Us</a></li>
                <li class="profile-container">
                    <button class="profile-toggle"><i class="fas fa-user"></i></button>
                    <div class="profile-dropdown">
                        <a href="UserSignUp.php">Sign Up</a>
                        <a href="UserLogin.php">Log In</a>
                    </div>
                </li>
            </ul>
              <div class="search-container">
            <form action="searched.php" method="GET">
           <for m action="searched.name="query" php" method="GET"> required
                <input  type="submit"type="text" name="query" placeholder="Search..." required>
            </form>
            <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        </nav>
    </header>
    <!-- Navbar Ending -->

    <div class="container">
        <div class="form-container">
            <h1>Forgot Password</h1>

            <?php if (!empty($message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <!-- Email Input Section -->
            <?php if (!$emailSent): ?>
                <div id="email-section">
                    <form id="email-form" action="forgotpassword.php" method="POST">
                        <label for="email">Enter your email</label>
                        <input type="email" id="email" name="email" required>
                        <button type="submit">Send Code</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Code Verification Section -->
            <?php if ($emailSent && !$codeVerified): ?>
                <div id="code-section">
                    <form id="code-form" action="forgotpassword.php" method="POST">
                        <label for="code">Enter verification code</label>
                        <input type="text" id="code" name="code" required>
                        <button type="submit">Verify Code</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Password Reset Section -->
            <?php if ($codeVerified): ?>
                <div id="reset-section">
                    <form id="reset-form" action="forgotpassword.php" method="POST">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" required>

                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>

                        <button type="submit">Reset Password</button>
                    </form>
                </div>
            <?php endif; ?>

            <div class="links">
                <p><a href="UserLogin.php">Back to Login</a></p>
                <p><a href="UserSignUp.php">New User? Sign Up</a></p>
            </div>
        </div>
        <div class="bg-image"></div>
    </div>
</body>
</html>
