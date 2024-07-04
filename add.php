<?php
session_start();

// Connect to the database
include_once("connections/connection.php");
$con = connection();

if (isset($_POST['submit'])) {
    $productName = mysqli_real_escape_string($con, $_POST['productName']);
	$price = mysqli_real_escape_string($con, $_POST['unitPrice']);
    $stock = mysqli_real_escape_string($con, $_POST['unitsInStock']);
	$desc = mysqli_real_escape_string($con, $_POST['description']);
   
  

  
    $sql = "INSERT INTO `product_list` (`productName`, `unitPrice`, `unitsInStock`, `description`)
            VALUES ('$productName','$price', '$stock','$desc')";

    if ($con->query($sql) === TRUE) {
        // Successful submission
        $_SESSION['success_message'] = "New employee added successfully!";
        echo '<script>alert("New product added successfully!"); window.location.href = "admin_dashboard.php";</script>';
        exit; // Exit to prevent further execution
    } else {
        // Error handling
        $_SESSION['error_message'] = "Error add new record: " . $con->error;
        echo '<script>alert("Error updating record: ' . $con->error . '"); window.location.href = "add.php";</script>';
        exit; // Exit to prevent further execution
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
            <!-- <li class="search-box">
              <a href="#">
                <i class='bx bx-search-alt icon'></i>
                <input type="search" placeholder="Search...">
              </a>
            </li> -->
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
            <div class="search-box">
                 
          </div>
          <img src="assets/profile.jpg" alt="">
          </div>
        </div>

       


          <div class="table-data">
            <div class="dep">
              <div class="head">
                <h3>Add New Product</h3>                
                <i class='bx bx-filter'></i>
              </div>
            

              <div class="container">
                <form action="" method="post">
                    <div class="form first">
                        <div class="details personal">
                            <span class="title">Product Details</span>
                            <div class="fields">
                                <div class="input-field">
                                    <label>Product Name</label>
                                    <input type="text" placeholder="Enter product name" name="productName" required>
                                </div>
                                <div class="input-field">
                                    <label>Price</label>
                                    <input type="text" placeholder="Enter price" name = "unitPrice" required>
                                </div>
                                <div class="input-field">
                                  <label>Stocks</label>
                                  <input type="text" placeholder="Enter stocks" name="unitsInStock" required>
                                </div>
                                <div class="input-field">
                                    <label>Description</label>
                                    <input type="text" placeholder="Enter description" name="description" required>
                                </div>
                                
                            </div>
                        </div>
                        <div class="productID">
                            <button class="submit" name="submit">
                            <input class="btnText" type="submit" name="submit"  value="Add">
                              <i class="uil uil-navigator"></i>
                          </button>
                        </div> 
                    </div>
                    
                             
                            </div>
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

            toggle.addEventListener("click", () =>{
              sidebar.classList.toggle("close");
 });
          </script>
    </body>
</html>