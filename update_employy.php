<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nrc = $_POST['nrc'];
    $namee = $_POST['names'];
    $father = $_POST['father'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $position = $_POST['position'];
    $startdate = $_POST['startdate'];
    $salary = $_POST['salary'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
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

    // Update the database
    $sql = "UPDATE employys SET nrc=?, name=?, father=?, address=?, birthday=?, position=?, startdate=?, salary=?, gender=?, phone=?, email=?";
    if ($imagePath) {
        $sql .= ", image=?";
    }
    $sql .= " WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($imagePath) {
        $stmt->bind_param("ssssssssssssi", $nrc, $namee, $father, $address, $birthday, $position, $startdate, $salary, $gender, $phone, $email, $imagePath, $id);
    } else {
        $stmt->bind_param("sssssssssssi", $nrc, $namee, $father, $address, $birthday, $position, $startdate, $salary, $gender, $phone, $email, $id);
    }

    if ($stmt->execute()) {
        echo "<script>window.location.href='list_employy.php';</script>";
        echo "Record updated successfully";
    } else {
        echo "Something went wrong: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No employee ID provided.";
}
?>
