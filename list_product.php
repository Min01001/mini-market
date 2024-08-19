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

        <?php include 'sidebar.php';
        include 'db_connect.php'; 



        
        ?>

        <!-- Sidebar -->

        <!-- Main Component -->


        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" data-bs-theme="dark">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php $searchQuery = isset($_GET['search_query']) ? $conn->real_escape_string($_GET['search_query']) : ''; ?>

                <form class="d-md-flex ms-4">
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search" name="search_query" value="<?php echo htmlspecialchars($searchQuery); ?>">
                </form>

                <div style="padding-left: 15px;">
                <a href="view_table.php"><button class="btn btn-danger">View Table</button></a>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <h4 class="text-white">All Menus</h4>
                <div class="row">

                <?php
    
                    $sql = "SELECT id, product, current_price, image FROM products";
                    if ($searchQuery !== ''){
                        $sql .=" WHERE product LIKE '%$searchQuery%'";
                    }
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<div class="container-fluid">';
                        echo '<div class="row justify-content-center align-items-center">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2">';
                            echo '  <div class="card cards">';
                            echo '    <img src="' . $row["image"] . '" class="card-img-top image-size" alt="' . htmlspecialchars($row["product"]) . '">';
                            echo '    <div class="card-body">';
                            echo '      <p class="card-title text-center text-dark">' . htmlspecialchars($row["product"]) . '</p>';
                            echo '      <p class="card-text text-center text-dark">$' . htmlspecialchars($row["current_price"]) . '</p>';
                            echo '      <a href="view.php?id=' . $row["id"] . '" class="btn btn-outline-info d-flex justify-content-center">View</a>';
                            echo '    </div>';
                            echo '  </div>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo "No products found.";
                    }

                    $conn->close();
                    ?>

                <?php include 'product_js.php'; ?>

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