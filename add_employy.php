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
    <title>dashboard</title>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the POST data
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

    // Handle image upload
    if (isset($_FILES['propic']) && $_FILES['propic']['error'] == 0) {
        $targetDir = "uploads/"; // Ensure this directory exists and is writable
        $targetFile = $targetDir . basename($_FILES["propic"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $newFileName = $targetDir . uniqid() . '.' . $imageFileType;

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["propic"]["tmp_name"]);
        if ($check !== false) {
            // Check if file already exists
            if (!file_exists($newFileName)) {
                // Check file size (limit to 2MB)
                if ($_FILES["propic"]["size"] <= 2000000) {
                    // Allow certain file formats
                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        // Move the file to the target directory
                        if (move_uploaded_file($_FILES["propic"]["tmp_name"], $newFileName)) {
                            $imagePath = $newFileName;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                            exit();
                        }
                    } else {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        exit();
                    }
                } else {
                    echo "Sorry, your file is too large.";
                    exit();
                }
            } else {
                echo "Sorry, file already exists.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    } else {
        $imagePath = ''; // No image uploaded
    }

    // Prepare and execute SQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO employys (nrc, name, father, address, birthday, position, startdate, salary, gender, phone, email, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $nrc, $namee, $father, $address, $birthday, $position, $startdate, $salary, $gender, $phone, $email, $imagePath);

    if ($stmt->execute()) {
        echo "New record added";
        echo "<script>window.location.href = 'add_employy.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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
            <h3>ဝန်ထမ်းစာရင်းပေါင်းထည့်ရန်</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nrc" class="text-white">Nrc</label>
                            <input type="text" class="form-control image-file" name="nrc" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="text-white">Name *</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="names">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father" class="text-white">Father Name *</label>
                            <input type="text" class="form-control" placeholder="Father Name" name="father">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="text-white">Address *</label>
                            <input type="text" class="form-control" placeholder="Enter address" name="address">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthday" class="text-white">Birthday *</label>
                            <input type="date" class="form-control calendar bg-ash" name="birthday">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position" class="text-white">အလုပ်အကိုင်/ရာထူး</label>
                            <select class="selectpicker form-control" name="position" id="position" data-style="py-0">
                                <option value="manager">Manager</option>
                                <option value="waiter">Waiter</option>
                                <option value="kitchen">Kitchen</option>
                                <option value="helper">Helper</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="startdate" class="text-white">Start Date *</label>
                            <input type="date" class="form-control calendar bg-ash" name="startdate">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary" class="text-white">Salary *</label>
                            <input type="text" class="form-control" placeholder="လစာ" name="salary">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender" class="text-white">Gender</label>
                            <select class="selectpicker form-control" name="gender" id="gender" data-style="py-0">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="text-white">Phone *</label>
                            <input type="text" class="form-control" placeholder="ဖုန်းနံပတ်" name="phone">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="text-white">Email *</label>
                            <input type="email" class="form-control" placeholder="email" name="email">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group image-type">
                            <label class="text-white">Upload Teacher Photo <span>(150 X 150)</span></label>
                            <input type="file" name="propic" accept="image/*">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary" name="submit" style="width: 200px; height: 40px;">Add</button>
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