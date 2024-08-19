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
    <title>view menu</title>
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
                <form class="d-none d-md-flex ms-4">
                    <input class="text-white form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <?php
                    include 'db_connect.php';

                    // Check if 'id' is set in the URL
                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                        $id = intval($_GET['id']); // Convert to integer for security
                        $sql = "SELECT product, current_price, image, barcode, item, current, item_count, date FROM products WHERE id=?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();

                            // Fetch the total quantity sold for this product from the 'sell' table
                            $sql_sell = "SELECT SUM(quantity) as total_sold FROM sell WHERE product=?";
                            $stmt_sell = $conn->prepare($sql_sell);
                            $stmt_sell->bind_param("s", $row['product']);
                            $stmt_sell->execute();
                            $result_sell = $stmt_sell->get_result();
                            $row_sell = $result_sell->fetch_assoc();
                            
                            $total_sold = $row_sell['total_sold'] ?? 0; // If no sales, total_sold will be 0
                            $remain = $row['item_count'] - $total_sold;
                        } else {
                            echo "Product not found.";
                            exit();
                        }
                    } else {
                        echo "No product ID provided.";
                        exit();
                    }

                    $conn->close();
                    ?>
                <h1 class="my-4 text-white">Product Details</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid" style="width: 400px; heignt: 400px;" alt="<?php echo htmlspecialchars($row['product']); ?>">
                        </div>
                        <div class="col-md-6">
                            
                            <h2 class="text-white"><?php echo htmlspecialchars($row['product']); ?></h2>
                            <p class="text-white"><strong>Barcode: </strong> <?php echo htmlspecialchars($row['barcode']); ?></p>
                            <p class="text-white"><strong>Price: </strong> $<?php echo htmlspecialchars($row['current_price']); ?></p>
                            <p class="text-white"><strong>Item: </strong> <?php echo htmlspecialchars($row['item']); ?></p>
                            <p class="text-white"><strong>Current: </strong> <?php echo htmlspecialchars($row['current']); ?></p>
                            <p class="text-white"><strong>Item Count: </strong> <?php echo htmlspecialchars($row['item_count']); ?></p>
                            <p class="text-white"><strong>Remain: </strong> <?php echo htmlspecialchars($remain); ?></p>
                            <p class="text-white"><strong>Date: </strong> <?php echo htmlspecialchars($row['date']); ?></p>
                        </div>
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