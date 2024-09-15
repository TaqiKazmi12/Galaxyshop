

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | GalaxyShop</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="add-product.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
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
                <li><a href="SellerHomePage.php" >Home</a></li>
                <li><a href="SellerProductPage.php" class="active" >My Products</a></li>
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
<!-- Add Product Section Starting -->
<section class="add-product">
    <header class="add-product-header">
        <h1>Add New Product</h1>
        <p>Fill in the details below to add a new product to your inventory.</p>
    </header>
    <div class="form-container">
        <form action="submit_add_product.php" method="POST" enctype="multipart/form-data">
            <label for="product-name">Product Name:</label>
            <input type="text" id="product-name" name="product_name" required>

            <label for="product-description">Description:</label>
            <textarea id="product-description" name="product_description" rows="4" required></textarea>

            <label for="product-price">Price:</label>
            <input type="number" id="product-price" name="product_price" step="0.01" required>

           
            <label for="product-category">Category:</label>
<select id="product-category" name="product_category" required>
    <option value="">Select Category</option>
    <?php
   
    include 'connectionfile.php'; 
    $sql = "SELECT id, name FROM categories";
    $result = $conn->query($sql);

   
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
        }
    } else {
        echo '<option value="">Error fetching categories</option>';
    }
    ?>
</select>


            <label for="product-image">Upload Image:</label>
            <input type="file" id="product-image" name="product_image" accept="image/*" required>

            <button type="submit" class="cta-button">Add Product</button>
        </form>
    </div>
</section>
<!-- Add Product Section Ending -->

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
    <div class="cursor"></div>
 
    <script src="Navbar.js"></script>
 
</body>
</html>
