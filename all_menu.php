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
    <title>add sell</title>
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
                <form class="d-md-flex ms-4">
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <?php
                    include 'db_connect.php';

                    // Fetch products for dropdown
                    $dropdownSql = "SELECT DISTINCT item FROM products";
                    $dropdownResult = $conn->query($dropdownSql);

                    // Get selected product from the dropdown
                    $selectedProduct = isset($_GET['item']) ? $_GET['item'] : '';

                    // Fetch product details for the selected product
                    $sql = "SELECT product, current_price, image 
                            FROM products 
                            " . ($selectedProduct ? "WHERE item = '" . $conn->real_escape_string($selectedProduct) . "'" : "");
                    $result = $conn->query($sql);

                    $conn->close();
                    ?>
                <!-- <h6 class="text-white">Sell Order</h6> -->
                    <div class="title">
                        
                    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $selectedProduct ? htmlspecialchars($selectedProduct) : 'Category' ?>
        </button>
        <ul class="dropdown-menu">
            <?php
            if ($dropdownResult->num_rows > 0) {
                while ($dropdownRow = $dropdownResult->fetch_assoc()) {
                    $selected = ($selectedProduct === $dropdownRow['item']) ? 'active' : '';
                    echo '<li><a class="dropdown-item ' . $selected . '" href="?item=' . urlencode($dropdownRow['item']) . '">' . htmlspecialchars($dropdownRow['item']) . '</a></li>';
                }
            } else {
                echo '<li><a class="dropdown-item" href="#">No products available</a></li>';
            }
            ?>
        </ul>
    </div>                   
                            
                    </div>
                    
                <div class="row col-md-12">
                    <div class="col-md-8">
                        
                        <?php include 'db_connect.php'; ?>

<?php
if ($result->num_rows > 0) {
    echo '<div class="container-fluid">';
    echo '<div class="row justify-content-center">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-5 col-lg-3 col-sm-6 col-5">';
        echo '  <div class="card cards">';
        echo '    <img src="' . $row["image"] . '" class="card-img-top image-size" alt="' . $row["product"] . '">';
        echo '    <div class="card-body">';
        echo '      <p class="card-text text-center text-dark">' . $row["product"] . '</p>';
        echo '      <p class="card-text text-center text-dark">$' . $row["current_price"] . '</p>';
        echo '      <div>
                        <a href="#" class="btn btn-danger d-flex justify-content-center add-card" data-image="' . $row["image"] . '" data-product="' . $row["product"] . '" data-price="' . $row["current_price"] . '">Order</a>';
        echo '      </div>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="col-md-12 text-center text-dark">No items found.</div>';
}
?>
</div>
<div class="col-md-4" style="padding-top: 10px;">
    <div class="vonchers">
        <h5 class="text-dark">Voucher</h5>
        <div id="voucher-items">
            <!-- Voucher items will be added here -->
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
    const voucherItems = document.getElementById('voucher-items');

    document.querySelectorAll('.add-card').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const image = this.getAttribute('data-image');
            const product = this.getAttribute('data-product');
            const price = parseFloat(this.getAttribute('data-price'));

            // Check if the product already exists in the voucher
            let existingItem = Array.from(voucherItems.children).find(item => item.querySelector('.product-name').innerText === product);

            if (existingItem) {
                // Increment the quantity
                let quantityElement = existingItem.querySelector('.quantity');
                let value = parseInt(quantityElement.innerText);
                value++;
                quantityElement.innerText = value;

                // Update the price based on the new quantity
                let priceElement = existingItem.querySelector('.product-price');
                let unitPrice = parseFloat(priceElement.getAttribute('data-original-price'));
                let newPrice = value * unitPrice;
                priceElement.innerText = `${newPrice} KS`;
            } else {
                // Add new product to voucher
                const voucherItem = document.createElement('div');
                voucherItem.className = 'd-flex justify-content-center voucher-item';

                voucherItem.innerHTML = `
                    <span class="data-image" style="display: none;">${image}</span>
                    <img src="${image}" alt="menu-image" style="width: 55px; height: 55px; border-radius: 10px;">
                    <p class="product-name" style="display: none;">${product}</p>    
                    <div class="icon"><button class="btn btn-success" onclick="increment(this)">+</button></div>
                    <p class="icon quantity" style="padding-top: 10px;">1</p>
                    <div class="icon"><button class="btn btn-warning" onclick="decrement(this)">-</button></div>
                    <div class="icon">
                        <p class="product-price" data-original-price="${price}">${price} KS</p>
                        <button class="btn btn-outline-danger text-center" style="width: 60px; font-size: 10px;" onclick="removeItem(this)">Delete</button>
                    </div>
                `;
                voucherItems.appendChild(voucherItem);
            }
            updateTotalPrice();
        });
    });
});

