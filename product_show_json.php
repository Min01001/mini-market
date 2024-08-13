<?php 
include 'db_connect.php';

$searchQuery = isset($_GET['search_query']) ? $conn->real_escape_string($_GET['search_query']) : '';

// SQL query to fetch products
$sql = "SELECT id, product, current_price, image FROM products";
if ($searchQuery !== '') {
    $sql .= " WHERE product LIKE '%$searchQuery%'";
}

$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'product' => $row['product'],
            'current_price' => $row['current_price'],
            'image' => $row['image']
        ];
    }
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
