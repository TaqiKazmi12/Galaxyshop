<?php
session_start();
include 'connectionfile.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    die('Invalid product ID.');
}

$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

$image_url = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'default-image.jpg';



if (!$product) {
    die('Product not found.');
}

$stmt->close();


$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $email = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

    
        $stmt = $conn->prepare("SELECT id, card_number, card_holder_name, expiration_date FROM payment_methods WHERE user_id = ? AND is_primary = 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($paymentId, $cardNumber, $cardHolderName, $expirationDate);

        $primaryPaymentMethods = [];
        while ($stmt->fetch()) {
            $primaryPaymentMethods[] = [
                'id' => $paymentId,
                'card_number' => $cardNumber,
                'card_holder_name' => $cardHolderName,
                'expiration_date' => $expirationDate
            ];
        }
        $stmt->close();

       
        $stmt = $conn->prepare("SELECT id, card_number, card_holder_name, expiration_date FROM payment_methods WHERE user_id = ? AND is_primary = 0");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($paymentId, $cardNumber, $cardHolderName, $expirationDate);

        $nonPrimaryPaymentMethods = [];
        while ($stmt->fetch()) {
            $nonPrimaryPaymentMethods[] = [
                'id' => $paymentId,
                'card_number' => $cardNumber,
                'card_holder_name' => $cardHolderName,
                'expiration_date' => $expirationDate
            ];
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "User does not exist.";
        header('Location: UserLogin.php');
        exit();
    }
} else {
    $primaryPaymentMethods = [];
    $nonPrimaryPaymentMethods = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Buy Now</title>
    <link rel="stylesheet" href="ProductInnerPage.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
     
        body {
            background-image: url('FaqBg.png');
            background-size: cover;
            background-position: center;
        }
        .buynow-page {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            color: #fff;
        }
        footer {
            margin-top: 170px;
        }
        .product-details {
            display: flex;
            margin-bottom: 20px;
        }
        .product-details img {
            max-width: 200px;
            margin-right: 20px;
        }
        .product-details div {
            flex: 1;
        }
        .payment-methods {
            margin-top: 20px;
        }
        .payment-methods label {
            display: block;
            margin-bottom: 10px;
            color: white;
        }
        .payment-methods input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fc0;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .cta-button:hover {
            background-color: #fff;
            color: #000041;
        }
        .form-errors {
            color: red;
        }
    
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .card-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .card-option button {
            margin-left: 10px;
            background-color: #fc0;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .card-option button:hover {
            background-color: #fff;
            color: #000041;
        }
      
        .input-error {
            border-color: red;
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
                <li><a href="Home.php">Home</a></li>
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

<section class="buynow-page">
    <div class="product-details">
    <img src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    <div>
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
    </div>

    <div class="payment-methods">
    <h2>Select Payment Method</h2>
    <form id="payment-form" action="process_payment.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">

        <?php if ($isLoggedIn && !empty($primaryPaymentMethods)): ?>
            <label>
                <input type="radio" name="payment_method" value="online_saved" id="saved-payment" checked>
                Saved Payment Method
            </label>
            <select id="saved-payment-method" name="saved_payment_method">
                <?php foreach ($primaryPaymentMethods as $method): ?>
                    <option value="<?php echo htmlspecialchars($method['id']); ?>">
                        <?php echo htmlspecialchars(substr($method['card_number'], -4)); ?> (Expires: <?php echo htmlspecialchars($method['expiration_date']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label>
            <input type="radio" name="payment_method" value="online" id="online-payment">
            Online Payment
        </label>

        <label>
            <input type="radio" name="payment_method" value="cod" checked>
            Cash on Delivery
        </label>

        <input type="text" id="address" name="address" placeholder="Enter your address" required>
        <input type="text" id="contact_number" name="contact_number" placeholder="Enter your contact number" required pattern="\d*" maxlength="15">
        <div id="form-errors" class="form-errors"></div>

        <button type="submit" class="cta-button">Proceed to Checkout</button>
    </form>
</div>

</section>

<!-- Modal for Online Payment -->
<div id="online-payment-modal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Select Another Credit Card</h2>
        <table>
            <thead>
                <tr>
                    <th>Card Number</th>
                    <th>Card Holder Name</th>
                    <th>Expiration Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($isLoggedIn && !empty($nonPrimaryPaymentMethods)): ?>
                    <?php foreach ($nonPrimaryPaymentMethods as $method): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(substr($method['card_number'], -4)); ?></td>
                            <td><?php echo htmlspecialchars($method['card_holder_name']); ?></td>
                            <td><?php echo htmlspecialchars($method['expiration_date']); ?></td>
                            <td>
                                <button class="select-card" data-id="<?php echo htmlspecialchars($method['id']); ?>" data-number="<?php echo htmlspecialchars($method['card_number']); ?>" data-exp="<?php echo htmlspecialchars($method['expiration_date']); ?>">
                                    Select
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No credit cards found. <a href="manage_payment.php">Add Here</a></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var onlinePaymentModal = document.getElementById("online-payment-modal");
    var closeButtons = document.querySelectorAll(".close-button");
    var selectCardButtons = document.querySelectorAll(".select-card"); 
    var paymentRadioButtons = document.querySelectorAll('input[name="payment_method"]');
    var savedPaymentMethod = document.getElementById('saved-payment-method');
    var contactNumberInput = document.getElementById('contact_number');
    var formErrors = document.getElementById('form-errors');

   
    function validateContactNumber() {
        var contactNumber = contactNumberInput.value;
        var isValid = /^\d{10,15}$/.test(contactNumber);

        if (!isValid) {
            contactNumberInput.classList.add('input-error');
            formErrors.textContent = 'Contact number must be between 10 and 15 digits.';
        } else {
            contactNumberInput.classList.remove('input-error');
            formErrors.textContent = '';
        }

        return isValid;
    }

   
    contactNumberInput.addEventListener('input', validateContactNumber);

   
    paymentRadioButtons.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'online' && this.checked) {
                onlinePaymentModal.style.display = "block"; 
            } else {
                onlinePaymentModal.style.display = "none";  
            }
        });
    });

  
    function closeModal() {
        onlinePaymentModal.style.display = "none";
    }

   
    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeModal);
    });

   
    selectCardButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var cardId = button.getAttribute('data-id');
            savedPaymentMethod.value = cardId; 
            closeModal(); 
        });
    });

    
    window.addEventListener('click', function (event) {
        if (event.target === onlinePaymentModal) {
            closeModal();
        }
    });

   
    paymentForm.addEventListener('submit', function (event) {
        if (!validateContactNumber()) {
            event.preventDefault();  
        }
    });
});



</script>


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
