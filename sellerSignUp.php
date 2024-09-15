<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Seller</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="UserSignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                        <a href="UserSignUp.php">Sign Up</a>
                        <a href="UserLogin.php">Log In</a>
                        <a href="profile.php">Profile</a>
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
            <h1>Sign Up as Seller</h1>
            <form action="seller_signup_process.php" method="POST">
                <label for="business-name">Business Name</label>
                <input type="text" id="business-name" name="business-name" required>
                <div id="business-name-error" class="error-message">Business name cannot be empty.</div>
                <div id="business-name-success" class="success-message">Business name looks good!</div>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <div id="email-error" class="error-message">Please enter a valid email address.</div>
                <div id="email-success" class="success-message">Email looks good!</div>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Sign Up</button>
            </form>
            <div class="links">
                <p><a href="sellerLogin.php">Already a Seller? Log In</a></p>
                <p><a href="forgotPassword.php">Forgot Password?</a></p>
                <p><a href="UserSignUp.php">New User? Sign Up</a></p>
            </div>
        </div>
        <div class="bg-image"></div>
    </div>
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

            const businessNameInput = document.getElementById('business-name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const businessNameError = document.getElementById('business-name-error');
            const emailError = document.getElementById('email-error');
            const businessNameSuccess = document.getElementById('business-name-success');
            const emailSuccess = document.getElementById('email-success');

            function validateBusinessName() {
                const businessNameValue = businessNameInput.value;
                if (businessNameValue.trim() === '') {
                    businessNameInput.classList.add('error');
                    businessNameError.style.display = 'block';
                    businessNameSuccess.style.display = 'none';
                    return false;
                } else {
                    businessNameInput.classList.remove('error');
                    businessNameInput.classList.add('success');
                    businessNameError.style.display = 'none';
                    businessNameSuccess.style.display = 'block';
                    setTimeout(() => businessNameSuccess.style.display = 'none', 2000);
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
                const businessNameValid = validateBusinessName();
                const emailValid = validateEmail();
                if (!businessNameValid || !emailValid) {
                    event.preventDefault(); 
                }
            }

            businessNameInput.addEventListener('input', validateBusinessName);
            emailInput.addEventListener('input', validateEmail);
            document.querySelector('form').addEventListener('submit', validateForm);
        });
    </script>
</body>
    </html>
