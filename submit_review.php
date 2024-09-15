<?php
session_start();
include 'connectionfile.php';


if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

$user_id = $_SESSION['user_id']; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

  
    if ($rating < 1 || $rating > 5) {
        die('Invalid rating.');
    }

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        die('User ID does not exist.');
    }
    $stmt->bind_result($user_id); 
    $stmt->fetch();
    $stmt->close();

    
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        die('Product ID does not exist.');
    }
    $stmt->close();

    
    $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $review);

    if ($stmt->execute()) {
        header('Location: ProductInnerPage.php?id=' . $product_id);
        exit();
    } else {
        die('Error submitting review: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    die('Invalid request.');
}
?>
