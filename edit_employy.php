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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employys WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
} else {
    echo "No employee ID provided.";
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
        <form class="d-md-flex ms-4">
            <input class="text-white form-control bg-light border-0" type="search" placeholder="Search">
        </form>
    </nav>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <h3>ဝန်ထမ်းစာရင်းပေါင်းထည့်ရန်</h3>
            <form class="row g-3" method="POST" action="update_employy.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nrc" class="text-white">Nrc</label>
                            <input type="text" class="form-control image-file" name="nrc" value="<?php echo htmlspecialchars($row['nrc']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="text-white">Name *</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="names" value="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father" class="text-white">Father Name *</label>
                            <input type="text" class="form-control" placeholder="Father Name" name="father" value="<?php echo htmlspecialchars($row['father']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="text-white">Address *</label>
                            <input type="text" class="form-control" placeholder="Enter address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthday" class="text-white">Birthday *</label>
                            <input type="date" class="form-control calendar bg-ash" name="birthday" value="<?php echo htmlspecialchars($row['birthday']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position" class="text-white">အလုပ်အကိုင်/ရာထူး</label>
                            <select class="selectpicker form-control" name="position" id="position" data-style="py-0">
                                <option value="manager" <?php if($row['position'] == 'manager') echo 'selected'; ?>>Manager</option>
                                <option value="waiter" <?php if($row['position'] == 'waiter') echo 'selected'; ?>>Waiter</option>
                                <option value="kitchen" <?php if($row['position'] == 'kitchen') echo 'selected'; ?>>Kitchen</option>
                                <option value="helper" <?php if($row['position'] == 'helper') echo 'selected'; ?>>Helper</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="startdate" class="text-white">Start Date *</label>
                            <input type="date" class="form-control calendar bg-ash" name="startdate" value="<?php echo htmlspecialchars($row['startdate']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary" class="text-white">Salary *</label>
                            <input type="text" class="form-control" placeholder="လစာ" name="salary" value="<?php echo htmlspecialchars($row['salary']); ?>">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender" class="text-white">Gender</label>
                            <select class="selectpicker form-control" name="gender" id="gender" data-style="py-0">
                                <option value="male" <?php if($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
                                <option value="female" <?php if($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="text-white">Phone *</label>
                            <input type="text" class="form-control" placeholder="ဖုန်းနံပတ်" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="text-white">Email *</label>
                            <input type="email" class="form-control" placeholder="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group image-type">
                            <label class="text-white">Upload Employee Photo <span>(150 X 150)</span></label>
                            <input type="file" name="image" accept="image/*">
                            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['image']); ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary" name="submit" style="width: 200px; height: 40px;">Update</button>
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