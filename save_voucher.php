<?php
include 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from POST request
    $voucherData = json_decode($_POST['voucher_data'], true);
    $date = date('Y-m-d'); // Current date
    $success = true; // Flag to track the success of operations

    foreach ($voucherData as $item) {
        $product = $conn->real_escape_string($item['product']); // Sanitize product name
        $quantity = (int)$item['quantity']; // Convert quantity to integer

        // Fetch the current price from the database
        $result = $conn->query("SELECT current_price FROM products WHERE product = '$product'");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $price = (float)$row['current_price']; // Get the price as float
            $total = $quantity * $price; // Calculate total price

            // Insert into 'sell' table
            $sql_sell = "INSERT INTO sell (product, quantity, price, total, date) 
                         VALUES ('$product', '$quantity', '$price', '$total', '$date')";

            if ($conn->query($sql_sell) !== TRUE) {
                $success = false; // Set success flag to false
                echo "Error inserting into sell table: " . $conn->error . "<br>";
                break; // Stop processing on error
            }

            // Insert into 'orders' table
            $sql_order = "INSERT INTO orders (product, quantity, price, total, date) 
                          VALUES ('$product', '$quantity', '$price', '$total', '$date')";

            if ($conn->query($sql_order) !== TRUE) {
                $success = false; // Set success flag to false
                echo "Error inserting into orders table: " . $conn->error . "<br>";
                break; // Stop processing on error
            }
        } else {
            $success = false; // Set success flag to false
            echo "Error: Product not found in the database.<br>";
            break; // Stop processing on error
        }
    }

    if ($success) {
        echo "<script>window.location.href='add_sell.php'</script>"; // Redirect on success
    }

    $conn->close(); // Close the database connection
}
?>
