<?php
session_start();
include 'connectionfile.php'; 


if (!isset($_SESSION['user_id'])) {
    header('Location: contactus.php'); 
    exit;
}

$user_id = $_SESSION['user_id']; 

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;


if ($product_id <= 0) {
    $message = 'Invalid product ID.';
    $redirect_url = 'contactus.php';
    $delay = 5;
    include 'message_template.php'; 
    exit;
}


$query = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
if ($stmt->get_result()->num_rows == 0) {
    $message = 'Invalid user ID.';
    $redirect_url = 'contactus.php';
    $delay = 5;
    include 'message_template.php'; 
    exit;
}


$query = "SELECT id FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
if ($stmt->get_result()->num_rows == 0) {
    $message = 'Invalid product ID.';
    $redirect_url = 'contactus.php';
    $delay = 5;
    include 'message_template.php'; 
    exit;
}


$query = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id_db = $user['id'];


$query = "SELECT * FROM wishlists WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id_db, $product_id);
$stmt->execute();
$existing_item = $stmt->get_result()->fetch_assoc();

if ($existing_item) {
    $message = 'This product is already in your Cart. Redirecting to cart...';
    $redirect_url = 'cart.php';
    $delay = 5;
    include 'message_template.php'; 
    exit;
} else {
   
    $query = "INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id_db, $product_id);
    if ($stmt->execute() === false) {
        $message = 'Error adding item to Cart. Please contact support.';
        $redirect_url = 'ContactUs.php';
        $delay = 5;
        include 'message_template.php'; 
        exit;
    }

    $message = 'Product added to Cart successfully. Redirecting to cart...';
    $redirect_url = 'cart.php';
    $delay = 5;
    include 'message_template.php'; 
    exit;
}

$stmt->close();
$conn->close();
?>
