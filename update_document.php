<?php
include 'db_connect.php';

if (isset($_POST['id']) && isset($_POST['column']) && isset($_POST['value'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $column = $conn->real_escape_string($_POST['column']);
    $value = $conn->real_escape_string($_POST['value']);

    $sql = "UPDATE documents SET $column = '$value' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }

    $conn->close();
} else {
    echo 'Invalid parameters.';
}
?>
