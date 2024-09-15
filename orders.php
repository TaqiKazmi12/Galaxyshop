<?php
session_start();
include 'connectionfile.php'; 

if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

$user_id = $_SESSION['user_id'];

// Debugging: Print the user_id
// echo "Session User ID: " . htmlspecialchars($user_id) . "<br>";


$query = "
    SELECT o.id, o.total, o.status, p.name AS product_name, p.image_url, p.price
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = (
        SELECT id FROM users WHERE email = ?
    )
";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . $conn->error);
}


$stmt->bind_param("s", $user_id);

$execute_result = $stmt->execute();
if ($execute_result === false) {
    die('Execute failed: ' . $stmt->error);
}

$orders_result = $stmt->get_result();
if ($orders_result === false) {
    die('Get result failed: ' . $stmt->error);
}

// Debugging: Show number of rows fetched
// echo "Number of orders found: " . $orders_result->num_rows . "<br>";

if ($orders_result->num_rows > 0) {
    $orders = $orders_result->fetch_all(MYSQLI_ASSOC);
} else {
    $orders = [];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop | Your Orders</title>
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zilla+Slab+Highlight:wght@700&family=Norican&display=swap">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image:url(FaqBg.png);
            margin: 0;
            padding: 0;
        }

        .orders-header {
            background-color: transparent;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .orders-container {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .orders-table th, .orders-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
td{
    color:black;
}
        .orders-table th {
            background-color: yellow;
            color: black;
            font-weight: bold;
        }

        .orders-table tbody tr:hover {
            background-color: #f5f5f5;
            transform: scale(1.02);
        }

        .product-image {
            width: 120px; 
            height: auto;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.1);
        }

        .status {
            text-transform: capitalize;
            font-weight: bold;
        }

        .status.pending {
            color: green;
            transition: color 0.3s ease;
        }

        .status.completed {
            color: blue;
            transition: color 0.3s ease;
        }

        .status.cancelled {
            color: red;
            transition: color 0.3s ease;
        }


        @media (max-width: 768px) {
            .orders-table, .orders-table thead, .orders-table tbody, .orders-table th, .orders-table td, .orders-table tr {
                display: block;
            }

            .orders-table th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .orders-table tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
                display: block;
                padding: 10px;
            }

            .orders-table td {
                border: none;
                display: block;
                font-size: 14px;
                text-align: right;
                position: relative;
                padding-left: 50%;
            }

            .orders-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }
        footer{
            margin-top:280px;
        }
    </style>
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
                <li><a href="products.php" >Products</a></li>
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



    <header class="orders-header">
        <h1>Your Orders</h1>
    </header>

    <div class="orders-container">
        <?php if (!empty($orders)): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1;  ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td> 
                            <td><img src="<?php echo htmlspecialchars($order['image_url']); ?>" alt="Product Image" class="product-image"></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td>$<?php echo number_format($order['price'], 2); ?></td>
                            <td class="status <?php echo strtolower($order['status']); ?>" data-label="Status"><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="emptycart">No orders found Order now <a href="Products.php">Order</a></p>
        <?php endif; ?>
    </div>
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
    
    <script src="Navbar.js"></script>
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
