<?php
session_start();
include 'connectionfile.php'; 

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    die('User not logged in.');
}

$email = $_SESSION['user_id'];

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$contact_number = isset($_POST['contact_number']) ? trim($_POST['contact_number']) : '';
$payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';

if ($product_id <= 0 || empty($address) || empty($contact_number) || empty($payment_method)) {
    die('Invalid input.');
}

$query = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows === 0) {
    die('Invalid user email.');
}

$user = $user_result->fetch_assoc();
$user_id = $user['id']; 

$query = "SELECT name, price FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die('Product not found.');
}

$total = $product['price'];
$product_name = $product['name'];
$quantity = 1; 

$query = "INSERT INTO orders (user_id, total, address, contact_number, payment_method, product_id, product_name, quantity, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($query);
$stmt->bind_param("idssssss", $user_id, $total, $address, $contact_number, $payment_method, $product_id, $product_name, $quantity);
$stmt->execute();
$order_id = $stmt->insert_id;  


$stmt->close();
$conn->close();


header("Location: order_confirmation.php?id=" . $order_id);
exit();
?>
