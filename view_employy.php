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
    <title>employy view</title>
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
                    <input class="text-white form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                <?php
                    include 'db_connect.php';

                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                        $id = $_GET['id'];

                        $stmt = $conn->prepare("SELECT * FROM employys WHERE id = ?");
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        } else {
                            echo "No record found.";
                            exit();
                        }

                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "No employee ID provided.";
                        exit();
                    }
                    ?>
                <h1 class="my-4 text-white">Personal Details</h1>
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-white"><?php echo htmlspecialchars($row['name']); ?></h2>
                        <p class="text-white"><strong>NRC NO:</strong> <?php echo htmlspecialchars($row['nrc']); ?></p>
                        <p class="text-white"><strong>Father Name:</strong> <?php echo htmlspecialchars($row['father']); ?></p>
                        <p class="text-white"><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                        <p class="text-white"><strong>Birthday:</strong> <?php echo htmlspecialchars($row['birthday']); ?></p>
                        <p class="text-white"><strong>Position:</strong> <?php echo htmlspecialchars($row['position']); ?></p>
                        <p class="text-white"><strong>Start Date:</strong> <?php echo htmlspecialchars($row['startdate']); ?></p>
                        <p class="text-white"><strong>Salary:</strong> <?php echo htmlspecialchars($row['salary']); ?></p>
                        <p class="text-white"><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
                        <p class="text-white"><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                        <p class="text-white"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
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