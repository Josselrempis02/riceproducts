<?php
session_start();

// Database connection settings
$host = 'localhost';
$dbname = 'register';
$username = 'root';
$password = '';

// Function to establish PDO connection
function connectDatabase($host, $dbname, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Could not connect to the database $dbname: " . $e->getMessage());
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $pdo = connectDatabase($host, $dbname, $username, $password);

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if the user is in the users table
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user is in the admins table if not found in users
        if (!$user) {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                // Verify the password for admin
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
        } else {
            // Verify the password for user
            if (password_verify($password, $user['password'])) {
                // Set session variables for user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'user';

                // Redirect to user dashboard
                header("Location: user_dashboard.php");
                exit();
            }
        }

        // Invalid credentials
        echo "Invalid email or password.";
    } catch (PDOException $e) {
        // Handle database errors
        die("Error: " . $e->getMessage());
    } finally {
        // Close the connection
        $pdo = null;
    }
}
?>
