<?php
include 'connectionfile.php';


$message = '';
$messageType = '';


if (isset($_POST['delete_user'])) {
    $userId = intval($_POST['user_id']);


    $conn->begin_transaction();

    try {

        $userSql = "SELECT account_type FROM users WHERE id = ?";
        $userStmt = $conn->prepare($userSql);
        $userStmt->bind_param('i', $userId);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $user = $userResult->fetch_assoc();
        if ($user) {
            $accountType = $user['account_type'];

            $deleteOrdersSql = "DELETE FROM orders WHERE user_id = ?";
            $orderStmt = $conn->prepare($deleteOrdersSql);
            $orderStmt->bind_param('i', $userId);
            $orderStmt->execute();
            $orderStmt->close();

            if ($accountType == 'seller') {
           
                $deleteWishlistsSql = "DELETE w FROM wishlists w JOIN products p ON w.product_id = p.id WHERE p.seller_id = ?";
                $wishlistStmt = $conn->prepare($deleteWishlistsSql);
                $wishlistStmt->bind_param('i', $userId);
                $wishlistStmt->execute();
                $wishlistStmt->close();

          
                $deleteProductsSql = "DELETE FROM products WHERE seller_id = ?";
                $productStmt = $conn->prepare($deleteProductsSql);
                $productStmt->bind_param('i', $userId);
                $productStmt->execute();
                $productStmt->close();
            }

        
            $deleteUserSql = "DELETE FROM users WHERE id = ?";
            $userStmt = $conn->prepare($deleteUserSql);
            $userStmt->bind_param('i', $userId);
            $userStmt->execute();
            $userStmt->close();

            $conn->commit();
            $message = "User and associated records deleted successfully!";
            $messageType = "success";
        } else {
            throw new Exception("User not found.");
        }
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        $message = "Error: Could not delete user. " . $e->getMessage();
        $messageType = "error";
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = [];
while ($row = $result->fetch_assoc()) {
    $ordersSql = "SELECT COUNT(*) AS item_count FROM orders WHERE user_id = ?";
    $orderStmt = $conn->prepare($ordersSql);
    $orderStmt->bind_param('i', $row['id']);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();
    $orderData = $orderResult->fetch_assoc();
    $orderCount = $orderData ? $orderData['item_count'] : 0;
    $orderStmt->close();

    $row['item_count'] = $orderCount;
    $users[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin - Users</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <style>
        .users-table {
            margin: 20px;
        }
        .users-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .users-table th, .users-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .users-table th {
            background-color: #f4f4f4;
        }
        .delete-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .message-popup {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            display: none;
        }
        .message-popup.error {
            background-color: #f44336;
        }
        .message-popup.success {
            background-color: #4CAF50;
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
                <li><a href="AdminOrders.php">Orders</a></li>
                <li><a href="AdminUsers.php" class="active2">Users</a></li>
                <li><a href="AdminCategories.php" >Categories</a></li>
                <li><a href="AdminSellerSupport.php" >Seller Support</a></li>

            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Users</h1>
                <p>Manage your users here.</p>
            </div>

            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Items Ordered</th>
                            <th>Account Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['item_count']); ?></td>
                                <td><?php echo htmlspecialchars($user['account_type']); ?></td>
                                <td>
                                    <form method="POST" action="AdminUsers.php" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <button type="submit" name="delete_user" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Message Popup -->
    <div id="messagePopup" class="message-popup <?php echo $messageType; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const messagePopup = document.getElementById('messagePopup');
            if (messagePopup.innerText.trim() !== '') {
                messagePopup.style.display = 'block';
                setTimeout(() => {
                    messagePopup.style.opacity = 0;
                    setTimeout(() => {
                        messagePopup.style.display = 'none';
                        messagePopup.style.opacity = 1; 
                    }, 500); 
                }, 5000);
            }
        });
    </script>
     <style>
        .users-table th {
    background-color: #f4f4f4;
    color: black;
}
    </style>
</body>

</html>
