<?php
session_start();
include 'connectionfile.php'; 
if (!isset($_SESSION['seller_id'])) {
    die("Seller ID is not set in session.");
}

$seller_id = $_SESSION['seller_id'];
$message = '';
$messageClass = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['product_name'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $category = $_POST['product_category']; 
    $sql = "SELECT id, seller_id FROM Products WHERE name = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($productId, $productSellerId);
            $stmt->fetch();
            
            if ($productSellerId == $seller_id) {
    
                $message = "You have already added this item.";
                $messageClass = 'error';
                header("Refresh:2; url=SellerProductPage.php"); 
            } else {
              
                $message = "This item is already in the GalaxyShop database.";
                $messageClass = 'error';
                header("Refresh:2; url=add-product.php"); 
            }
        } else {
          
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
                $fileTmpPath = $_FILES['product_image']['tmp_name'];
                $fileName = $_FILES['product_image']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

              
                $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

                if (in_array($fileExtension, $allowedExtensions)) {
                 
                    $uploadPath = 'uploads/' . $fileName;

                    
                    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                      
                        $sql = "INSERT INTO Products (name, description, image_url, price, rating, category_id, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

                        if ($stmt = $conn->prepare($sql)) {
                      
                            $rating = 0.00; 
                            $stmt->bind_param("sssdiii", $name, $description, $uploadPath, $price, $rating, $category, $seller_id);

                     
                            if ($stmt->execute()) {
                              
                                $message = "Product added successfully! Redirecting...";
                                $messageClass = 'success';
                              
                                header("Refresh:2; url=SellerProductPage.php");
                            } else {
                                $message = "Error: " . $stmt->error . ". Please contact us <a href='SellercontactUs.php'>here</a>.";
                                $messageClass = 'error';
                            }

                          
                           
                        } else {
                            $message = "Error preparing statement: " . $conn->error . ". Please contact us <a href='SellercontactUs.php'>here</a>.";
                            $messageClass = 'error';
                        }
                    } else {
                        $message = "Error moving uploaded file. Please contact us <a href='SellercontactUs.php'>here</a>.";
                        $messageClass = 'error';
                    }
                } else {
                    $message = "Invalid file extension. Please contact us <a href='SellercontactUs.php'>here</a>.";
                    $messageClass = 'error';
                }
            } else {
                $message = "Error uploading file. Please contact us <a href='SellercontactUs.php'>here</a>.";
                $messageClass = 'error';
            }
        }
    
    } else {
        $message = "Error preparing statement: " . $conn->error . ". Please contact us <a href='SellercontactUs.php'>here</a>.";
        $messageClass = 'error';
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
    <title>Submit Product</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="SellerProductDetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">


    <style>
       
        .message {
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .message a {
            color: #004085;
            text-decoration: underline;
        }
        .footer {
    background-color: #000041;
    color: #ffffff;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    margin-top: 683px;
}
body {
    cursor: none;
    background-image: url(FaqBg.png);
}
    </style>
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

    <div class="container">
        <?php if ($message): ?>
            <div class="message <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
    </div>

  <!-- Footer Starting -->
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
                    <li><a href="SellerAccount.php">Account Settings</a></li>
                </ul>
            </div>
            <div class="links-section">
                <h3>GalaxyShop</h3>
                <ul>
                    <li><a href="Home.php">Home</a></li>
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
