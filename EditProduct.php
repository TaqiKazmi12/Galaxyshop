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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $update_sql = "UPDATE Products SET name =?, price =?, category_id =?, description =? WHERE id =? AND seller_id =?";  
    $update_stmt = $conn->prepare($update_sql);  
    $update_stmt->bind_param("ssdsii", $name, $price, $category, $description, $product_id, $seller_id);
      
    if ($update_stmt->execute()) {
        header("Location: SellerProductPage.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}


$category_sql = "SELECT id, name FROM categories";
$categories_result = $conn->query($category_sql);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | GalaxyShop</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">

    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="ProductInnerPage.css">
    <link rel="stylesheet" href="SellerProductDetails.css">
    <link rel="stylesheet" href="EditProduct.css">
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

<div class="edit-product-section">
    <div class="edit-product">
        <h1>Edit Product</h1>
        <form method="POST">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">Select Category</option>
                <?php
            
                if ($categories_result) {
                    while ($row = $categories_result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '"' . ($row['id'] == $product['category_id'] ? ' selected' : '') . '>' . htmlspecialchars($row['name']) . '</option>';
                    }
                } else {
                    echo '<option value="">Error fetching categories</option>';
                }
                ?>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <button type="submit">Update Product</button>
        </form>
    </div>
</div>

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
</body>
</html>
