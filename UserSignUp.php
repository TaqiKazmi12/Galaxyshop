<?php
session_start();
require_once 'connectionfile.php'; 
$isLoggedIn = isset($_SESSION['user_id']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - User</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="UserSignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      
        input.error {
            border: 2px solid red;
        }
        input.success {
            border: 2px solid green;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none;
        }
        .success-message {
            color: green;
            font-size: 0.9em;
            display: none;
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

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const nameSuccess = document.getElementById('name-success');
        const emailSuccess = document.getElementById('email-success');

        function validateName() {
            const nameValue = nameInput.value;
            const nameRegex = /^[a-zA-Z\s]+$/;
            if (!nameValue.match(nameRegex)) {
                nameInput.classList.add('error');
                nameError.style.display = 'block';
                nameSuccess.style.display = 'none';
                return false;
            } else {
                nameInput.classList.remove('error');
                nameInput.classList.add('success');
                nameError.style.display = 'none';
                nameSuccess.style.display = 'block';
                setTimeout(() => nameSuccess.style.display = 'none', 2000);
                return true;
            }
        }

        function validateEmail() {
            const emailValue = emailInput.value;
            const emailRegex = /^[a-z]+[a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,4}$/;
            if (!emailValue.match(emailRegex)) {
                emailInput.classList.add('error');
                emailError.style.display = 'block';
                emailSuccess.style.display = 'none';
                return false;
            } else {
                emailInput.classList.remove('error');
                emailInput.classList.add('success');
                emailError.style.display = 'none';
                emailSuccess.style.display = 'block';
                setTimeout(() => emailSuccess.style.display = 'none', 2000);
                return true;
            }
        }

        function validateForm(event) {
            const nameValid = validateName();
            const emailValid = validateEmail();
            if (!nameValid || !emailValid) {
                event.preventDefault();
            }
        }

        nameInput.addEventListener('input', validateName);
        emailInput.addEventListener('input', validateEmail);
        document.querySelector('form').addEventListener('submit', validateForm);
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
                <li><a href="Home.php">Home</a></li>
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
            <h1>Sign Up</h1>
            <form action="signup_process.php" method="POST">
                <input type="hidden" name="account_type" value="buyer">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                <div id="name-error" class="error-message">Name should only contain letters and spaces.</div>
                <div id="name-success" class="success-message">Name looks good!</div>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div id="email-error" class="error-message">Please enter a valid email address.</div>
                <div id="email-success" class="success-message">Email looks good!</div>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Sign Up</button>
            </form>

            <div class="links">
                <p><a href="UserLogin.php">Already a User? Log In</a></p>
                <p><a href="sellerSignUp.php">Wanna Become a Seller?</a></p>
            </div>
        </div>
        <div class="bg-image"></div>
    </div>
</body>
</html>
