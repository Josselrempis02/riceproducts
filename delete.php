<?php
include_once("connections/connection.php");

// Always start session
session_start();

// Connect to database
$con = connection();

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Delete query with prepared statement
    $deleteSql = $con->prepare("DELETE FROM product_list WHERE productID = ?");
    $deleteSql->bind_param('i', $id);

    if ($deleteSql->execute()) {
        // Successful deletion
        $_SESSION['success_message'] = "Record has been successfully deleted.";
        echo '<script>
                alert("Record has been successfully deleted."); 
                window.location.href = "admin_dashboard.php";
              </script>';
    } else {
        // Error handling
        $_SESSION['error_message'] = "Error deleting record: " . $con->error;
        echo '<script>
                alert("Error deleting record: ' . $con->error . '"); 
                window.location.href = "admin_dashboard.php";
              </script>';
    }

    $deleteSql->close();
    exit; // Exit to prevent further execution
}
?>
