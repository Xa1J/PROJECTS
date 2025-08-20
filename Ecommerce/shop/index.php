<?php
include('../includes/connect.php');
include('../functions/common_functions.php'); // Adjusted path
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
    <title>Hidden Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../font.css">
<style>
  .logo{
    width: 7%;
    height: 7%;
}


</style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <img src="../front-page1/FIRSTLOGOB2.png" alt="logo" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php"><span class="nav-text"><h1>Home</h1></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php"><span class="nav-text"><h1>Products</h1></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-text"><h1>About Us</h1></span></a></li>
                    <?php if(!isset($_SESSION['username'])){
                        echo "
                        <li class='nav-item'><a class='nav-link' href='../users_area/profile.php'><span class='nav-text'><h1>My Account</h1></span></a></li>
                        ";   
                    }else{
                        echo "<li class='nav-item'><a class='nav-link' href='../users_area/user_registration.php'><span class='nav-text'><h1>Register</h1></span></a></li>"; 
                    }
                    ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="../cart.php">
                            <span class="material-symbols-outlined"><span class="nav-text"><h1>shopping_cart</h1></span></span>
                            <sup class="cart-item-count"><?php cart_item(); ?></sup>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-text"><h1>Total Price: <?php total_cart_price(); ?>/-</h1></span></a></li>
                </ul>
                <form class="d-flex" action="../search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                </form>
            </div>
        </div>
    </nav>

        <!-- Calling cart function -->
        <?php cart(); ?>

        <!-- Welcome Message -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                <?php
                    if(!isset($_SESSION['username'])){
                        echo"  <li class='nav-item'><a class='nav-link' href='#'>Welcome Guest</a></li>
                        </li>";
                    }else{
                        echo"<li class='nav-item'><a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>
                        </li>";
                    }
                    if(!isset($_SESSION['username'])){
                        echo"<li class='nav-item'><a class='nav-link' href='../users_area/user_login.php'>Login</a>
                        </li>";
                    }else{
                        echo"<li class='nav-item'><a class='nav-link' href='../users_area/logout.php'>Logout</a>
                        </li>";
                    }
                    ?>
            </ul>
        </nav>
        <!-- Products and Sidebar -->
        <div class="row m-0">
            <div class="col-md-10">
                <div class="row ">
                    <?php
                    getproducts();
                    get_unique_categories();
                    get_unique_brands();
                    ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-2 bg-secondary p-0">
                <h5 class="text-center text-light bg-dark py-2">FILTERS</h5>
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info"><a href="#" class="nav-link text-light"><h4>Delivery Brands</h4></a></li>
                    <?php getbrands(); ?>
                    <li class="nav-item bg-info"><a href="#" class="nav-link text-light"><h4>Categories</h4></a></li>
                    <?php getcategories(); ?>
                </ul>
            </div>
        </div>
        
        </div>
        
      
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
