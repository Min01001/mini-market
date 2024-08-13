<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucherData = json_decode($_POST['voucher_data'], true);
    $date = date('Y-m-d');
    $success = true;

    foreach ($voucherData as $item) {
        $product = $conn->real_escape_string($item['product']);
        $quantity = (int)$item['quantity'];
        $price = (int)$item['price'];
        $total = $quantity * $price;

        $sql = "INSERT INTO sell (product, quantity, price, total, date) VALUES ('$product', '$quantity', '$price', '$total', '$date')";

        if ($conn->query($sql) !== TRUE) {
            $success = false;
            echo "Error: " . $sql . "<br>" . $conn->error;
            break;
        }
    }

    if ($success) {
        echo "<script>window.location.href='add_sell.php'</script>";
    }

    $conn->close();
}
?>
