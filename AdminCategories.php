<?php
include 'connectionfile.php';

// Initialize message variables
$message = '';
$messageType = '';

// Handle category addition
if (isset($_POST['add_category'])) {
    $categoryName = trim($_POST['category_name']);

    if (!empty($categoryName)) {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $categoryName);
        if ($stmt->execute()) {
            $message = "Category added successfully!";
            $messageType = "success";
        } else {
            $message = "Error: Could not add category.";
            $messageType = "error";
        }
        $stmt->close();
    } else {
        $message = "Error: Category name cannot be empty.";
        $messageType = "error";
    }
}

// Handle category deletion
if (isset($_POST['delete_category'])) {
    $categoryId = intval($_POST['category_id']);

    // Start a transaction to ensure atomicity
    $conn->begin_transaction();

    try {
        // Delete products associated with the category
        $deleteProductsSql = "DELETE FROM products WHERE category_id = ?";
        $productStmt = $conn->prepare($deleteProductsSql);
        $productStmt->bind_param('i', $categoryId);
        $productStmt->execute();
        $productStmt->close();

        // Delete the category
        $deleteCategorySql = "DELETE FROM categories WHERE id = ?";
        $categoryStmt = $conn->prepare($deleteCategorySql);
        $categoryStmt->bind_param('i', $categoryId);
        $categoryStmt->execute();
        $categoryStmt->close();

        // Commit transaction
        $conn->commit();
        $message = "Category and associated products deleted successfully!";
        $messageType = "success";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        $message = "Error: Could not delete category. " . $e->getMessage();
        $messageType = "error";
    }
}

// Fetch categories
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GalaxyShop Admin - Categories</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link rel="icon" href="FavLogo.png" type="image/x-icon">
    <style>
        .categories-table {
            margin: 20px;
        }
        .categories-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .categories-table th, .categories-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .categories-table th {
            background-color: #f4f4f4;
        }
        .add-category-form {
            margin: 20px;
        }
        .add-category-form input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            width: 200px;
        }
        .add-category-form button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .add-category-form button:hover {
            background-color: #45a049;
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
        .message-popup.warning {
            background-color: #ff9800;
            margin-top:90px;
            margin-left:80px;
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
                <li><a href="AdminCategories.php" class="active2">Categories</a></li>
                <li><a href="AdminSellerSupport.php" >Seller Support</a></li>

            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Categories</h1>
                <p>Manage your product categories here.</p>
            </div>

            <!-- Warning Message -->
            <div class="message-popup warning" id="warningPopup">
                Deleting a category will also delete all products associated with it.
            </div>


            <div class="add-category-form">
                <form method="POST" action="AdminCategories.php">
                    <input type="text" name="category_name" placeholder="New Category Name" required>
                    <button type="submit" name="add_category">Add Category</button>
                </form>
            </div>

            <div class="categories-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['id']); ?></td>
                                <td><?php echo htmlspecialchars($category['name']); ?></td>
                                <td>
                                    <form method="POST" action="AdminCategories.php" onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all associated products.');">
                                        <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                                        <button type="submit" name="delete_category" class="delete-button">Delete</button>
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
            const warningPopup = document.getElementById('warningPopup');
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

            // Show warning popup
            if (warningPopup) {
                warningPopup.style.display = 'block';
                setTimeout(() => {
                    warningPopup.style.opacity = 0;
                    setTimeout(() => {
                        warningPopup.style.display = 'none';
                        warningPopup.style.opacity = 1; 
                    }, 500); 
                }, 10000);
            }
        });
    </script>
    
          <style>
        .categories-table th {
    background-color: #f4f4f4;
    color: black;
}
   
    </style>
</body>
</html>
