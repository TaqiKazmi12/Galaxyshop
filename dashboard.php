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
