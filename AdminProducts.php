<?php
include 'connectionfile.php';

if (isset($_GET['delete'])) {
    $productId = intval($_GET['delete']);
    $sql = "DELETE FROM wishlists WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $stmt->close();
    
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $stmt->close();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin - Products</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <style>
        .products-table {
            margin: 20px;
        }
        .products-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .products-table th {
            background-color: #f4f4f4;
        }
        .products-table img {
            max-width: 100px;
            height: auto;
        }
        .products-table a {
            color: red;
            text-decoration: none;
        }
        .products-table a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>GalaxyShop</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="AdminDashboard.php">Dashboard</a></li>
                <li><a href="AdminProducts.php" class="active2">Products</a></li>
                <li><a href="AdminOrders.php"  >Orders</a></li>
                <li><a href="AdminUsers.php">Users</a></li>
                <li><a href="AdminCategories.php" >Categories</a></li>
                <li><a href="AdminSellerSupport.php" >Seller Support</a></li>

            </ul>
        </aside>


        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Products</h1>
                <p>Manage your products here.</p>
            </div>

            <div class="products-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['description']); ?></td>
                                <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                                <td>
                                    <a href="?delete=<?php echo htmlspecialchars($product['id']); ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <style>
        .products-table th {
    background-color: #f4f4f4;
    color: black;
}
    </style>
</body>
</html>
