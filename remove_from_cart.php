<?php
session_start();
include 'connectionfile.php'; 

if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to modify your cart.');
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];


    $query = "DELETE FROM wishlists WHERE user_id = (SELECT id FROM users WHERE email = ?) AND product_id = ?";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $user_id, $product_id); 
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }

   
    $stmt->close();
}

header('Location: cart.php');  
exit();
?>
