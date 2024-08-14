<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucherData = json_decode($_POST['voucher_data'], true);
    $date = date('Y-m-d');
    $success = true;

    foreach ($voucherData as $item) {
        $product = $conn->real_escape_string($item['product']);
        $quantity = (int)$item['quantity'];

        // Retrieve the original price from the database based on the product name
        $result = $conn->query("SELECT current_price FROM products WHERE product = '$product'");
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $price = (float)$row['current_price'];
            $total = $quantity * $price;

            $sql = "INSERT INTO sell (product, quantity, price, total, date) VALUES ('$product', '$quantity', '$price', '$total', '$date')";

            if ($conn->query($sql) !== TRUE) {
                $success = false;
                echo "Error: " . $sql . "<br>" . $conn->error;
                break;
            }
        } else {
            $success = false;
            echo "Error: Product not found in database.";
            break;
        }
    }

    if ($success) {
        echo "<script>window.location.href='add_sell.php'</script>";
    }

    $conn->close();
}
?>
