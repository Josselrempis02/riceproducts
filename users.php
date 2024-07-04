<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include_once("connections/connection.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Employee Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
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
                    <span class="name">Employee Management</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
          <div class="menu">
            <!-- <li class="search-box">
              <a href="#">
                <i class='bx bx-search-alt icon'></i>
                <input type="search" placeholder="Search...">
              </a>
            </li> -->
            <ul class="menu-links">
              <li class="nav-link">
                <a href="index.php">
                  <i class='bx bx-home-alt icon' ></i>
                  <span class="nav-text">Dashboard</span>
                </a>
              </li>
              <li class="nav-link">
                <a href="department.php">
                  <i class='bx bx-buildings icon'></i>
                  <span class="nav-text">Department</span>
                </a>
              </li>
              <li class="nav-link">
                <a href="employee.php">
                  <i class='bx bxs-user-badge icon'></i>
                  <span class="nav-text">Employee</span>
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
                <?php
                 $sql = "SELECT * from admins";
                 $query = mysqli_query($con, $sql);
                 $result = mysqli_fetch_assoc($query)
                  ?>
                    <span></span>
                    <h2>Users</h2>
                </div>
                <div class="user-info">
                    <div class="search-box">
                    </div>
                    <img src="assets/profile.png" alt="">
                </div>
            </div>

            <div class="table-data">
                <div class="dep">
                    <div class="head">
                        <h3>List of Users</h3>
                        <i class='bx bx-filter'></i>
                    </div>
                    <table>
                    <?php
                  $sql = "SELECT * FROM `admins` ORDER BY id DESC";
                  $employee_result = $con->query($sql) or die($con->error);
                  ?>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                      // Loop through the result set
                      while ($row = $employee_result->fetch_assoc()) {
                      ?>
                            <tr>
                                <td>
                                    <img src="assets/profile.png" alt="">
                                    <p><?php echo $row['fullname']; ?></p>
                                </td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                  <i class='bx bx-show icons'></i>
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

</body>

</html>



      










      
       

          <script>
            const body = document.querySelector("body"),
            sidebar = document.querySelector(".sidebar"),
            toggle = document.querySelector(".toggle");

            toggle.addEventListener("click", () =>{
              sidebar.classList.toggle("close");
 });
          </script>
    </body>
</html>