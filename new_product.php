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

        <?php include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $barcode = $_POST['barcode'];
    $product = $_POST['product'];
    $item = $_POST['item'];
    $current = $_POST['current'];
    $current_price = $_POST['current_price'];
    $item_count = $_POST['item_count'];
    $date = $_POST['date'];

    // Handle file upload
    $target_dir = "uploads/"; // Make sure this directory exists and is writable
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert into database
            $stmt = $conn->prepare("INSERT INTO products (barcode, product, item, current, current_price, item_count, date, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssdss", $barcode, $product, $item, $current, $current_price, $item_count, $date, $target_file);

            if ($stmt->execute()) {
                echo "<script>window.location.href='new_product.php';</script>";
                echo "New record added";
            } else {
                echo "Something went wrong: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" data-bs-theme="dark">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="d-md-flex ms-4">
                    <input class="text-white form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <h3>New Menu Add</h3><br>
                <form class="row g-3" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to submit?')" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="col-md-6">
                <label for="barcode" class="form-label text-white">Barcode</label>
                <input type="text" class="form-control bg-white text-dark" id="barcode" name="barcode">
            </div>
            <div class="col-md-6">
                <label for="product" class="form-label text-white">Product Name</label>
                <input type="text" class="form-control bg-white text-dark" id="product" name="product">
            </div>
            <div class="col-12">
                <label for="item" class="text-white">Item</label>
                <select name="item" id="item" class="selectpicker form-control bg-white text-dark" data-style="py-0">
                    <option value="food">Food</option>
                    <option value="drink">Drink</option>
                    <!-- <option value="ဆေးဝါး">ဆေးဝါး</option> -->
                    <!-- <option value="ဖျော်ရည်">ဖျော်ရည်</option>
                    <option value="အသုံးအဆောင်">အသုံးအဆောင်</option>
                    <option value="လျှပ်စစ်ပစ္စည်း">လျှပ်စစ်ပစ္စည်း</option>
                    <option value="ဖျော်ရည်">ဖျော်ရည်</option>
                    <option value="အသုံးအဆောင်">အသုံးအဆောင်</option>
                    <option value="လျှပ်စစ်ပစ္စည်း">လျှပ်စစ်ပစ္စည်း</option> -->
                </select>
            </div>
            <div class="col-md-6">
                <label for="current" class="form-label text-white">Current</label>
                <input type="text" class="form-control bg-white text-dark" id="current" name="current">
            </div>
            <div class="col-md-6">
                <label for="current_price" class="form-label text-white">Current Price</label>
                <input type="text" class="form-control bg-white text-dark" id="current_price"
                    name="current_price">
            </div>
            <div class="col-md-6">
                <label for="item_count" class="form-label text-white">Item Count</label>
                <input type="text" class="form-control bg-white text-dark" id="item_count" name="item_count" value="1">
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label text-white"></label>
                <input type="hidden" class="form-control bg-white text-dark" id="date" name="date">
            </div>
            <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                var today = new Date();
                var day = ("0" + today.getDate()).slice(-2);
                var month = ("0" + (today.getMonth() + 1)).slice(-2);
                var todayStr = today.getFullYear() + "-" + month + "-" + day;
                document.getElementById("date").value = todayStr;
            });
            </script>
            <div class="col-md-6">
                <label for="image" class="form-label text-white">Image</label>
                <input type="file" class="form-control text-dark" id="image" name="image">
            </div>
            <div class="col-12" style="padding-top: 40px;">
                <button type="submit" class="btn btn-outline-primary" name="submit"
                    style="width: 200px; height: 40px;">Add</button>
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