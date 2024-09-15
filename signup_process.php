<?php
session_start();
require_once 'connectionfile.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $accountType = isset($_POST['account_type']) ? $_POST['account_type'] : 'buyer'; 

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR name = ?");
    $stmt->bind_param('ss', $email, $name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
    
        $emailTaken = false;
        $nameTaken = false;

     
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($emailCount);
        $stmt->fetch();
        $stmt->close();

        if ($emailCount > 0) {
            $emailTaken = true;
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($nameCount);
        $stmt->fetch();
        $stmt->close();

        if ($nameCount > 0) {
            $nameTaken = true;
        }

   
        $message = '';
        if ($emailTaken && $nameTaken) {
            $message = 'Both email and name are already taken.';
        } elseif ($emailTaken) {
            $message = 'Email is already taken.';
        } elseif ($nameTaken) {
            $message = 'Name is already taken.';
        }

        header('Location: Usermessage.php?message=' . urlencode($message) . '&type=error&redirect=UserSignUp.php');
        exit();
    } else {
       
        $sql = "INSERT INTO users (name, email, password, account_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $password, $accountType);

        if ($stmt->execute()) {
          
            $_SESSION['user_id'] = $email; 
            header('Location: profile.php'); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
