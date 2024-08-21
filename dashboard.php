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

    <title>dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php include 'sidebar.php'; ?>

        

        <!-- Sidebar -->

        <!-- Main Component -->
         <?php         
         include 'db_connect.php';

         $sqlProduct = "SELECT COUNT(product) AS total_product FROM products";
         $resultProduct = $conn->query($sqlProduct);
         $productTotal = $resultProduct->fetch_assoc();
         
         // Fetch orders count
         $sqlOrder = "SELECT COUNT(product) AS product_sell FROM sell";
         $resultOrder = $conn->query($sqlOrder);
         $orderTotal = $resultOrder->fetch_assoc();
         
         // Fetch sales data for pie and bar charts
         $sqlSales = "SELECT product, COUNT(product) AS product_sell FROM sell GROUP BY product ORDER BY product_sell DESC";
         $resultSales = $conn->query($sqlSales);
         
         $salesData = [];
         while($row = $resultSales->fetch_assoc()) {
             $salesData[] = $row;
         }
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
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card bg-transparent text-white p-2 h-100 d-flex flex-column">
                            <div class="card-body bg-secondary row">
                                <div class="col-md-8">
                                <p style="padding-left: 20px; padding-top: 10px" class="h5">Total Menus</p>
                                <p style="padding-left: 20px;" class="h5"><?php echo $productTotal['total_product']?></p>
                                <p style="padding-left: 20px;" class="h5"><div class="progress" style="margin-left: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $productTotal['total_product']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min($productTotal['total_product'], 100); ?>%"></div>
                                    </div>
                                </p>
                                </div>
                                <div class="col-md-4 pt-4">
                                <i class="fa-solid fa-pen-to-square px-2 py-2 icon-size"></i>
                                </div>                            
                            </div>                           
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card bg-transparent text-white p-2 h-100 d-flex flex-column">
                            <div class="card-body bg-secondary row">
                                <div class="col-md-8">
                                <p style="padding-left: 20px; padding-top: 10px" class="h5">Total Orders</p>
                                <p style="padding-left: 20px;" class="h5"><?php echo $orderTotal['product_sell']?></p>
                                <p style="padding-left: 20px;" class="h5"><div class="progress" style="margin-left: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $orderTotal['product_sell']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min($orderTotal['product_sell'], 100); ?>%"></div>
                                    </div>
                                </p>
                                </div>
                                <div class="col-md-4 pt-4">
                                <i class="fa-solid fa-briefcase px-2 py-2 icon-size"></i>
                                </div>                            
                            </div>                           
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="barChart"></canvas>
                    </div>
                    <script>
    // Prepare data for the charts
    const labels = <?php echo json_encode(array_column($salesData, 'product')); ?>;
    const data = <?php echo json_encode(array_column($salesData, 'product_sell')); ?>;


    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: data,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            }]
        },
        options: {
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,  // Animation duration in milliseconds
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: data,
                backgroundColor: '#36A2EB',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 2000,  // Animation duration in milliseconds
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