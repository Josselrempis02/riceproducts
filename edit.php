<?php
include_once("connections/connection.php");

// Always start session
session_start();

// Connect to database
$con = connection();

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM product_list WHERE productID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Update button function
    if (isset($_POST['update'])) {
        // Sanitize and validate input data
        $productName = mysqli_real_escape_string($con, $_POST['productName']);
        $unitPrice = mysqli_real_escape_string($con, $_POST['unitPrice']);
        $unitsInStock = mysqli_real_escape_string($con, $_POST['unitsInStock']);
        $description = mysqli_real_escape_string($con, $_POST['description']);

        // Use a prepared statement to update the product
        $updateStmt = $con->prepare("UPDATE product_list SET productName = ?, unitPrice = ?, unitsInStock = ?, description = ? WHERE productiD = ?");
        $updateStmt->bind_param("ssisi", $productName, $unitPrice, $unitsInStock, $description, $productID);

        if ($updateStmt->execute()) {
            // Successful submission
            $_SESSION['success_message'] = "Changes have been successfully updated.";
            echo '<script>alert("Changes have been successfully updated!"); window.location.href = "admin_dashboard.php?ID=' . $productID . '";</script>';
            exit; // Exit to prevent further execution
        } else {
            // Error handling
            $_SESSION['error_message'] = "Error updating record: " . $con->error;
            echo '<script>alert("Error updating record: ' . $con->error . '"); window.location.href = "edit.php";</script>';
            exit; // Exit to prevent further execution
        }
        $updateStmt->close();
    }

    // Cancel button function
    if (isset($_POST['cancel'])) {
        // Redirect to employee.php using JavaScript
        echo '<script>window.location.href = "admin_dashboard.php?ID=' . $productID . '";</script>';
        exit;
    }
}
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
            <div class="image-text">
                <span class="image">
                    <img src="assets/employee.png" alt="logo">
                </span>
                <div class="text header-text">
                    <span class="name">Supplier System</span>
                </div>
            </div>
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
                <li class="">
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
                    <h2>Supplier System</h2>
                </div>
                <div class="user-info">
                    <div class="search-box"></div>
                    <img src="assets/profile.jpg" alt="">
                </div>
            </div>

            <div class="table-data">
                <div class="dep">
                    <div class="head">
                        <h3>Edit Product</h3>
                        <i class='bx bx-filter'></i>
                    </div>

                    <div class="container">
                        <form action="" method="post">
                            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($row['productID']); ?>">
                            <div class="form first">
                                <div class="details personal">
                                    <span class="title">Product Details</span>
                                    <div class="fields">
                                        <div class="input-field">
                                            <label>Product Name</label>
                                            <input type="text" placeholder="Enter your product name" name="productName" value="<?php echo htmlspecialchars($row['productName']); ?>" required>
                                        </div>
                                        <div class="input-field">
                                            <label>Price</label>
                                            <input type="text" placeholder="Enter price" name="unitPrice" value="<?php echo htmlspecialchars($row['unitPrice']); ?>" required>
                                        </div>
                                        <div class="input-field">
                                            <label>Stock</label>
                                            <input type="text" placeholder="Enter your stock" name="unitsInStock" value="<?php echo htmlspecialchars($row['unitsInStock']); ?>" required>
                                        </div>
                                        <div class="input-field">
                                            <label>Description</label>
                                            <input type="text" placeholder="Enter description" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="details ID">
                                    <button class="submit" name="cancel">
                                        <input class="btnText" type="submit" name="cancel" value="Cancel">
                                        <i class="uil uil-navigator"></i>
                                    </button>
                                    <button class="submit" name="update">
                                        <input class="btnText" type="submit" name="update" value="Update">
                                        <i class="uil uil-navigator"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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
