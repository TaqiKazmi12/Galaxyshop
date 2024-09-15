<?php
session_start();
include 'connectionfile.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    if (empty($email) || empty($password)) {
        echo 'All fields are required.';
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password, name, email, account_type FROM users WHERE email = ? AND account_type = 'seller'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo 'Invalid email or not a seller.';
        $stmt->close();
        exit();
    }

 
    $stmt->bind_result($userId, $hashedPassword, $name, $email, $accountType);
    $stmt->fetch();


    if (password_verify($password, $hashedPassword)) {
      
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['account_type'] = $accountType;

       
        $_SESSION['seller_id'] = $userId; 

        header('Location: SellerHomePage.php'); 
        exit();
    } else {
        echo 'Invalid password.';
    }

    $stmt->close();
}
$conn->close();
?>
