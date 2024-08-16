<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>list menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php
        include 'db_connect.php'; 



        
        ?>

        <!-- Sidebar -->

        <!-- Main Component -->


        <div class="row justify-content-center align-item-center">
    <div class="card bg-secondary" style="width: 20rem;">
        <h3 style="padding-top: 30px;" class="text-white text-center card-footer">Order Voucher</h3>
        <p class="text-white" id="date">Today's Date:
            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    var today = new Date();
                    var day = ("0" + today.getDate()).slice(-2);
                    var month = ("0" + (today.getMonth() + 1)).slice(-2);
                    var todayStr = today.getFullYear() + "-" + month + "-" + day;
                    document.getElementById("date").innerText = todayStr;
                });
            </script>
        </p>
        <div class="card-body voucher">
            <strong class="text-white">Product</strong>
            <strong class="text-white">Quantity</strong>
            <strong class="text-white">Price</strong>
            <?php
            if (isset($_POST['voucher_data'])) {
                $voucherData = json_decode($_POST['voucher_data'], true);

                foreach ($voucherData as $item) {
                    echo '<div class="text-white">';
                    echo '<p>Product: ' . htmlspecialchars($item['product']) . '</p>';
                    echo '<p>Quantity: ' . htmlspecialchars($item['quantity']) . '</p>';
                    echo '<p>Price: ' . htmlspecialchars($item['price']) . ' KS</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="card-footer text-center">
            <a href="#" class="btn btn-light" onclick="saveVoucher();">Save</a>
            <a href="#" class="btn btn-light" onclick="window.print();">Print</a>
        </div>
        <div>
            <p class="text-white">Total:
                <?php
                if (isset($voucherData)) {
                    $totalPrice = 0;
                    foreach ($voucherData as $item) {
                        $totalPrice += $item['price'] * $item['quantity'];
                    }
                    echo number_format($totalPrice, 2) . ' KS';
                }
                ?>
            </p>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>