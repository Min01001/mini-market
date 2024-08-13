<?php
include 'db_connect.php';

// Get the selected date from the GET parameters
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

$totalQuantity = 0;
$totalPrices = 0;


if ($selectedMonth) {
    // Query to fetch data for the selected date
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m') AS month
            FROM sell 
            WHERE DATE_FORMAT(date, '%Y-%m') = '" . $conn->real_escape_string($selectedMonth) . "'
            GROUP BY product, month
            ORDER BY product";
} else {
    // Query to fetch all data if no date is selected
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m') AS month
            FROM sell 
            GROUP BY product, month
            ORDER BY id DESC, product";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="table table-dark table-hover">';
        echo '<td class="text-white">' . htmlspecialchars($row['product']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_quantity']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_price']) . '</td>';
        echo '<td class="text-danger">' . htmlspecialchars($row['month']) . '</td>';
        //echo '<td><img src="' . htmlspecialchars($row['image']) . '" alt="Product Image" style="width: 50px;"></td>';
        echo '</tr>';

        $totalQuantity += $row['total_quantity'];
        $totalPrices += $row['total_price'];
    }
} else {
    echo '<tr><td colspan="5" class="text-white">No date found.</td></tr>';
}

echo "<script>
        $('#totalQuantity').text('$totalQuantity');
        $('#totalPrice').text('" . number_format($totalPrices) . " KS');
      </script>";

$conn->close();
?>
