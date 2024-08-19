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
    <title>stock investor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
<?php
include 'db_connect.php';

// Check if a search query is being sent via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_query'])) {
    $search_query = $_POST['search_query'];
    
    $sql = "SELECT * FROM products WHERE product LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_query_param = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_query_param);
    $stmt->execute();
    $result = $stmt->get_result();

    $response = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productName = $row['product'];
            $sql_sell = "SELECT SUM(quantity) as total_sold FROM sell WHERE product=?";
            $stmt_sell = $conn->prepare($sql_sell);
            $stmt_sell->bind_param("s", $productName);
            $stmt_sell->execute();
            $result_sell = $stmt_sell->get_result();
            $row_sell = $result_sell->fetch_assoc();

            $total_sold = $row_sell['total_sold'] ?? 0;
            $remain = $row['item_count'] - $total_sold;

            $response .= '<div class="card" style="width: 18rem; height: auto; margin: 10px;">';
            $response .= '<img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top image-size" alt="' . htmlspecialchars($row["product"]) . '">';
            $response .= '<div class="card-body">';
            $response .= '<p class="card-text text-dark"><strong>Product:</strong> ' . htmlspecialchars($row["product"]) . '</p>';
            $response .= '<p class="card-text text-dark"><strong>Price:</strong> ' . htmlspecialchars($row["current"] . ' KS') . '</p>';
            $response .= '<p class="card-text text-dark"><strong>Item Count:</strong> ' . htmlspecialchars($row["item_count"]) . '</p>';
            $response .= '<p class="card-text text-dark"><strong>Current Price:</strong> ' . htmlspecialchars($row["current_price"]) . '</p>';
            $response .= '<p class="card-text text-dark"><strong>Remain:</strong> ' . htmlspecialchars($remain) . '</p>';
            $response .= '</div>';
            $response .= '</div>';
        }
    } else {
        $response = "No products found.";
    }

    $conn->close();
    echo $response;
    exit;
}

// Initial products display
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$initial_products = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productName = $row['product'];
        $sql_sell = "SELECT SUM(quantity) as total_sold FROM sell WHERE product=?";
        $stmt_sell = $conn->prepare($sql_sell);
        $stmt_sell->bind_param("s", $productName);
        $stmt_sell->execute();
        $result_sell = $stmt_sell->get_result();
        $row_sell = $result_sell->fetch_assoc();

        $total_sold = $row_sell['total_sold'] ?? 0;
        $remain = $row['item_count'] - $total_sold;

        $initial_products .= '<div class="card" style="width: 18rem; height: auto; margin: 10px;">';
        $initial_products .= '<img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top image-size" alt="' . htmlspecialchars($row["product"]) . '">';
        $initial_products .= '<div class="card-body">';
        $initial_products .= '<p class="card-text text-dark"><strong>Product:</strong> ' . htmlspecialchars($row["product"]) . '</p>';
        $initial_products .= '<p class="card-text text-dark"><strong>Price:</strong> ' . htmlspecialchars($row["current"] . ' KS') . '</p>';
        $initial_products .= '<p class="card-text text-dark"><strong>Item Count:</strong> ' . htmlspecialchars($row["item_count"]) . '</p>';
        $initial_products .= '<p class="card-text text-dark"><strong>Current Price:</strong> ' . htmlspecialchars($row["current_price"]) . '</p>';
        $initial_products .= '<p class="card-text text-dark"><strong>Remain:</strong> ' . htmlspecialchars($remain) . '</p>';
        $initial_products .= '</div>';
        $initial_products .= '</div>';
    }
} else {
    $initial_products = "No products found.";
}

$conn->close();
?>


        <!-- Main Component -->


        <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar -->

        <!-- Main Component -->
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" type="button" data-bs-theme="dark">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="d-none d-md-flex ms-4">
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search" name="search_query" id="search_query">
                </form>
                <div style="padding-left: 15px;">
                    <a href="view_table.php"><button class="btn btn-danger">View Table</button></a>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <h4 class="text-white">Stock Investor</h4>
                    <div class="row" id="results">
                        <?php echo $initial_products; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Include JavaScript libraries -->
    <script src="path/to/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search_query');
            const resultsContainer = document.getElementById('results');

            searchInput.addEventListener('input', function () {
                const searchQuery = searchInput.value;

                // Perform AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);  // Send request to the same page
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        resultsContainer.innerHTML = xhr.responseText;
                    } else {
                        resultsContainer.innerHTML = 'Error retrieving data.';
                    }
                };

                xhr.send('search_query=' + encodeURIComponent(searchQuery));
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>