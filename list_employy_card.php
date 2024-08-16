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
    <title>list employy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php include 'sidebar.php'; 
              


        ?>

        <!-- Sidebar -->

        <!-- Main Component -->


        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" data-bs-theme="dark">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="d-none d-md-flex ms-4">
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <h4 class="text-white">Employy view</h4>

                    <?php
                        include 'db_connect.php';

                        // Fetch employees from the database
                        $sql = "SELECT id, name, phone, image FROM employys";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '<div class="container-fluid">';
                            echo '<div class="row align-items-center">';
                            // Loop through each employee record and create a card for each
                            while ($row = $result->fetch_assoc()) {

                                echo '<div class="card" style="width: 100%; max-width: 300px; height: auto; margin-bottom: 15px; margin-left: 10px;">';
                                echo '<div class="row card-body align-items-center">';
                                echo '  <div class="col-4">';
                                echo '    <img src="' . htmlspecialchars($row['image']) . '" class="img-fluid" alt="' . htmlspecialchars($row['name']) . '" style="width: 50px; height: 50px; max-height: 100px; object-fit: cover;">';
                                echo '  </div>';
                                echo '  <div class="col-8">';
                                echo '    <h5 class="card-title mb-1">' . htmlspecialchars($row['name']) . '</h5>';
                                echo '    <p class="mb-1">' . htmlspecialchars($row['phone']) . '</p>';
                                echo '    <div class="d-flex justify-content-between">';
                                echo '      <a href="edit_employy.php?id=' . htmlspecialchars($row['id']) . '"><button class="btn btn-outline-warning btn-sm">Edit</button></a>';
                                echo '      <a href="edit_employy.php?id=' . htmlspecialchars($row['id']) . '"><button class="btn btn-outline-warning btn-sm">Edit</button></a>';
                                echo '      <a href="delete_employy.php?id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this record?\');"><button class="btn btn-outline-danger btn-sm">Delete</button></a>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                                echo '</div>';

                            }
                            echo '</div>';
                            echo '</div>';
                            
                        } else {
                            echo 'No employees found.';
                        }

                        $conn->close();
                        ?>


                        
                    
                    


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