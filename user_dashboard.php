<?php
session_start();

// Check if the user is logged in and is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
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
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search'></i>
                    </div>
                </div>
            </div>
            <div class="table-data">
                <div class="dep">
                    <div class="head">
                        <h3>Product List</h3>
                        <i class='bx bx-filter'></i>
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
