
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

include 'connectionfile.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: UserLogin.php');
    exit();
}

$userEmail = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();
} else {
    $_SESSION['message'] = "User does not exist.";
    header('Location: UserLogin.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = '';

    if (isset($_POST['add_payment'])) {
        $cardNumber = $_POST['card_number'];
        $cardHolderName = $_POST['card_holder_name'];
        $expirationDate = $_POST['expiration_date'];
        $isPrimary = isset($_POST['is_primary']) ? 1 : 0;

   
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            $error = "Invalid card number. It should be 16 digits.";
        } elseif (!validateExpirationDate($expirationDate)) {
            $error = "Invalid expiration date.";
        } else {
       
            $stmt = $conn->prepare("SELECT id FROM payment_methods WHERE user_id = ? AND card_number = ?");
            $stmt->bind_param("is", $userId, $cardNumber);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "This card has already been added.";
            } else {
               
                if ($isPrimary) {
                    $stmt = $conn->prepare("UPDATE payment_methods SET is_primary = 0 WHERE user_id = ?");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $stmt->close();
                }

           
                $stmt = $conn->prepare("INSERT INTO payment_methods (user_id, card_number, card_holder_name, expiration_date, is_primary, payment_type) VALUES (?, ?, ?, ?, ?, 'card')");
                $stmt->bind_param("isssi", $userId, $cardNumber, $cardHolderName, $expirationDate, $isPrimary);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Payment method added successfully.";
                } else {
                    $_SESSION['message'] = "Error adding payment method: " . $stmt->error;
                }

                $stmt->close();
                header('Location: manage_payment.php');
                exit();
            }

            $stmt->close();
        }
    } elseif (isset($_POST['update_payment'])) {
        $paymentId = $_POST['payment_id'];
        $cardNumber = $_POST['card_number'];
        $cardHolderName = $_POST['card_holder_name'];
        $expirationDate = $_POST['expiration_date'];
        $isPrimary = isset($_POST['is_primary']) ? 1 : 0;

     
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            $error = "Invalid card number. It should be 16 digits.";
        } elseif (!validateExpirationDate($expirationDate)) {
            $error = "Invalid expiration date.";
        } else {
           
            $stmt = $conn->prepare("SELECT id FROM payment_methods WHERE user_id = ? AND card_number = ? AND id != ?");
            $stmt->bind_param("isi", $userId, $cardNumber, $paymentId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "This card has already been added.";
            } else {
               
                if ($isPrimary) {
                    $stmt = $conn->prepare("UPDATE payment_methods SET is_primary = 0 WHERE user_id = ?");
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $stmt->close();
                }

            
                $stmt = $conn->prepare("UPDATE payment_methods SET card_number = ?, card_holder_name = ?, expiration_date = ?, is_primary = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("sssiii", $cardNumber, $cardHolderName, $expirationDate, $isPrimary, $paymentId, $userId);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Payment method updated successfully.";
                } else {
                    $_SESSION['message'] = "Error updating payment method: " . $stmt->error;
                }

                $stmt->close();
                header('Location: manage_payment.php');
                exit();
            }

            $stmt->close();
        }
    } elseif (isset($_POST['delete_payment'])) {
        $paymentId = $_POST['payment_id'];

        $stmt = $conn->prepare("DELETE FROM payment_methods WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $paymentId, $userId);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Payment method deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting payment method: " . $stmt->error;
        }

        $stmt->close();
        header('Location: manage_payment.php');
        exit();
    }


    if ($error) {
        $_SESSION['message'] = $error;
        header('Location: manage_payment.php');
        exit();
    }
}

