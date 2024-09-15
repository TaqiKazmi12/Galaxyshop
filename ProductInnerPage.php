
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

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die('Invalid product ID.');
}

$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$image_url = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'default-image.jpg';


if (!$product) {
    die('Product not found.');
}

$category_id = $product['category_id'];
$related_query = "SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4";
$stmt = $conn->prepare($related_query);
$stmt->bind_param("ii", $category_id, $product_id);
$stmt->execute();
$related_products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$reviews_query = "SELECT reviews.rating, reviews.review, reviews.review_date, users.name 
                  FROM reviews 
                  JOIN users ON reviews.user_id = users.id 
                  WHERE reviews.product_id = ? 
                  ORDER BY reviews.review_date DESC";
$stmt = $conn->prepare($reviews_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">

    <link rel="stylesheet" href="ProductInnerPage.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
 <!-- Navbar Starting -->
<div class="cursor"></div>

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
    <section class="product-inner-page">
        <div class="product-container">
            <div class="product-image">
                <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="product-rating">
                    <?php
                    $rating = isset($product['rating']) ? round($product['rating']) : 0; 
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $rating) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    ?>
                </div>
                <div class="product-actions">
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <a href="buynow.php?id=<?php echo $product_id; ?>" class="buy-now">Buy Now</a>
                </div>
                <style>
                    .buy-now {
                        background: #ffcc00;
                        color: white;
                        text-decoration: none;
                        padding: 11px 32px;
                        border-radius: 7px;
                        transition-duration: 121ms;
                        font-size: 20px;
                    }
                    .buy-now:hover {
                        background: #edca3f;
                        transform: scale(1.1);
                    }
                </style>
            </div>
        </div>
        
        <div class="related-products">
            <h2>Related Products</h2>
            <div class="product-grid">
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($related['image_url']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>">
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($related['name']); ?></h3>
                            <p>$<?php echo number_format($related['price'], 2); ?></p>
                            <a href="ProductInnerPage.php?id=<?php echo $related['id']; ?>" class="cta-button">View More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="product-reviews">
    <h2>Reviews</h2>
    <?php if ($isLoggedIn): ?>
        <form action="submit_review.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>

            <label for="review">Review:</label>
            <textarea id="review" name="review" rows="4" required></textarea>
            
            <button type="submit">Submit Review</button>
        </form>
    <?php else: ?>
        <p>Please <a href="UserLogin.php">log in</a> to write a review.</p>
    <?php endif; ?>

    <div class="reviews-list">
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <div class="review-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="<?php echo $i < $review['rating'] ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p><?php echo htmlspecialchars($review['review']); ?></p>
                <p><em>Reviewed by <?php echo htmlspecialchars($review['name']); ?> on <?php echo htmlspecialchars(date('F j, Y', strtotime($review['review_date']))); ?></em></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

    </section>

    <style>
        .product-card {
            opacity: 1 !important;
        }
      
.product-reviews {
    margin-top: 90px;
    padding: 0 15px; 
}

.product-reviews h2 {
    font-size: 32px;
    color: #ffffff;
    border-bottom: 2px solid yellow;
    padding-bottom: 10px;
    margin-bottom: 30px;
    text-align: center;
}


.product-reviews .reviews-content {
    display: flex;
    flex-wrap: wrap; 
    justify-content: space-between;
}

.product-reviews form {
    flex-basis: 100%;
    max-width: 40%;
    border: 2px solid yellow;
    padding: 25px;
    border-radius: 15px;
    background-color: transparent;

    margin: auto;
}

.product-reviews form label {
    color: white; 
    font-size: 18px;
    display: block;
    margin-bottom: 10px;
}

.product-reviews form select,
.product-reviews form textarea,
.product-reviews form button {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 2px solid yellow;
    border-radius: 8px;
    color: #2c003e; 
    font-size: 16px;
    box-sizing: border-box;
}

.product-reviews form button {
    background-color: yellow;
    color: #2c003e; 
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.product-reviews form button:hover {
    background-color: #ffd700; 
    transform: scale(1.05);
}


.reviews-list {
    flex-basis: 100%;
    max-width: 55%;
    margin: auto;
    margin-top: 50px;
}

.review {
    border: 2px solid yellow;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
    background-color: white; 
    transition: transform 0.3s, box-shadow 0.3s;
}

.review:hover {
    transform: scale(1.02); 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
}

.review-rating i {
    color: #000041;
    margin-right: 5px;
}

.review p {
    color: #2c003e; 
    font-size: 16px;
    margin-top: 10px;
}

.review em {
    color: #2c003e;
    font-size: 14px;
    margin-top: 10px;
    display: block;
}

@media (max-width: 768px) {
    .product-reviews .reviews-content {
        flex-direction: column; 
    }

    .product-reviews form,
    .reviews-list {
        flex-basis: 100%; 
        max-width: 100%;
    }

    .product-reviews form {
        margin-left: 0;
        margin-top: 20px; 
    }
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
