<?php
include 'connectionfile.php';
if (isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = $_POST['status'];
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $newStatus, $orderId);
    $stmt->execute();
    $stmt->close();
}
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin - Orders</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <style>
        .orders-table {
            margin: 20px;
        }
        .orders-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .orders-table th, .orders-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .orders-table th {
            background-color: #f4f4f4;
        }
        .orders-table img {
            max-width: 100px;
            height: auto;
        }
        .status-select {
            width: 120px;
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
                <li><a href="AdminProducts.php">Products</a></li>
                <li><a href="AdminOrders.php"  class="active2">Orders</a></li>
                <li><a href="AdminUsers.php">Users</a></li>
                <li><a href="AdminCategories.php" >Categories</a></li>
                <li><a href="AdminSellerSupport.php" >Seller Support</a></li>

            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Orders</h1>
                <p>Manage your orders here.</p>
            </div>

            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td>$<?php echo htmlspecialchars($order['total']); ?></td>
                                <td>
                                    <form method="POST" action="AdminOrders.php">
                                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                        <select name="status" class="status-select">
                                            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                            <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                            <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                            <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <style>
        .orders-table th {
    background-color: #f4f4f4;
    color: black;
}
    </style>
</body>
</html>
