<?php
include 'db_connect.php';

// Get the selected item from the query string
$selectedItem = isset($_GET['item']) ? $conn->real_escape_string($_GET['item']) : '';

$sql = "SELECT product, current_price, image FROM products";
if ($selectedItem) {
    $sql .= " WHERE item = '$selectedItem'";
}

$result = $conn->query($sql);

// Generate the HTML to display the products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card m-2" style="width: 18rem;">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['product']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['product']) . '</h5>';
        echo '<p class="card-text">$' . htmlspecialchars($row['current_price']) . '</p>';
        echo '<button class="btn btn-primary add-card" data-image="' . htmlspecialchars($row['image']) . '" data-product="' . htmlspecialchars($row['product']) . '" data-price="' . htmlspecialchars($row['current_price']) . '">Add Order</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No products available.</p>';
}

$conn->close();
?>
