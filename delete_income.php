<?php


include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate CSRF token here if implemented
    
    $id = $_POST['id'];

    $sql = "DELETE FROM incomes WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Close prepared statement
        $stmt->close();
        // Close database connection
        $conn->close();
        // Redirect to employy.php after successful deletion
        header("Location: income.php");
        exit(); // Terminate script execution after redirection
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

?>