function increment(button) {
    let quantityElement = button.parentElement.nextElementSibling;
    let value = parseInt(quantityElement.innerText);
    value++;
    quantityElement.innerText = value;

    // Update the price based on the new quantity
    let priceElement = button.parentElement.parentElement.querySelector('.product-price');
    let unitPrice = parseFloat(priceElement.getAttribute('data-original-price'));
    let newPrice = value * unitPrice;
    priceElement.innerText = `${newPrice} KS`;

    updateTotalPrice();
}

function decrement(button) {
    let quantityElement = button.parentElement.previousElementSibling;
    let value = parseInt(quantityElement.innerText);
    if (value > 1) {
        value--;
        quantityElement.innerText = value;

        // Update the price based on the new quantity
        let priceElement = button.parentElement.parentElement.querySelector('.product-price');
        let unitPrice = parseFloat(priceElement.getAttribute('data-original-price'));
        let newPrice = value * unitPrice;
        priceElement.innerText = `${newPrice} KS`;

        updateTotalPrice();
    }
}

function removeItem(button) {
    button.parentElement.parentElement.remove();
    updateTotalPrice();
}

function updateTotalPrice() {
    const voucherItems = document.querySelectorAll('.voucher-item');
    let totalPrice = 0;

    voucherItems.forEach(item => {
        const quantity = parseInt(item.querySelector('.quantity').innerText);
        const price = parseFloat(item.querySelector('.product-price').innerText.replace(' KS', ''));
        totalPrice += price;
    });

    // Format totalPrice with commas
    const formattedTotalPrice = totalPrice.toLocaleString();

    // Display the formatted total price
    document.querySelector('.total-price').innerText = `Total price : ${formattedTotalPrice} KS`;
}

function saveVoucher() {
    const voucherItems = document.querySelectorAll('.voucher-item');
    const voucherData = [];

    voucherItems.forEach(item => {
        const image = item.querySelector('.data-image').innerText;
        const product = item.querySelector('.product-name').innerText;
        const quantity = item.querySelector('.quantity').innerText;
        const price = item.querySelector('.product-price').innerText.replace(' KS', '');

        voucherData.push({
            image: image,
            product: product,
            quantity: quantity,
            price: price
        });
    });

    document.getElementById('voucher-data').value = JSON.stringify(voucherData);
    document.getElementById('voucher-form').submit();
}

function printVoucher() {
    saveVoucher();
}


        </script>
    </div>
    <div style="padding-top: 15px; padding-bottom: 15px;">
        <h3 class="text-white total-price">Total price : 0 KS</h3>
    </div>
    <form id="voucher-form" method="POST" action="/save_voncher.php">
        <input type="hidden" name="voucher_data" id="voucher-data">
        <div>
            <button type="submit" class="btn btn-warning" style="width: 100%;" onclick="saveVoucher()"><i class="fa-solid fa-bell px-3"></i>Order</button>
        </div>
    </form>
    <form id="voucher-form" method="POST" action="/payment.php">
        <input type="hidden" name="voucher_data" id="voucher-data">
        <div style="padding-top: 10px;">
            <button type="submit" class="btn btn-outline-light" style="width: 100%;" onclick="payment()"><i class="fa-regular fa-money-bill-1 px-3"></i>Cash</button>
        </div>
    </form>
    <form id="voucher-form" method="POST" action="/print_voncher.php">
        <input type="hidden" name="voucher_data" id="voucher-data">
        <div style="padding-top: 10px;">
            <button type="submit" class="btn btn-outline-primary" style="width: 100%;" onclick="printVoucher()"><i class="fa-solid fa-print px-3"></i>Print</button>
        </div>
    </form>

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