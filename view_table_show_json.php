<?php
include 'db_connect.php';

$searchQuery = isset($_GET['search_query']) ? $conn->real_escape_string($_GET['search_query']) : '';

$sql = "SELECT * FROM products";
if ($searchQuery !== '') {
    $sql .= " WHERE product LIKE '%$searchQuery%'";
}

$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>
