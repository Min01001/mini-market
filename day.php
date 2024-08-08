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
    <link rel="stylesheet" href="voncher.css">
    <title>view product only</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php include 'sidebar.php'; ?>

        <!-- Sidebar -->

        <!-- Main Component -->


        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                    <button class="btn" type="button" data-bs-theme="dark">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="day-view">
                <div><a href="day.php"><button class="btn btn-outline-info">View Table</button></a></div>
                    <div><a href="dayview_chat.php"><button class="btn btn-outline-info">View Chat</button></a></div>
                    <div><a href="day_product_view.php"><button class="btn btn-outline-info">Product</button></a></div>
                    <div><a href="day_date.php"><button class="btn btn-outline-info">Date</button></a></div>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <?php
include 'db_connect.php';

$sql = "SELECT product, SUM(quantity) AS total_quantity, price ,SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m-%d') AS day, id FROM sell GROUP BY day, product ORDER BY id DESC, product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div style="overflow-x: auto;">';
    echo '<table class="table table-striped">';
    echo '<tr>';
    echo '<th class="text-white">Product</th>';
    echo '<th class="text-white">Quantity</th>';
    echo '<th class="text-white">Price</th>';
    echo '<th class="text-white">Date</th>';
    echo '<th class="text-white">Image</th>';


    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="table table-dark table-hover">';
        echo '<td class="text-white">' . $row['product'] . '</td>';
        echo '<td class="text-white">' . $row['total_quantity'] . '</td>';
        echo '<td class="text-white">' . $row['total_price'] . '</td>';
        echo '<td class="text-white">' . $row['day'] . '</td>';
        echo '<td><img src="' . $row['image'] . '" alt="Product Image" style="width: 50px;"></td>';
        echo "</td>";
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
} else {
    echo 'No products found.';
}

$conn->close();
?>




                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>