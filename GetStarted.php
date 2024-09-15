<?php
session_start();
include 'connectionfile.php';
// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Started | GalaxyShop</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="GetStarted.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error-message {
            display: none;
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }

        .message {
            display: none;
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
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
                <li><a href="Home.php"  >Home</a></li>
                <li><a href="products.php"  class="active" >Products</a></li>
                <li><a href="AboutUs.php"   >About Us</a></li>
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
        <div class="content" id="initial">
            <h1>Who Are You?</h1>
            <div class="options">
                <div class="option" onclick="selectRole('Buyer')">
                    <i class="fas fa-shopping-cart icon"></i>
                    <div class="text">Buyer</div>
                </div>
                <div class="option" onclick="selectRole('Seller')">
                    <i class="fas fa-store icon"></i>
                    <div class="text">Seller</div>
                </div>
            </div>
        </div>

        <div class="content" id="buyer" style="display: none;">
            <h1>What Are Your Interests?</h1>
            <div class="interests">
          
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-icons icon"></i>
                    <div class="text">Beauty Products</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-gamepad icon"></i>
                    <div class="text">Gaming Products</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-laptop icon"></i>
                    <div class="text">Tech Gadgets</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-utensils icon"></i>
                    <div class="text">Kitchen Appliances</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-book icon"></i>
                    <div class="text">Books</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-shoe-prints icon"></i>
                    <div class="text">Footwear</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-dumbbell icon"></i>
                    <div class="text">Fitness Equipment</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-cogs icon"></i>
                    <div class="text">DIY Tools</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-paint-brush icon"></i>
                    <div class="text">Art Supplies</div>
                </div>
                <div class="checkbox-option" onclick="selectInterest(this)">
                    <i class="fas fa-paw icon"></i>
                    <div class="text">Pet Supplies</div>
                </div>
            </div>
            <button onclick="nextStep()">Next</button>
        </div>

        <div class="content" id="seller" style="display: none;">
            <h1>What Kind of Products Will You Be Selling?</h1>
            <div class="categories">
            
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-gamepad icon"></i>
                    <div class="text">Gaming Products</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-laptop icon"></i>
                    <div class="text">Tech Gadgets</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-tshirt icon"></i>
                    <div class="text">Fashion</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-couch icon"></i>
                    <div class="text">Home Goods</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-utensils icon"></i>
                    <div class="text">Kitchen Appliances</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-tools icon"></i>
                    <div class="text">Tools</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-baby icon"></i>
                    <div class="text">Baby Products</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-automobile icon"></i>
                    <div class="text">Automotive Parts</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-gift icon"></i>
                    <div class="text">Gifts</div>
                </div>
                <div class="checkbox-option" onclick="selectCategory(this)">
                    <i class="fas fa-satellite-dish icon"></i>
                    <div class="text">Electronics</div>
                </div>
            </div>
            <button onclick="nextStep()">Next</button>
            <div id="error-message" class="error-message">You can only select 5 categories.</div>
        </div>
    </div>

    <script>
        const maxSelections = 5;

        function selectRole(role) {
            document.getElementById('initial').style.display = 'none';
            document.getElementById('buyer').style.display = 'none';
            document.getElementById('seller').style.display = 'none';

            if (role === 'Buyer') {
                document.getElementById('buyer').style.display = 'block';
            } else if (role === 'Seller') {
                document.getElementById('seller').style.display = 'block';
            }
        }

        function selectInterest(element) {
            element.classList.toggle('selected');
        }

        function selectCategory(element) {
            const categories = document.querySelectorAll('#seller .checkbox-option.selected');
            const errorMessage = document.getElementById('error-message');
            
            if (element.classList.contains('selected')) {
                element.classList.remove('selected');
            } else if (categories.length >= maxSelections) {
                showError('You can only select 5 categories.');
            } else {
                element.classList.add('selected');
                if (categories.length + 1 > maxSelections) {
                    showError('You can only select 5 categories.');
                } else {
                    errorMessage.style.display = 'none';
                }
            }
        }

        function showError(message) {
            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000); // 5 seconds
        }

        function nextStep() {
            const buyerSection = document.getElementById('buyer');
            const sellerSection = document.getElementById('seller');

            // Check if Buyer section is visible and if any interests are selected
            if (buyerSection.style.display === 'block') {
                const selectedInterests = document.querySelectorAll('#buyer .selected');
                if (selectedInterests.length === 0) {
                    alert('Please select at least one interest.');
                    return;
                }
            }

            // Check if Seller section is visible and if any categories are selected
            if (sellerSection.style.display === 'block') {
                const selectedCategories = document.querySelectorAll('#seller .selected');
                if (selectedCategories.length === 0) {
                    alert('Please select at least one category.');
                    return;
                }
            }

            setTimeout(() => {
                window.location.href = 'products.php';
            }, 1000); // 1-second delay before redirecting
        }
        // Navbar Starting
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
});

  document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
// Navbar Ending


    </script>
</body>
    </html>
