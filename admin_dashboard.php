<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include_once("connections/connection.php");
$pdo = connection();

// Fetch product data
$sql = "SELECT * FROM product_list ORDER BY productID DESC";
$products = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Supplier System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <nav class="sidebar close">
        <header>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="admin_dashboard.php">
                            <i class='bx bxs-user-badge icon'></i>
                            <span class="nav-text">List of Products</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="users.php">
                            <i class='bx bx-user icon'></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li>
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <!-- DASHBOARD -->
    <section class="home">
        <div class="main-content">
            <div class="header-wrapper">
                <div class="header-title">
                    <span></span>
                    <h2>List of Products</h2>
                </div>
                <div class="user-info">
                    <div class="search-box"></div>
                </div>
            </div>
            <div class="table-data">
                <div class="dep">
                    <div class="head">
                        <h3>Product List</h3>
                        <button class="button">
                            <i class='bx bx-plus'></i>
                            <a href="add.php" class="add">
                                <span class="bxs-text">Add Product</span>
                            </a>
                        </button>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             while ($row = $products->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['productID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['productName']); ?></td>
                                    <td><?php echo htmlspecialchars($row['unitPrice']); ?></td>
                                    <td><?php echo htmlspecialchars($row['unitsInStock']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td class="button_form">
                                        <a href="edit.php?ID=<?php echo htmlspecialchars($row['productID']); ?>"><i class='bx bx-edit'></i></a>
                                        <form action="delete.php" method="get" style="display:inline;">
                                            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($row['productID']); ?>">
                                            <button class="button2" type="submit" onclick="return confirm('Are you sure you want to delete this record?')">
                                                <i class='bx bxs-trash'></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
        const body = document.querySelector("body"),
              sidebar = document.querySelector(".sidebar"),
              toggle = document.querySelector(".toggle");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>
</body>
</html>
