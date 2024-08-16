<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $product = $conn->real_escape_string($_POST['product']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $total = $quantity * $price;
    $date = date('Y-m-d');

    // Insert data into the database
    $sql = "INSERT INTO orders (product, quantity, price, total, date) VALUES ('$product', '$quantity', '$price', '$total', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Voucher submitted successfully!'); window.location.href='order_page.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
