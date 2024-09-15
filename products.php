<?php
session_start();
include 'connectionfile.php'; 


$isLoggedIn = isset($_SESSION['user_id']);


$productsPerPage = 6;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $productsPerPage;


$sql = "SELECT * FROM Products LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $productsPerPage, $offset);
$stmt->execute();
$result = $stmt->get_result();


$total_sql = "SELECT COUNT(*) AS total FROM Products";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$totalProducts = $total_row['total'];
$totalPages = ceil($totalProducts / $productsPerPage);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Products</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="Products.css">
    <link rel="stylesheet" href="Home.css">
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

    <!-- Products Header Starting -->
    <section class="ProductsHeader">
        <div class="ProductsHeader-content">
            <h1>Products</h1>
            <p>Explore our wide range of products designed to meet all your needs. From the latest tech gadgets to everyday essentials, we have something for everyone. Discover top-quality items that are sure to enhance your life and shopping experience.</p>
        </div>
    </section>
    <!-- Products Header Ending -->

    <!-- Products Section Starting -->
    <section class="products">
        <div class="products-bg">
            <h2>Products</h2>
            <div class="product-grid">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                    
                            <a href="ProductInnerPage.php?id=<?php echo $product['id']; ?>" class="cta-button" onclick="handleCheckOutClick()">Check Out</a>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <!-- Pagination Controls -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="page-link">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="page-link<?php if ($i == $page) echo ' active'; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Products Section Ending -->

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
    <script>
    
        function handleCheckOutClick() {
            <?php if ($isLoggedIn): ?>
                window.location.href = "ProductInnerPage.php";
            <?php else: ?>
                window.location.href = "UserSignUp.php";
            <?php endif; ?>
        }

        // Products Starting
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
        // Products Ending
    </script>
    <style>
        .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.page-link {
    margin: 0 5px;
    padding: 10px;
    text-decoration: none;
    color: #000;
    background-color: #f1f1f1;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.page-link.active {
    background-color: #000041;
    color: #fff;
}

.page-link:hover {
    background-color: #ddd;
}

    </style>
</body>
</html>
