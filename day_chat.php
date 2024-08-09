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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <title>day view chat</title>
    <link rel="stylesheet" href="voncher.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php include 'sidebar.php'; ?>

        <!-- Sidebar -->

        <?php
include 'db_connect.php';

// Fetch top 3 products
$sql = "SELECT product, SUM(quantity) AS total_quantity, price, SUM(total) AS total_price, image, DATE_FORMAT(date, '%Y-%m-%d') AS day, id 
        FROM sell 
        GROUP BY product 
        ORDER BY total_quantity DESC 
        LIMIT 10";
$result = $conn->query($sql);

$data = [
    'products' => [],
    'quantities' => [],
    'prices' => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['products'][] = $row['product'];
        $data['quantities'][] = (int)$row['total_quantity'];
        $data['prices'][] = (float)$row['total_price'];
    }
}

$conn->close();
?>

        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" data-bs-theme="dark">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- <form class="d-none d-md-flex ms-4">
                    <input class="text-white form-control bg-light border-0" type="search" placeholder="Search">
                </form> -->
                <div class="day-view">
                <div><a href="day.php"><button class="btn btn-outline-info">View Table</button></a></div>
                    <div><a href="dayview_chat.php"><button class="btn btn-outline-info">View Chat</button></a></div>
                    <div><a href="day_product_view.php"><button class="btn btn-outline-info">Product</button></a></div>
                    <div><a href="day_date.php"><button class="btn btn-outline-info">Date</button></a></div>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <h2 class="text-white">Pie Chart - Product Distribution</h2> -->
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <!-- <h2 class="text-white">Bar Chart - Quantity vs. Price</h2> -->
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <script>
        // Data from PHP
        const products = <?php echo json_encode($data['products']); ?>;
        const quantities = <?php echo json_encode($data['quantities']); ?>;
        const prices = <?php echo json_encode($data['prices']); ?>;

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: products,
                datasets: [{
                    label: 'Sell Quantity',
                    data: quantities,
                    backgroundColor: [
                        '#FF0000',
                        '#FFFF00',
                        '#008000',
                        '#7F00FF',
                        '#0000FF',
                        '#FFFFFF',
                        '#800080',
                        '#800000',
                        '#808000',
                        '#808080',
                    ],
                    borderColor: [
                        '#FF0000',
                        '#FFFF00',
                        '#008000',
                        '#7F00FF',
                        '#0000FF',
                        '#FFFFFF',
                        '#800080',
                        '#800000',
                        '#808000',
                        '#808080',
                    ],
                    borderWidth: 1
                }]
            }
        });

        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: products,
                datasets: [{
                    label: 'Quantity',
                    data: quantities,
                    backgroundColor: '#008000',
                    borderColor: '#006400',
                    borderWidth: 1
                }, {
                    label: 'Price',
                    data: prices,
                    backgroundColor: '#FF0000',
                    borderColor: '#B22222',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
                </div>
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