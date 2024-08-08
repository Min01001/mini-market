<?php
include 'db_connect.php';

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $barcode = $_POST['barcode'];
    $product = $_POST['product'];
    $item = $_POST['item'];
    $current = $_POST['current'];
    $current_price = $_POST['current_price'];
    $item_count = $_POST['item_count'];
    $date = $_POST['date'];

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
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
                $imagePath = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // No new file uploaded, keep the old file path
        $imagePath = $_POST['existing_image'];
    }

    // Now insert/update the database
    $sql = "UPDATE products SET barcode=?, product=?, item=?, current=?, current_price=?, item_count=?, date=?";
    if ($imagePath) {
        $sql .= ", image=?";
    }
    $sql .= " WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($imagePath) {
        $stmt->bind_param("ssssssssi", $barcode, $product, $item, $current, $current_price, $item_count, $date, $imagePath, $id);
    } else {
        $stmt->bind_param("sssssssi", $barcode, $product, $item, $current, $current_price, $item_count, $date, $id);
    }

    if ($stmt->execute()) {
        echo "<script>window.location.href='view_table.php';</script>";
        echo "Record updated successfully";
    } else {
        echo "Something went wrong: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No product ID provided.";
}
?>
