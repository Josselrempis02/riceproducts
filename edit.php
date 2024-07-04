<?php
include_once("connections/connection.php");

// Always start session
session_start();

// Connect to database
$con = connection();

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Display the product data
    $sql = "SELECT * FROM product_list WHERE productID = '$productID'";
    $products = $con->query($sql) or die($con->error);

    if ($products->num_rows > 0) {
        $row = $products->fetch_assoc();
    } else {
        die("Product not found.");
    }

    // Update button function
    if (isset($_POST['update'])) {
        // Sanitize and validate input data
        $productName = mysqli_real_escape_string($con, $_POST['productName']);
        $unitPrice = mysqli_real_escape_string($con, $_POST['unitPrice']);
        $unitsInStock = mysqli_real_escape_string($con, $_POST['unitsInStock']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        
        // Update query
        $updateSql = "UPDATE product_list SET productName='$productName', unitPrice='$unitPrice', unitsInStock='$unitsInStock', description='$description' WHERE productID='$productID'";

        if ($con->query($updateSql) === TRUE) {
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
    }

    // Cancel button function
    if (isset($_POST['cancel'])) {
        // Redirect to employee.php using JavaScript
        echo '<script>window.location.href = "admin_dashboard.php?ID=' . $productID . '";</script>';
        exit;
    }
} else {
    die("Product ID not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Product</title>
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
                    <h2>Edit Product</h2>
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
