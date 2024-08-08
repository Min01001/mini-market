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
    <link rel="stylesheet" href="voncher.css">
    <title>view product only</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->

        <?php include 'sidebar.php'; ?>

        <!-- Sidebar -->

        <!-- Main Component -->
        <script>
        $(document).ready(function() {
            // Function to load data based on selected date
            function loadData() {
                const selectedDate = $('#datePicker').val();
                $.ajax({
                    url: 'auto_date_show.php', // Path to your PHP script
                    type: 'GET',
                    data: { date: selectedDate },
                    success: function(response) {
                        $('#dataTable').html(response);
                    },
                    error: function() {
                        $('#dataTable').html('<tr><td colspan="5">Error fetching data</td></tr>');
                    }
                });
            }

            // Load data on page load if a date is already selected
            loadData();

            // Load data when the date picker value changes
            $('#datePicker').on('change', loadData);
        });
    </script>

        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                    <button class="btn" type="button" data-bs-theme="dark">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="day-view">
                <div><a href="day.php"><button class="btn btn-outline-info">View Table</button></a></div>
                    <div><a href="dayview_chat.php"><button class="btn btn-outline-info">View Chat</button></a></div>
                    <div><a href="day_product_view.php"><button class="btn btn-outline-info">Product</button></a></div>
                    <div><a href="day_date.php"><button class="btn btn-outline-info">Date</button></a></div>
                </div>
            </nav>
            <main class="content px-3 py-2">
        <div class="container-fluid">
            <form>
                <div class="form-group">
                    <label for="datePicker" class="text-white">Select Date:</label>
                    <input type="date" id="datePicker" name="date" class="form-control">
                </div>
            </form>
            <div style="overflow-x: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-white">Product</th>
                            <th class="text-white">Quantity</th>
                            <th class="text-white">Price</th>
                            <th class="text-white">Date</th>
                            <!-- <th class="text-white">Image</th> -->
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <!-- Data will be loaded here by AJAX -->
                    </tbody>
                </table>
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