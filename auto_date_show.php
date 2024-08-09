<?php
include 'db_connect.php';

// Get the selected date from the GET parameters
$selectedDate = isset($_GET['date']) ? $_GET['date'] : '';

if ($selectedDate) {
    // Query to fetch data for the selected date
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m-%d') AS day
            FROM sell 
            WHERE DATE(date) = '" . $conn->real_escape_string($selectedDate) . "'
            GROUP BY product, day
            ORDER BY product";
} else {
    // Query to fetch all data if no date is selected
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m-%d') AS day
            FROM sell 
            GROUP BY product, day
            ORDER BY id DESC, product";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="table table-dark table-hover">';
        echo '<td class="text-white">' . htmlspecialchars($row['product']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_quantity']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_price']) . '</td>';
        echo '<td class="text-danger">' . htmlspecialchars($row['day']) . '</td>';
        //echo '<td><img src="' . htmlspecialchars($row['image']) . '" alt="Product Image" style="width: 50px;"></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" class="text-white">No date found.</td></tr>';
}

$conn->close();
?>
