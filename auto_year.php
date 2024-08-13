<?php
include 'db_connect.php';

// Get the selected year from the GET parameters
$selectedYear = isset($_GET['year']) ? $_GET['year'] : '';

$totalQuantity = 0;
$totalPrices = 0;


if ($selectedYear) {
    // Query to fetch data for the selected year
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, DATE_FORMAT(date, '%Y') AS year
            FROM sell 
            WHERE DATE_FORMAT(date, '%Y') = '" . $conn->real_escape_string($selectedYear) . "'
            GROUP BY product, year
            ORDER BY product";
} else {
    // Query to fetch all data if no year is selected
    $sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, DATE_FORMAT(date, '%Y') AS year
            FROM sell 
            GROUP BY product, year
            ORDER BY id DESC, product";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="table table-dark table-hover">';
        echo '<td class="text-white">' . htmlspecialchars($row['product']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_quantity']) . '</td>';
        echo '<td class="text-white">' . htmlspecialchars($row['total_price']) . '</td>';
        echo '<td class="text-danger">' . htmlspecialchars($row['year']) . '</td>';
        echo '</tr>';

        $totalQuantity += $row['total_quantity'];
        $totalPrices += $row['total_price'];
    }
} else {
    echo '<tr><td colspan="4" class="text-white">No data found for the selected year.</td></tr>';
}

echo "<script>
        $('#totalQuantity').text('$totalQuantity');
        $('#totalPrice').text('" . number_format($totalPrices) . " KS');
      </script>";


$conn->close();
?>
