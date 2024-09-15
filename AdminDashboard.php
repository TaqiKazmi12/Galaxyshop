<?php
include 'connectionfile.php';
$sql = "SELECT COUNT(*) AS total_products FROM products";
$result = $conn->query($sql);
$totalProducts = $result->fetch_assoc()['total_products'] ?? 0;
$sql = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($sql);
$totalOrders = $result->fetch_assoc()['total_orders'] ?? 0;
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);
$totalUsers = $result->fetch_assoc()['total_users'] ?? 0;
$sql = "SELECT id, CONCAT(user_id, ': ', product_name) AS customer, status, total FROM orders ORDER BY order_date DESC LIMIT 5";
$result = $conn->query($sql);
$recentOrders = [];
while ($row = $result->fetch_assoc()) {
    $recentOrders[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin Dashboard</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>GalaxyShop</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="AdminDashboard.php" class="active2">Dashboard</a></li>
                <li><a href="AdminProducts.php">Products</a></li>
                <li><a href="AdminOrders.php">Orders</a></li>
                <li><a href="AdminUsers.php">Users</a></li>
                <li><a href="AdminCategories.php" >Categories</a></li>
                <li><a href="AdminSellerSupport.php" >Seller Support</a></li>

            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Welcome, Admin</h1>
                <p>Here's an overview of your shop's performance.</p>
            </div>

            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Products</h3>
                    <p><?php echo $totalProducts; ?></p>
                </div>
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?php echo $totalUsers; ?></p>
                </div>
            </div>

            <div class="recent-orders">
                <h2>Recent Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['customer']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                                <td><?php echo $order['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
