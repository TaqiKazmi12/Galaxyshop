<?php
session_start();
include 'connectionfile.php'; 

if (!isset($_SESSION['seller_id'])) {
    die("Seller ID is not set in session.");
}


if (!isset($_GET['id'])) {
    die("Product ID is not specified.");
}


$seller_id = $_SESSION['seller_id'];
$product_id = intval($_GET['id']);


$sql = "SELECT * FROM Products WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 0) {
    die("Product not found or you do not have access to this product.");
}

$product = $result->fetch_assoc();
$image_url = !empty($product['image_url']) ?  htmlspecialchars($product['image_url']) : 'default-image.jpg';

$reviews_query = "SELECT reviews.rating, reviews.review, reviews.review_date, users.name 
                  FROM reviews 
                  JOIN users ON reviews.user_id = users.id 
                  WHERE reviews.product_id = ? 
                  ORDER BY reviews.review_date DESC";
$stmt = $conn->prepare($reviews_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
  
    $delete_sql = "DELETE FROM Products WHERE id = ? AND seller_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $product_id, $seller_id);

    if ($delete_stmt->execute()) {
   
        header("Location: SellerProductPage.php");
        exit();
    } else {
        echo "Error deleting product.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="ProductInnerPage.css">
    <link rel="stylesheet" href="SellerProductDetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
</head>
<body>
<div class="cursor"></div>

<!-- Navbar Starting -->
<header>
    <nav class="navbar">
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="logo">
            <img src="Logo.png" alt="MyLogo" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="SellerHomePage.php">Home</a></li>
            <li><a href="SellerProductPage.php" class="active">My Products</a></li>
            <li><a href="SellerAboutUs.php">About Us</a></li>
            <li><a href="SellercontactUs.php">Contact Us</a></li>
            <li class="profile-container">
                <button class="profile-toggle"><i class="fas fa-user"></i></button>
                <div class="profile-dropdown">
                    <a href="sellerprofile.php">Profile</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </li>
        </ul>
        
    </nav>
</header>
<!-- Navbar Ending -->

<!-- Inner Page Section Starting -->
<div class="product-inner-page">
    <div class="product-container">
        <div class="product-image">
            <img src="<?php echo $image_url; ?>" alt="">
        </div>

        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            <div class="product-rating">
                <?php
                $rating = $product['rating'];
                for ($i = 0; $i < 5; $i++) {
                    if ($i < floor($rating)) {
                        echo '<i class="fas fa-star"></i>';
                    } elseif ($i < $rating) {
                        echo '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
            </div>
            <div class="product-actions">
                  <a href="EditProduct.php?id=<?php echo $product_id; ?>" class="edit-btn cta-button">Edit</a>
  
                
                <form method="POST">
                    <input type="hidden" name="delete_product" value="1">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <div class="related-products">
    <h2>Reviews</h2>

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
</div>
<!-- Inner Page Section Ending -->
<style>
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
 <!-- Footer Ending -->
 <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <img src="Logo.png" alt="GalaxyShop Logo" class="footer-logo">
                <p class="footer-description">GalaxyShop empowers sellers to reach a global audience with ease and efficiency, offering a comprehensive platform for all your e-commerce needs.</p>
            </div>
            <div class="footer-links">
                <div class="links-section">
                    <h3>Seller Resources</h3>
                    <ul>
                        <li><a href="SellerProductPage.php">My Products</a></li>
                        <li><a href="SellerSupport.php">Seller Support</a></li>
                        <li><a href="sellerprofile.php">Account Settings</a></li>
                    </ul>
                </div>
                <div class="links-section">
                    <h3>GalaxyShop</h3>
                    <ul>
                        <li><a href="SellerHomePage.php">Home</a></li>
                        <li><a href="SellerAboutUs.php">About Us</a></li>
                        <li><a href="SellercontactUs.php">Contact Us</a></li>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.product-card');

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        function handleScroll() {
            productCards.forEach(el => {
                if (isElementInViewport(el)) {
                    el.classList.add('show');
                }
            });
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll(); 
    });
</script>

<style>
    .footer {
    background-color: #000041;
    color: #ffffff;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    margin-top: 185px;
}
body{
    background: #000041;
}
.edit-btn{
    height: 25px;
    width: 60px;
    text-align: center;
    padding-top: 12px;
    font-size: 21px;
    color: black;

}
</style>
</body>
</html>

<?php

$conn->close();
?>
