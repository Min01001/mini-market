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
    <title>outcome</title>
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
                    <input class="text-dark form-control bg-light border-0" type="search" placeholder="Search">
                </form>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row" style="padding-top: 15px">
                        <div class="col-md-5">
                            <?php

                            $sqlTotal = "SELECT SUM(outcome) AS total_price FROM outcomes";
                            $resultTotal = $conn->query($sqlTotal);
                            $totalPrice = $resultTotal->fetch_assoc();

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST['submit'])) {
                                        // Retrieve and sanitize form data
                                        $note = $_POST['note'];
                                        $outcome = $_POST['outcome'];
                                        $date = $_POST['date'];

                                            // Insert data into the database
                                        $stmt = $conn->prepare("INSERT INTO outcomes (note, outcome, date) VALUES (?, ?, ?)");
                                        $stmt->bind_param("sss", $note, $outcome, $date);

                                        if ($stmt->execute()) {
                                            echo "<script>window.location.href='outcome.php';</script>";
                                            exit();
                                        } else {
                                                echo "Error: " . $stmt->error;
                                        }

                                        $stmt->close();

                                        $conn->close();
                                    }
                                }
                                ?>
                            

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" onsubmit="return confirm('Are you sure you want to submit?')">
                            <div class="row mb-3">
                                <label for="noteInput" class="col-sm-2 col-form-label text-white">Note</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control bg-dark text-white" id="noteInput" name="note">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="outcomeInput" class="col-sm-2 col-form-label text-white">Outcome</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control bg-dark text-white" id="outcomeInput" name="outcome">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="date" class="col-sm-2 col-form-label text-white">Date</label>
                                <div class="col-sm-10">
                                <input type="date" class="form-control text-dark" id="date" name="date">
                                </div>
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

                            <button type="submit" class="btn btn-primary" name="submit">Add</button>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <div>
                                <h3 class="#" style="color: #0add08">Total: <?php echo number_format ($totalPrice['total_price'], 0, ',', ',') . " KS"; ?></h3>
                            </div>

                        <?php 
                            $sql = "SELECT * FROM outcomes";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo '<div style="overflow-x: auto; max-height: 400px;">'; 
                                echo '<table class="table table-dark table-striped table-hover" style="border-radius: 10px;">'; 
                                echo '<tr>';
                                echo '<th class="text-white">Note</th>';
                                echo '<th class="text-white">Outcome</th>';
                                echo '<th class="text-white">Date</th>';
                                echo '<th class="text-white">Action</th>';
                                echo '</tr>';

                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td contenteditable="true" class="text-white" data-id="' . $row['id'] . '" data-column="note">' . htmlspecialchars($row['note']) . '</td>';
                                    echo '<td contenteditable="true" class="text-white" data-id="' . $row['id'] . '" data-column="outcome">' . htmlspecialchars($row['outcome']) . '</td>';
                                    echo '<td contenteditable="true" class="text-white" data-id="' . $row['id'] . '" data-column="date">' . htmlspecialchars($row['date']) . '</td>';
                                    echo "<td>";
                                    echo "<form method='POST' onsubmit=\"return confirm('Are you sure you want to delete?')\" action='delete_outcome.php'>";
                                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>";
                                    echo "<button type='submit' class='btn btn-danger btn-sm'>Delete</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo '</tr>';
                                }

                                echo '</table>';
                                echo '</div>'; 
                            } else {
                                echo 'No products found.';
                            }

                            $conn->close();
                            ?>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                            $(document).ready(function() {
                                $('td[contenteditable="true"]').on('blur', function() {
                                    var id = $(this).data('id');
                                    var column = $(this).data('column');
                                    var newValue = $(this).text();

                                    $.ajax({
                                        url: 'update_outcome.php',  // PHP script to update the database
                                        type: 'POST',
                                        data: {
                                            id: id,
                                            column: column,
                                            value: newValue
                                        },
                                        success: function(response) {
                                            if(response === 'success') {
                                                
                                            } else {
                                                alert('Failed to update data.');
                                            }
                                        },
                                        error: function() {
                                            alert('Error in AJAX request.');
                                        }
                                    });
                                });
                            });
                            </script>



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