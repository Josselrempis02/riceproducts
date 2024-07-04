<?php
session_start();

include_once("connections/connection.php");
$con = connection(); // Assuming this initializes $con for mysqli

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statements
    $stmt_user = mysqli_prepare($con, "SELECT * FROM users WHERE email = ?");
    $stmt_admin = mysqli_prepare($con, "SELECT * FROM admins WHERE email = ?");

    if ($stmt_user && $stmt_admin) {
        // Bind parameters and execute for users table
        mysqli_stmt_bind_param($stmt_user, "s", $email);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);
        $user = mysqli_fetch_assoc($result_user);

        // Bind parameters and execute for admins table
        mysqli_stmt_bind_param($stmt_admin, "s", $email);
        mysqli_stmt_execute($stmt_admin);
        $result_admin = mysqli_stmt_get_result($stmt_admin);
        $admin = mysqli_fetch_assoc($result_admin);

        // Check if user or admin exists and verify password
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session variables for user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'user';

                // Redirect to user dashboard
                header("Location: user_dashboard.php");
                exit();
            }
        } elseif ($admin) {
            if (password_verify($password, $admin['password'])) {
                // Set session variables for admin
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['role'] = 'admin';

                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            }
        }

        // Invalid credentials
        echo "Invalid email or password.";
    } else {
        // Handle prepare errors
        die("Prepare statement failed: " . mysqli_error($con));
    }

    // Close statements
    mysqli_stmt_close($stmt_user);
    mysqli_stmt_close($stmt_admin);
    
    // Close connection
    mysqli_close($con);
}
?>
