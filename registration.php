<?php
include_once("connections/connection.php"); // Ensure this includes and initializes $pdo
$pdo = connection(); // Initialize $pdo

// Function to hash the password (using PHP's built-in password_hash function)
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role']; // 'user' or 'admin'

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Hash the password before storing
    $hashedPassword = hashPassword($password);

    try {
        // Insert data into appropriate table based on role
        if ($role == 'user') {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        } elseif ($role == 'admin') {
            $stmt = $pdo->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
        } else {
            die("Invalid role specified."); // Handle invalid roles
        }

        // Execute the prepared statement
        $stmt->execute([$username, $email, $hashedPassword]);

        // Redirect to a success page or display a success message
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        // Handle database errors
        die("Error: " . $e->getMessage());
    } finally {
        // Close the connection
        $pdo = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Management System - Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-wrapper">
        <div class="form-side">
            <a href="#" title="Logo">
                <img class="logo" src="assets/employee.png" alt="Logo">
            </a>
            <form class="my-form" action="" method="post">
                <div class="login-welcome-row">
                    <h1>Registration &#x1F4E6;</h1>
                </div>
                <div class="text-field">
                    <label for="username">Username:
                        <input type="text" id="username" name="username" placeholder="Your Username" required>
                    </label>
                </div>
                <div class="text-field">
                    <label for="email">Email:
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                    </label>
                </div>
                <div class="text-field">
                    <label for="password">Password:
                        <input id="password" type="password" name="password" placeholder="Your Password" required>
                    </label>
                </div>
                <div class="text-field">
                    <label for="role">Role:
                        <select id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </label>
                </div>
                <button class="my-form__button" type="submit" name="register">Register</button>
                <div class="my-form__actions">
                    <div class="my-form__signup">
                        <span>Already have an account?</span>
                        <a href="login.php" title="Login">Login here</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="info-side">
            <img src="assets/employee.png" alt="Mock" class="mockup" />
            <div class="welcome-message">
                <h2>Employee Management System 👋</h2>
                <p>
                    Effortlessly oversee employee-related records and maintain organization with our Employee
                    Management System.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
