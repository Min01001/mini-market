<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucherData = json_decode($_POST['voucher_data'], true);
    $date = date('Y-m-d');

    foreach ($voucherData as $item) {
        $image = $conn->real_escape_string($item['image']);
        $product = $conn->real_escape_string($item['product']);
        $quantity = (int)$item['quantity'];
        $price = (int)$item['price'];
        $total = $quantity * $price;

        $sql = "INSERT INTO sell (image, product, quantity, price, total, date) VALUES ('$image', '$product', '$quantity', '$price', '$total' ,'$date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.location.href='add_sell.php'</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
