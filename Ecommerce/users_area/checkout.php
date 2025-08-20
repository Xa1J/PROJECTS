<?php
include('../includes/connect.php');
session_start();
if (!$con) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../icons.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-size: 16px;
            background-color: #f8f9fa;
        }
        .logo {
            width: 7%;
            height: auto;
        }
        .content-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .checkout-container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            margin-bottom: 20px;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">
                    <img src="../main-page-pictures/FIRSTLOGOB2.png" alt="logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../display_all.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="../users_area/user_registration.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    </ul>
                    <form class="d-flex" action="search_product.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                        <button class="btn btn-outline-light" type="submit" name="search_data_product">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Welcome Message -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome Guest</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='./users_area/logout.php'>Welcome " . $_SESSION['username'] . "</a></li>";
                }
                ?>
                <li class="nav-item"><a class="nav-link" href="./users_area/user_login.php">Login</a></li>
            </ul>
        </nav>

        <!-- Checkout Content -->
        <div class="content-container">
            <div class="checkout-container">
                <?php
                if (!isset($_SESSION['username'])) {
                    include('user_login.php');
                } else {
                    include('payment.php');
                }
                ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <?php include("../includes/footer.php"); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
