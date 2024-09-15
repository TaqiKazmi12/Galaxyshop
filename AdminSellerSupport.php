<?php
include 'connectionfile.php';
$message = '';
$messageType = '';
if (isset($_POST['respond_support'])) {
    $requestId = intval($_POST['request_id']);
    $response = trim($_POST['response']);
    if ($response) {
        $updateSql = "UPDATE sellersupport SET response = ?, responded_at = NOW() WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('si', $response, $requestId);
        if ($updateStmt->execute()) {
            $message = "Response sent successfully!";
            $messageType = "success";
        } else {
            $message = "Error: Could not send response.";
            $messageType = "error";
        }
        $updateStmt->close();
    } else {
        $message = "Error: Response cannot be empty.";
        $messageType = "error";
    }
}

if (isset($_POST['delete_request'])) {
    $requestId = intval($_POST['request_id']);
    $deleteSql = "DELETE FROM sellersupport WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('i', $requestId);
    if ($deleteStmt->execute()) {
        $message = "Support request deleted successfully!";
        $messageType = "success";
    } else {
        $message = "Error: Could not delete support request.";
        $messageType = "error";
    }
    $deleteStmt->close();
}

$supportSql = "SELECT * FROM sellersupport ORDER BY created_at DESC";
$supportResult = $conn->query($supportSql);
$supportRequests = [];
while ($row = $supportResult->fetch_assoc()) {
    $supportRequests[] = $row;
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin - Seller Support</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <style>
        .support-table {
            margin: 20px;
        }
        .support-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .support-table th, .support-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .support-table th {
            background-color: #f4f4f4;
        }
        .respond-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .respond-button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #f44336;
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
                <li><a href="AdminUsers.php">Users</a></li>
                <li><a href="AdminCategories.php">Categories</a></li>
                <li><a href="AdminSellerSupport.php" class="active2">Seller Support</a></li>

            </ul>
        </aside>
        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Seller Support</h1>
                <p>Manage seller support requests here.</p>
            </div>

            <div class="support-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Issue Type</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Response</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($supportRequests as $request): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($request['id']); ?></td>
                                <td><?php echo htmlspecialchars($request['name']); ?></td>
                                <td><?php echo htmlspecialchars($request['email']); ?></td>
                                <td><?php echo htmlspecialchars($request['issue_type']); ?></td>
                                <td><?php echo htmlspecialchars($request['description']); ?></td>
                                <td><?php echo htmlspecialchars($request['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($request['response']) ?: 'No response yet'; ?></td>
                                <td>
                                    <!-- Respond to support request -->
                                    <form method="POST" action="AdminSellerSupport.php" style="display: inline-block;">
                                        <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                                        <textarea name="response" placeholder="Type your response here..." rows="3" required></textarea><br>
                                        <button type="submit" name="respond_support" class="respond-button">Send Response</button>
                                    </form>

                                    <!-- Delete support request -->
                                    <form method="POST" action="AdminSellerSupport.php" style="display: inline-block; margin-left: 5px;" onsubmit="return confirm('Are you sure you want to delete this support request?');">
                                        <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                                        <button type="submit" name="delete_request" class="delete-button">Delete</button>
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
        .support-table th {
    background-color: #f4f4f4;
    color: black;
        }

    .delete-button {
    background-color: #d32f2f;
    margin: 10px;

}
    </style>
</body>
</html>
