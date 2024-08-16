<?php
include 'db_connect.php';

// Decode the JSON data received from the frontend
if (isset($_POST['voucher_data'])) {
    $voucherData = json_decode($_POST['voucher_data'], true);

    // Prepare the SQL statement
    $sql = "INSERT INTO sell (product, quantity, price, image, date) VALUES (?, ?, ?, ?)";
    $sql = "INSERT INTO sell (product, quantity, price, image, date) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        foreach ($voucherData as $item) {
            // Bind parameters and execute the statement for each item
            $stmt->bind_param("sids", $item['product'], $item['quantity'], $item['price'], $item['image']);
            $stmt->execute();
        }
        $stmt->close();
        echo "Voucher data saved successfully.";
        echo "<script>window.location.href='add_sell.php'</script>";
    } else {
        echo "Failed to prepare the SQL statement.";
    }
} else {
    echo "No voucher data received.";
}

$conn->close();
?>
