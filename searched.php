<?php
session_start();
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





$searchResults = [];
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($searchQuery) {
  
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $searchQueryParam = "%$searchQuery%";
    $stmt->bind_param("s", $searchQueryParam);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    } else {
        $message = 'No products found.';
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
    <title>Search Results</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="UserSignUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

<div class="cursor"></div>

    <style>
        h1 {
    font-size: 32px;
    color: #ffffff;
    font-family: 'Zilla Slab Highlight', serif;
    animation: fadeInText 1s ease-out;
}
        body{
            cursor: pointer  !important;
        }
        .product-card{
            opacity: 1  !important;
        }
        .product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    justify-content: center;
    width: 100%;
    max-width: 1200px;
    margin: auto;
   
}
.cta-button{
    opacity: 1 !important;
    margin-left: 27px;
}
        .form-container {
    width: 100%;
    background-image: url(FaqBg.png);
    background-color: #ffffff;
    padding: 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: row;
    justify-content: center;
    animation: fadeIn 1s ease-out;
    flex-wrap: wrap;
}
.error-message{
margin-top: -89px;
    background: #6565e18f;
    height: 50px;
    width: 100%;
    text-align: center;
    font-size: 43px;
    color: white;
}
    </style>
    <div class="container">
        <div class="form-container">
            <h1>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h1>

            <?php if (isset($message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <div class="product-grid">
                <?php foreach ($searchResults as $product): ?>
                    <div class="product-card">
                       
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                             <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <p>$<?php echo htmlspecialchars($product['price']); ?></p>
                            <a href="ProductInnerPage.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="cta-button">Check Out</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
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


<script>
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
</body>
</html>
