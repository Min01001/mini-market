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
    <title>view table</title>
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

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div style="overflow-x: auto;">';
    echo '<table class="table table-striped">';
    echo '<tr>';
    echo '<th class="text-white">Barcode</th>';
    echo '<th class="text-white">Product Name</th>';
    echo '<th class="text-white">Item</th>';
    echo '<th class="text-white">Current</th>';
    echo '<th class="text-white">Current Price</th>';
    echo '<th class="text-white">Item Count</th>';
    echo '<th class="text-white">Date</th>';
    echo '<th class="text-white">Image</th>';
    echo '<th class="text-white">Actions</th>';
    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr class="table table-dark table-hover">';
        echo '<td class="text-white">' . $row['barcode'] . '</td>';
        echo '<td class="text-white">' . $row['product'] . '</td>';
        echo '<td class="text-white">' . $row['item'] . '</td>';
        echo '<td class="text-white">' . $row['current'] . '</td>';
        echo '<td class="text-white">' . $row['current_price'] . '</td>';
        echo '<td class="text-white">' . $row['item_count'] . '</td>';
        echo '<td class="text-white">' . $row['date'] . '</td>';
        echo '<td><img src="' . $row['image'] . '" alt="Product Image" style="width: 50px;"></td>';
        echo '<td class="text-white text-center"><a href="edit_product.php?id=' . $row['id'] . '" class="btn btn-outline-warning">Edit</a></td>';
        echo "<td>";
        echo "<form method='POST' onsubmit=\"return confirm('Are you sure you want to delete?')\" action='delete_product.php'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>";
        echo "<button type='submit' class='btn btn-danger btn-sm'>Delete</button>";
        echo "</form>";
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