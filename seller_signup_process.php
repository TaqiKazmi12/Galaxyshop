<?php
session_start();
include 'connectionfile.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $businessName = trim($_POST['business-name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($businessName) || empty($email) || empty($password)) {
        header('Location: Usermessage.php?message=' . urlencode('All fields are required.') . '&type=error&redirect=SellerSignUp.php');
        exit();
    }

 
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header('Location: Usermessage.php?message=' . urlencode('Email already exists.') . '&type=error&redirect=SellerSignUp.php');
        $stmt->close();
        exit();
    }
    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, account_type) VALUES (?, ?, ?, 'seller')");
    $stmt->bind_param("sss", $businessName, $email, $hashedPassword);

    if ($stmt->execute()) {
       
        $userId = $stmt->insert_id;
        $_SESSION['seller_id'] = $userId;
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $businessName; 


        header('Location: Usermessage.php?message=' . urlencode('Registration successful! Redirecting to profile page.') . '&type=success&redirect=sellerprofile.php');
        exit();
    } else {
        header('Location: Usermessage.php?message=' . urlencode('Error: ' . $stmt->error) . '&type=error&redirect=SellerSignUp.php');
        exit();
    }

    $stmt->close();
}
$conn->close();
?>
