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
    <title>new product</title>
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
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
                <h3>New Product</h3><br>
                <form class="row g-3" method="POST" action="update_product.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="col-md-6">
        <label for="barcode" class="form-label text-white">Barcode</label>
        <input type="text" class="form-control bg-white text-dark" id="barcode" name="barcode" value="<?php echo $row['barcode']; ?>">
    </div>
    <div class="col-md-6">
        <label for="product" class="form-label text-white">Product Name</label>
        <input type="text" class="form-control bg-white text-dark" id="product" name="product" value="<?php echo $row['product']; ?>">
    </div>
    <div class="col-12">
        <label for="item" class="text-white">Item</label>
        <select name="item" id="item" class="selectpicker form-control bg-white text-dark" data-style="py-0">
            <option value="Food" <?php if ($row['item'] == 'Food') echo 'selected'; ?>>Food</option>
            <option value="Drink" <?php if ($row['item'] == 'Drink') echo 'selected'; ?>>Drink</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="current" class="form-label text-white">Current</label>
        <input type="text" class="form-control bg-white text-dark" id="current" name="current" value="<?php echo $row['current']; ?>">
    </div>
    <div class="col-md-6">
        <label for="current_price" class="form-label text-white">Current Price</label>
        <input type="text" class="form-control bg-white text-dark" id="current_price" name="current_price" value="<?php echo $row['current_price']; ?>">
    </div>
    <div class="col-md-6">
        <label for="item_count" class="form-label text-white">Item Count</label>
        <input type="text" class="form-control bg-white text-dark" id="item_count" name="item_count" value="<?php echo $row['item_count']; ?>">
    </div>
    <div class="col-md-6">
        <label for="date" class="form-label text-white">Date</label>
        <input type="date" class="form-control bg-white text-dark" id="date" name="date" value="<?php echo $row['date']; ?>">
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label text-white">Image</label>
        <input type="file" class="form-control text-dark" id="image" name="image">
        <img src="<?php echo $row['image']; ?>" alt="Current Image" class="img-thumbnail mt-2" style="width: 100px;">
    </div>
    <div class="col-12" style="padding-top: 40px;">
        <button type="submit" class="btn btn-outline-primary" name="submit" style="width: 200px; height: 40px;">Update</button>
    </div>
</form>

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