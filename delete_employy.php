<?php
include 'db_connect.php';

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Retrieve the image path from the database
    $sql = "SELECT image FROM employys WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        // Delete the employee record
        $sql = "DELETE FROM employys WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Delete the image file from the server if it exists
            if (file_exists($imagePath) && !empty($imagePath)) {
                unlink($imagePath);
            }
            // Redirect to the employee list page
            echo "<script>window.location.href='list_employy_card.php';</script>";
            exit;
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
    } else {
        echo "Employee not found.";
    }

    $stmt->close();
} else {
    echo "No employee ID provided.";
}

$conn->close();
?>
