
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

$conn->close();
?>

<?php

include 'connectionfile.php'; 


if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to view your cart.');
}


$user_id = $_SESSION['user_id'];

// Debugging: Print the user_id
// echo "Session User ID: " . htmlspecialchars($user_id) . "<br>";


$query = "
    SELECT p.* 
    FROM wishlists w 
    JOIN products p ON w.product_id = p.id 
    WHERE w.user_id = (
        SELECT id FROM users WHERE email = ?  -- Adjust according to your actual database schema
    )
";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}


$stmt->bind_param("s", $user_id);

if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Get result failed: " . $stmt->error);
}

$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Debugging: Print number of cart items
// echo "Number of items in cart: " . count($cart_items) . "<br>";

// Debugging: Print the fetched data
// echo "<pre>";
// print_r($cart_items);
// echo "</pre>";

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Your Cart</title>
    <link rel="stylesheet" href="ProductInnerPage.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
  <link rel="icon" href="FavLogo.png" type="image/x-icon">


  
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
<style>
    .emptycart{
    text-align: center;
    width: 100%;
    background: #3838ad;
    font-size: 53px;
    color: white;
    margin-bottom: 220px;
}
</style>
   
    <h1>Your Cart</h1>

    <section class="cart">
        <?php if (empty($cart_items)): ?>
            <p class="emptycart">Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                    <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                    <a href="ProductInnerPage.php?id=<?php echo $item['id']; ?>" class="cta-button">Check Out</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
    <style>
        .product-card{
            opacity: 1 !important;
        }
        .cart {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    margin-top:100px;
    margin-bottom:200px;
}
body{
    background-image:url(FaqBg.png);

}
h1{
    text-align:center;
    color:white;
}

    </style>
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
