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
                <form class="d-md-flex ms-4">
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search" name="search_query" id="search_query">
                </form>
            </nav>
            <main class="content px-3 py-2">
        <div class="container-fluid">
            <div style="overflow-x: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-white">Barcode</th>
                            <th class="text-white">Product Name</th>
                            <th class="text-white">Item</th>
                            <th class="text-white">Current</th>
                            <th class="text-white">Current Price</th>
                            <th class="text-white">Item Count</th>
                            <th class="text-white">Date</th>
                            <th class="text-white">Image</th>
                            <th class="text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product_table_body">
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('#search_query');
    searchInput.addEventListener('keyup', function() {
        fetchProducts();
    });

    // Initial load
    fetchProducts();
});

function fetchProducts() {
    const searchQuery = document.querySelector('#search_query').value;
    fetch('view_table_show_json.php?search_query=' + encodeURIComponent(searchQuery))
        .then(response => response.json())
        .then(data => displayProducts(data))
        .catch(error => console.error('Error:', error));
}

function displayProducts(products) {
    const tableBody = document.querySelector('#product_table_body');
    tableBody.innerHTML = ''; // Clear the table body

    if (products.length > 0) {
        products.forEach(product => {
            const rowHtml = `
                <tr class="table table-dark table-hover">
                    <td class="text-white">${product.barcode}</td>
                    <td class="text-white">${product.product}</td>
                    <td class="text-white">${product.item}</td>
                    <td class="text-white">${product.current}</td>
                    <td class="text-white">${product.current_price}</td>
                    <td class="text-white">${product.item_count}</td>
                    <td class="text-white">${product.date}</td>
                    <td><img src="${product.image}" alt="Product Image" style="width: 50px;"></td>
                    <td class="text-white text-center">
                        <a href="edit_product.php?id=${product.id}" class="btn btn-outline-warning">Edit</a>
                    </td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete?')" action="delete_product.php">
                            <input type="hidden" name="id" value="${product.id}">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', rowHtml);
        });
    } else {
        tableBody.innerHTML = '<tr><td colspan="10" class="text-white">No products found.</td></tr>';
    }
}
</script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>