$stmt = $conn->prepare("SELECT id, card_number, card_holder_name, expiration_date, is_primary FROM payment_methods WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($paymentId, $cardNumber, $cardHolderName, $expirationDate, $isPrimary);

$paymentMethods = [];
while ($stmt->fetch()) {
    $paymentMethods[] = [
        'id' => $paymentId,
        'card_number' => $cardNumber,
        'card_holder_name' => $cardHolderName,
        'expiration_date' => $expirationDate,
        'is_primary' => $isPrimary
    ];
}
$stmt->close();
$conn->close();

function validateExpirationDate($date) {
    $today = new DateTime();
    $expiryDate = DateTime::createFromFormat('Y-m-d', $date);
    return $expiryDate && $expiryDate >= $today;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Payment Methods</title>
   
    <link rel="stylesheet" href="manage_payment.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">

    <style>
        .search-container button {
    padding: 8px 12px;
    border: none;
    background-color: #001f3f;
    color: white;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.3s;
    top: -42px !important;
    float: right !important;
    left: 30px !important;
}
        .update-form {
            display: none;
            margin-top: 20px;
        }
        .update-form.active {
            display: block;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .modal.show {
            display: flex;
        }
        .modal-close {
            float: right;
            cursor: pointer;
            font-size: 20px;
            color: #333;
        }
        .modal-message {
            margin: 0;
        }
        .footer {
  
    margin-top: 130px;
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

    <main>
        <h1>Manage Payment Methods</h1>

        <form id="add-form" action="manage_payment.php" method="post">
            <h2>Add New Payment Method</h2>
            <div class="error" id="add-error"></div>
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="card_number" maxlength="16" required>
            
            <label for="card_holder_name">Card Holder Name:</label>
            <input type="text" id="card_holder_name" name="card_holder_name" required>
            
            <label for="expiration_date">Expiration Date (YYYY-MM-DD):</label>
            <input type="date" id="expiration_date" name="expiration_date" required>
            
            <label for="is_primary">Set as Primary:</label>
            <input type="checkbox" id="is_primary" name="is_primary">
            
            <button type="submit" name="add_payment">Add Payment Method</button>
        </form>

        <h2>Existing Payment Methods</h2>
        <?php if (!empty($paymentMethods)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Card Number</th>
                        <th>Card Holder Name</th>
                        <th>Expiration Date</th>
                        <th>Primary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paymentMethods as $method): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($method['card_number']); ?></td>
                            <td><?php echo htmlspecialchars($method['card_holder_name']); ?></td>
                            <td><?php echo htmlspecialchars($method['expiration_date']); ?></td>
                            <td><?php echo $method['is_primary'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <button type="button" onclick="showUpdateForm(<?php echo $method['id']; ?>, '<?php echo htmlspecialchars($method['card_number']); ?>', '<?php echo htmlspecialchars($method['card_holder_name']); ?>', '<?php echo htmlspecialchars($method['expiration_date']); ?>', <?php echo $method['is_primary']; ?>)">Update</button>

                                <form action="manage_payment.php" method="post" style="display:inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="payment_id" value="<?php echo $method['id']; ?>">
                                    <button type="submit" name="delete_payment">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no cards.</p>
        <?php endif; ?>

        <div id="update-form" class="update-form">
            <h2>Update Payment Method</h2>
            <div class="error" id="update-error"></div>
            <form action="manage_payment.php" method="post">
                <input type="hidden" id="update_payment_id" name="payment_id">
                
                <label for="update_card_number">Card Number:</label>
                <input type="text" id="update_card_number" name="card_number" maxlength="16" required>
                
                <label for="update_card_holder_name">Card Holder Name:</label>
                <input type="text" id="update_card_holder_name" name="card_holder_name" required>
                
                <label for="update_expiration_date">Expiration Date (YYYY-MM-DD):</label>
                <input type="date" id="update_expiration_date" name="expiration_date" required>
                
                <label for="update_is_primary">Set as Primary:</label>
                <input type="checkbox" id="update_is_primary" name="is_primary">
                
                <button type="submit" name="update_payment">Done</button>
            </form>
        </div>
    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="hideModal()">&times;</span>
            <p id="modal-message" class="modal-message"></p>
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

    <script src="Navbar.js"></script>
    <script>
        function showModal(message, duration = 3000) {
            const modal = document.getElementById('modal');
            const modalMessage = document.getElementById('modal-message');
            modalMessage.textContent = message;
            modal.classList.add('show');
            setTimeout(() => {
                modal.classList.remove('show');
            }, duration);
        }

        function hideModal() {
            document.getElementById('modal').classList.remove('show');
        }

        document.getElementById('card_number').addEventListener('input', validateCardNumber);
        document.getElementById('expiration_date').addEventListener('change', validateExpirationDate);

        function validateCardNumber() {
            const cardNumber = document.getElementById('card_number').value;
            const addError = document.getElementById('add-error');

            if (!/^\d{16}$/.test(cardNumber)) {
                addError.textContent = "Invalid card number. It should be 16 digits.";
            } else {
                addError.textContent = "";
            }
        }

        function validateExpirationDate() {
            const expirationDate = document.getElementById('expiration_date').value;
            const today = new Date();
            const expiryDate = new Date(expirationDate);
            const addError = document.getElementById('add-error');

            if (expiryDate < today) {
                addError.textContent = "The expiration date must be in the future.";
            } else {
                addError.textContent = "";
            }
        }

        document.getElementById('update_card_number').addEventListener('input', validateUpdateCardNumber);
        document.getElementById('update_expiration_date').addEventListener('change', validateUpdateExpirationDate);

        function validateUpdateCardNumber() {
            const cardNumber = document.getElementById('update_card_number').value;
            const updateError = document.getElementById('update-error');

            if (!/^\d{16}$/.test(cardNumber)) {
                updateError.textContent = "Invalid card number. It should be 16 digits.";
            } else {
                updateError.textContent = "";
            }
        }

        function validateUpdateExpirationDate() {
            const expirationDate = document.getElementById('update_expiration_date').value;
            const today = new Date();
            const expiryDate = new Date(expirationDate);
            const updateError = document.getElementById('update-error');

            if (expiryDate < today) {
                updateError.textContent = "The expiration date must be in the future.";
            } else {
                updateError.textContent = "";
            }
        }

        function showUpdateForm(id, cardNumber, cardHolderName, expirationDate, isPrimary) {
            document.getElementById('update_payment_id').value = id;
            document.getElementById('update_card_number').value = cardNumber;
            document.getElementById('update_card_holder_name').value = cardHolderName;
            document.getElementById('update_expiration_date').value = expirationDate;
            document.getElementById('update_is_primary').checked = isPrimary == 1;
            document.getElementById('update-form').classList.add('active');
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this payment method?');
        }

        <?php if (isset($_SESSION['message'])): ?>
            document.addEventListener('DOMContentLoaded', () => {
                showModal('<?php echo $_SESSION['message']; ?>', 5000);
                <?php unset($_SESSION['message']); ?>
            });
        <?php endif; ?>
    </script>
</body>
</html>
