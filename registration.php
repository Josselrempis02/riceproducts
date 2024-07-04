<?php
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

// Function to hash the password (using PHP's built-in password_hash function)
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $pdo = connectDatabase($host, $dbname, $username, $password);

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'user' or 'admin'

    // Hash the password before storing
    $hashedPassword = hashPassword($password);

    try {
        // Insert data into appropriate table based on role
        if ($role == 'user') {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
        } elseif ($role == 'admin') {
            $stmt = $pdo->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
        }

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
    <title>User Registration</title>
</head>
<body>
    <h2>Register as User or Admin</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Register as:</label>
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>